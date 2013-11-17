<?php
/**************************************************
*  Created:  2011-04-06
*
*  通知信息操作
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author guanghui <guanghui1@staff.sina.com.cn>
*
***************************************************/

class notice
{
	var $tb_notice;
	var $tb_recipients;
	var $db;
	
	function notice()
	{
		$this->db = APP::ADP('db');
		$this->tb_notice = $this->db->getTable(T_NOTICE);
		$this->tb_recipients = $this->db->getTable(T_NOTICE_RECIPIENTS);
	}
	
	/**
	* 发送一条通知
	* 
	* @param string $title 通知标题
	* @param string $content  通知内容
	* @param mixed $sina_id 接收者的sina_uid，可以是单个或数组，0表示全站用户
	* @param mixed $screen_name 接收者的微博昵称，可以是单个或数组
	* @param int $sender_id 发送人的sisna_uid，默认0表示为系统发送
	* @param int $available_time 通知生效时间
	*/
	function sendNotice($title, $content, $sina_uid = NULL, $screen_name = NULL, $sender_id = 0, $available_time = 0)
	{
		if ((empty($title) || empty($content)) && ($title !=='0' && $content!=='0')) {
			return RST(false, 1210000, 'Parameter can not be empty!');
		}
		
		if (is_null($sina_uid) && is_null($screen_name)) {
			return RST(false, 1210000, 'Parameter can not be empty!');
		}
		
		$send_all = $sina_uid === 0 ? true : false; //是否发送给全站用户
		
		if (is_null($sina_uid)) {
			$sina_uid = array();
		} else if (!is_array($sina_uid)) {
			$sina_uid = (array)$sina_uid;
		}
		
		if (!is_null($screen_name) && !$send_all) {
			if (!is_array($screen_name)) {
				$screen_name = (array)$this->db->escape($screen_name);
			} else {
				foreach ($screen_name as $k => $v) {
					$screen_name[$k] = $this->db->escape($v);
				}
			}
			$sql = "SELECT `sina_uid` FROM `" . $this->db->getTable(T_USERS) . "` WHERE `nickname` IN ('" . implode("','", $screen_name) . "')";
			
			$result = $this->db->query($sql);
			foreach ($result as $row) {
				$sina_uid[] = $row['sina_uid'];
			}
		}
		
		$sina_uid = array_unique($sina_uid);
		if (empty($sina_uid)) {
			return RST(false, 1210001, '该批用户尚未登录本站，不能发送通知');
		}
		
		$data = array();
		$data['sender_id'] = $sender_id;
		$data['title'] = $title;
		$data['content'] = $content;
		$data['add_time'] = APP_LOCAL_TIMESTAMP;
		$data['available_time'] = empty($available_time) ? APP_LOCAL_TIMESTAMP : $available_time;
		
		$notice_id = $this->db->save($data, 0, T_NOTICE);
		if ($notice_id === false) {
			return RST(false, 1210004, '发送失败，请重试');
		}
		
		$values = array();
		foreach ($sina_uid as $uid) {
			$values[] = "('$notice_id', '$uid')";
		}
		
		$sql = "INSERT INTO `" . $this->tb_recipients . "` (`notice_id`, `recipient_id`) VALUES " . implode(',', $values);
		
		$send_result = $this->db->execute($sql);
		if ($send_result) {
			$this->_cleanCache();
			return RST(true);
		} else {
			return RST(false, 1210004, '发送失败，请重试');
		}
	}
	
	/**
	* 修改通知
	* 
	* @param int $notice_id 通知ID
	* @param string $title 通知标题
	* @param string $content  通知内容
	*/
	function updateNotice($notice_id, $title, $content)
	{
		$data = array();
		$data['title'] = $title;
		$data['content'] = $content;
		
		$update_result = $this->db->save($data, $notice_id, T_NOTICE, 'notice_id');
		if ($notice_id === false) {
			return RST(false, 1210004, '修改失败，请重试');
		} else {
			return RST(true);
		}
	}
	
	/**
	* 删除通知
	* 
	* @param int $notice_id 通知ID
	*/
	function deleteNotice($notice_id)
	{
		if ($this->db->delete($notice_id, T_NOTICE, 'notice_id')) {
			$del_result = $this->db->delete($notice_id, T_NOTICE_RECIPIENTS, 'notice_id');
			$this->_cleanCache();
			return RST($del_result);
		} else {
			return RST(false, 50000001, '通知不存在');
		}
	}
	
	/**
	* 获取通知记录数
	* 
	* @param int $sina_uid  用户ID，0表示管理员
	*/
	function getNoticeNum($sina_uid = 0)
	{
		$firstTimeSql = $this->_getUserNoticeStart($sina_uid);
		$sql = "SELECT COUNT(*) FROM `" . $this->tb_notice . "` WHERE 1=1" . ($sina_uid > 0 ? " AND `notice_id` IN (SELECT `notice_id` FROM `" . $this->tb_recipients . "` WHERE `recipient_id` = 0 OR `recipient_id` = '" . $this->db->escape($sina_uid) . "') $firstTimeSql AND `available_time` <= " . APP_LOCAL_TIMESTAMP : '');
		
		return RST($this->db->getOne($sql));
	}
	
	/**
	* 获取通知列表
	* 
	* @param int $sina_uid  用户ID，0表示管理员
	* @param int $offset
	* @param int $limit
	*/
	function getNoticeList($sina_uid = 0, $offset = 0, $limit = 20)
	{
		$firstTimeSql = $this->_getUserNoticeStart($sina_uid);
		$sql = "SELECT * FROM `" . $this->tb_notice . "` WHERE 1=1" . ($sina_uid > 0 ? " AND `notice_id` IN (SELECT `notice_id` FROM `" . $this->tb_recipients . "` WHERE `recipient_id` = 0 OR `recipient_id` = '" . $this->db->escape($sina_uid) . "') $firstTimeSql AND `available_time` <= " . APP_LOCAL_TIMESTAMP : '') . " ORDER BY `available_time` DESC LIMIT " . $offset . "," . $limit;
		
		return RST($this->db->query($sql));
	}
	
	
	/**
	 * 获取用户第一次登陆的available_time sql, 确保新注册的用户不接受之前的通知
	 * @param unknown_type $sina_uid
	 */
	function _getUserNoticeStart($sina_uid)
	{
		$firstTimeSql = '';
		if ($sina_uid)
		{
			$rst = DR('mgr/userCom.getByUid', FALSE, $sina_uid);
			if ( isset($rst['rst']['first_login']) && $rst['rst']['first_login'] )
			{
				$firstTimeSql = " And `available_time` >='{$rst['rst']['first_login']}' ";
			}
		}
		return $firstTimeSql;
	}
	
	
	/**
	* 获取通知内容
	* 
	* @param int $notice_id
	*/
	function getNotice($notice_id)
	{
		return RST($this->db->get($notice_id, T_NOTICE, 'notice_id'));
	}
	
	/**
	* 获取系统已生效的通知的最大时间戳
	* 
	*/
	function getSysMaxTime()
	{
		$sql = "SELECT `available_time` FROM `" . $this->tb_notice . "` WHERE `available_time` <= " . APP_LOCAL_TIMESTAMP . " ORDER BY `available_time` DESC LIMIT 1";
		return RST($this->db->getOne($sql));
	}
	
	/**
	* 根据通知ID获取接收人列表
	* 
	* @param int $notice_id
	*/
	function getRecipientsByNoticeId($notice_id)
	{
		$sql = "SELECT a.*,b.`nickname` FROM `" . $this->tb_recipients . "` a LEFT JOIN `" . $this->db->getTable(T_USERS) . "` b ON a.`recipient_id`=b.`sina_uid` WHERE a.`notice_id`='" . $this->db->escape($notice_id) . "'";
		return RST($this->db->query($sql));
	}
	
	/**
	* 获取用户的未读通知数
	* 
	* @param int $sina_uid  用户ID
	* @param int $maxNoticeTime  用户上一次读取的通知的生效时间
	*/
	function getUnreadNoticeNum($sina_uid, $maxNoticeTime)
	{
		$sql = "SELECT COUNT(DISTINCT(`notice_id`)) FROM `" . $this->tb_recipients . "` WHERE (`recipient_id` = '" . $this->db->escape($sina_uid) . "' OR `recipient_id` = 0) AND `notice_id` IN (SELECT `notice_id` FROM " . $this->tb_notice . " WHERE `available_time` <= " . APP_LOCAL_TIMESTAMP . " AND `available_time` > {$maxNoticeTime})";
		return RST($this->db->getOne($sql));
	}
	
	/**
	* 更新用户最后读取的通知生效时间
	* 
	* @param mixed $sina_uid
	* @param mixed $max_id
	*/
	function updateUserPreMaxTime($sina_uid, $max_time)
	{
		$data = array('max_notice_time' => $max_time);
		return RST($this->db->save($data, $sina_uid, T_USERS, 'sina_uid'));
	}
	
	/**
	* 清除缓存
	* 
	*/
	function _cleanCache()
	{
		DD('notice.getNoticeNum');
		DD('notice.getNoticeList');
		DD('notice.getSysMaxTime');
	}
}