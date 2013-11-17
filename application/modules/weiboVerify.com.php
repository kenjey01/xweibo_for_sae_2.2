<?php
/**************************************************
*  Created:  2011-05-16
*
*  先审后发时，待审微博管理 
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author heli1 <heli1@staff.sina.com.cn>
*
***************************************************/

class weiboVerify 
{
	
	var $db;
	var $count_sql;

	function weiboVerify()
	{
		$this->db = APP::ADP('db');
	}

	/**
	 * 获取待审核微博列表
	 *
	 * @params string $sina_uid
	 * @params string $keyword
	 * @params int $start_time
	 * @params int $end_time
	 * @params int $limit
	 *
	 * @return array
	 *
	 */
	function getWeiboVerifyList($params= array(), $offset = 0, $limit = 20)
	{
		$where_sql = $this->_buildWhere($params);
		$sql 	= 'SELECT * FROM ' . $this->db->getTable(T_WEIBO_VERIFY) . $where_sql . ' ORDER BY dateline DESC LIMIT ' . $offset . ', '. $limit; 
		$this->count_sql = 'SELECT * FROM ' . $this->db->getTable(T_WEIBO_VERIFY) . $where_sql; 
		$result	= $this->db->query($sql);

		return RST($result);
	}

	/**
	 * 获取待审核微博列表
	 *
	 * @params string $sina_uid 
	 *
	 * @return  array
	 */
	function getWeiboVerifyFeed($sina_uid)
	{
		$list = $this->getWeiboVerifyList(array('sina_uid' => $sina_uid));
		$feed = array();
		if (!empty($list['rst'])) {
			$user_ids = array();
			$rt_ids = array();
			foreach ($list['rst'] as $var) {
				$user_ids[] = $var['sina_uid'];
				if (!empty($var['retweeted_wid'])) {
					$rt_ids[] = $var['retweeted_wid'];
				}
			}
			$user_ids = array_unique($user_ids);
			/// 转发微博id
			if (!empty($rt_ids)) {
				$rt_ids = array_unique($rt_ids);
			}

			$user_result = array();
			$rt_result = array();

			/// 获取用户信息
			$user_list  = F('get_user_show', implode(',', $user_ids));
			if (empty($user_list['errno'])) {
				$user_list = $user_list['rst'];
				foreach ($user_list as $var) {
					$user_result[$var['id']] = $var;
				}
			}
			/// 获取转发微博信息
			if (!empty($rt_ids)) {
				$rt_list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $rt_ids));
				if (empty($rt_list['errno'])) {
					$rt_list = $rt_list['rst'];
					foreach ($rt_list as $var) {
						$rt_result[$var['id']] = $var;
					}
				}
			}

			foreach ($list['rst'] as $var) {
				if ($var['retweeted_wid']) {
					$feed[] = $this->_makeWeiboFormat($var, $user_result[$var['sina_uid']], $rt_result[$var['retweeted_wid']]);
				} else {
					$feed[] = $this->_makeWeiboFormat($var, $user_result[$var['sina_uid']]);
				}
			}
		}
		return RST($feed);
	}

	/**
	 * 复到最后一次查询的统计
	 *
	 * @return array 
	 */
	function getCount() {
		if (empty($this->count_sql)) {
			return 0;
		}
		return RST($this->db->getOne($this->count_sql));
	}

	/**
	 * 获取指定待审核微博信息
	 * @params 待审核微博id $id
	 *
	 * @params array
	 */
	function getWeiboVerifyById($id)
	{
		$sql = 'SELECT * FROM ' . $this->db->getTable(T_WEIBO_VERIFY). ' WHERE id = "'.$this->db->escape($id).'"';
		$data = $this->db->getRow($sql);
		return RST($data);
	}

	/**
	 * 添加待审核微博
	 *
	 * @params array $data
	 *
	 * @return array
	 */
	function addWeiboVerify($data) 
	{
		$save_result = $this->db->save($data, false, T_WEIBO_VERIFY, 'id');
		if ($save_result) {
			//$this->_cleanCache(); //保存成功后清除缓存
		}
		
		return RST($save_result);
	}

	/**
	 * 更新审核微博
	 *
	 * @params int $id
	 * @params string $acton 操作,'pass' 通过审核, 'delete' 删除审核
	 *
	 * @return 
	 */
	function updateWeiboVerify($id, $action = 'pass')
	{
		$weiboInfo = $this->getWeiboVerifyById($id);
		if (empty($weiboInfo['rst'])) {
			return false;
		}
		$weiboInfo = $weiboInfo['rst'];

		/// 通过审核
		if ('pass' == $action) {
			DR('xweibo/xwb.setToken', false, 3, $weiboInfo['access_token'], $weiboInfo['token_secret']);

			if (!empty($weiboInfo['retweeted_wid'])) {
				///是否同时评论
				$is_comment = 0;

				/// 如果勾选了作为某人的评论
				if (!empty($weiboInfo['cwid'])) {
					$rtid_array = explode(',', $weiboInfo['cwid']);
					if (count($rtid_array) > 1) {
						/// 同时发表评论给当前微博和原微博
						$is_comment = 3;
					} elseif ($rtid_array[0] == $id) {
						/// 发表评论给原微博
						$is_comment = 2;
					} else {
						/// 发表评论给当前微博
						$is_comment = 1;
					}
				}

				/// 转发微博
				$result = DR('xweibo/xwb.repost', '', $weiboInfo['retweeted_wid'], $weiboInfo['weibo'], $is_comment);

			} else {
				/// 发微博
				if (empty($weiboInfo['picid'])) {
					/// 调用发布微博api
					$result = DR('xweibo/xwb.update', '', $weiboInfo['weibo']);
				} 
				else {
					/// 调用发布图片微博api
					$result = DR('xweibo/xwb.uploadUrlText', '', $weiboInfo['weibo'], $weiboInfo['picid']);
				}
			}

			/// 微博发布成功
			if (empty($result['errno'])) {
				/// 如果是微博直播
				if ($weiboInfo['type'] == 'live') {
					$xwbAdditive = APP::N('xwbAdditive');
					$extra_params = json_decode($weiboInfo['extend_data'], true);
					$fun_name = 'extra_live';
					$extra_params_array = array($extra_params, $result['rst'], $weiboInfo['sina_uid'], 1);
					call_user_func_array(array($xwbAdditive, $fun_name), $extra_params_array);
				}

				/// 如果是微访谈
				if ($weiboInfo['type'] == 'interview') {
					$xwbAdditive = APP::N('xwbAdditive');
					$extra_params = json_decode($weiboInfo['extend_data'], true);
					$fun_name = 'extra_interView';
					$extra_params_array = array($extra_params, $result['rst'], $weiboInfo['sina_uid'], 'A');
					call_user_func_array(array($xwbAdditive, $fun_name), $extra_params_array);
				}
				
				/// 如果是活动
				if ($weiboInfo['type'] == 'event') {
					$xwbAdditive  = APP::N('xwbAdditive');
					$extra_params = json_decode($weiboInfo['extend_data'], true);
					$fun_name 	  = 'extra_event';
					$extra_params_array = array($extra_params, $result['rst']);
					call_user_func_array(array($xwbAdditive, $fun_name), $extra_params_array);
				}
				

				///备份微博
				$this->_backupWeibo($result['rst']);
			}
			
			///删除审核微博记录
			$ret = $this->deleteWeiboVerify($id);

		} elseif ('delete' == $action) {
			/// 删除待审核
			/// 移动到delete表
			$this->verifyCopyToDelete($weiboInfo);
			///删除审核微博记录
			$ret = $this->deleteWeiboVerify($id);
		}
		return RST($ret);
	}

	/**
	 * 迁移审核微博数据到删除审核微博表
	 *
	 * @params array $data
	 * @params int $id
	 * @params string $id_name
	 *
	 */
	function verifyCopyToDelete($data, $id = '', $id_name = 'id')
	{
		$params = array();
		$params['weibo'] = $data['weibo']; 
		$params['picid'] = $data['picid']; 
		$params['sina_uid'] = $data['sina_uid']; 
		$params['nickname'] = $data['nickname']; 
		$params['retweeted_status'] = $data['retweeted_status']; 
		$params['retweeted_wid'] = $data['retweeted_wid']; 
		$params['access_token'] = $data['access_token']; 
		$params['token_secret'] = $data['token_secret']; 
		$params['dateline'] = APP_LOCAL_TIMESTAMP;
		$save_result = $this->db->save($params, $id, T_WEIBO_DELETE, $id_name);
		if ($save_result) {
			//$this->_cleanCache(); //保存成功后清除缓存
		}
		
		return RST($save_result);
	}

	/**
	 * 删除审核微博记录
	 *
	 * @params int $id
	 *
	 * @return bool
	 */
	function deleteWeiboVerify($id)
	{
		$sql = 'DELETE FROM ' . $this->db->getTable(T_WEIBO_VERIFY) . ' WHERE id = ' . $id;
		$ret = $this->db->execute($sql);
		if ($ret) {
			//$this->_cleanCache(); //保存成功后清除缓存
		}
		return RST($ret);
	}

	/**
	 * 删除记录
	 * @param $uid int 用户ID
	 *  
	 */
	function deleteByUid($uid) {
		$rs= $this->db->delete($uid, T_WEIBO_VERIFY, 'sina_uid');
		return RST($rs);
	}

	/**
	 * 获取待审核微博记录总数
	 *
	 * @params string $sina_uid
	 *
	 */
	function getWeiboVerifyCount($params = array())
	{
		$where = $this->_buildWhere($params);
		$sql = 'SELECT COUNT(*) FROM ' . $this->db->getTable(T_WEIBO_VERIFY) . $where; 
		return RST($this->db->getOne($sql));
	}

	/**
	 * 备份微博
	 *
	 *
	 */
	function _backupWeibo($result)
	{
		if (empty($result)) {
			return false;
		}

		$data_weibo = array();
		$data_weibo['id'] 		= $result['id'];
		$data_weibo['weibo'] 	= $result['text'];
		$data_weibo['uid'] 		= $result['user']['id'];
		$data_weibo['nickname'] = $result['user']['screen_name'];
		$data_weibo['addtime'] 	= APP_LOCAL_TIMESTAMP;
		$data_weibo['pic'] 		= isset($result['thumbnail_pic']) ? $result['thumbnail_pic'] : '';
		$data_weibo['disabled'] = 0;
		$this->db->save($data_weibo, false, T_WEIBO_COPY);
	}

	/**
	 * 构建微博内容结构
	 *
	 * @params array $data 微博内容
	 * @params array $user 用户信息
	 * @params array $rts 转发微博信息
	 *
	 * @return array 
	 */
	function _makeWeiboFormat($data, $users, $rts = array())
	{
		$wb = array();
		$wb['created_at'] =  date('D M d H:i:s O Y', $data['dateline']);
		$wb['id'] = $data['id'];
		$wb['text'] = $data['weibo'];
		$wb['xwb_weibo_verify'] = 1;
		$wb['source'] = '';
		if ($data['picid']) 
		{
			$isHttp					= count(explode('://', $data['picid']))>1;
			$wb['xwb_picid'] 		= $data['picid'];
			$wb['thumbnail_pic'] 	= $isHttp ? $data['picid'] : F('profile_image_url.thumbnail_pic', $data['picid']);
			$wb['bmiddle_pic'] 		= $isHttp ? $data['picid'] : F('profile_image_url.thumbnail_pic', $data['picid'], 'bmiddle');
			$wb['original_pic'] 	= $isHttp ? $data['picid'] : F('profile_image_url.thumbnail_pic', $data['picid'], 'large');
		}
		$wb['user'] = $users;
		if (!empty($rts)) {
			$wb['retweeted_status'] = $rts;
		}
		return $wb;
	}

	/**
	 * 构建where 语句
	 * @param array $params
	 */
	function _buildWhere($params)
	{
		$where = array();
		/// 关键字
		if (isset($params['keyword']) && $params['keyword']) {
			$where[] = "(weibo LIKE '%" . $this->db->escape($params['keyword']) . "%' OR nickname LIKE '%" . $this->db->escape($params['keyword']) . "%')";
		}

		/// 发布的用户微博id
		if (isset($params['sina_uid']) && $params['sina_uid']) {
			$where[] = 'sina_uid = "' . $params['sina_uid']. '"';
		}

		/// 类别
		if (isset($params['type']) && $params['type']) {
			$where[] = '`type` = "' . $this->db->escape($params['type']). '"';
		} else {
			$where[] = '(`type` = "" or `type` IS NULL or `type`="event")';
		}

		if (isset($params['extend_id']) && $params['extend_id']) {
			$where[] = 'extend_id = "' . $this->db->escape($params['extend_id']) . '"';
		}

		/// 发布时间
		$startTime = isset($params['startTime']) ? $params['startTime'] : false;
		$endTime = isset($params['endTime']) ? $params['endTime'] : false;
		if ($startTime && empty($endTime)) {
			$where[] = 'dateline >= ' . $startTime;
		} elseif ($endTime && empty($startTime)) {
			$where[] = $endTime . '>= dateline';
		} elseif ($startTime && $endTime) {
			$where[] = '('.$endTime . '>= dateline && dateline >= ' . $startTime.')';
		}
		
		$where_sql = !empty($where) ? (' AND ' . implode(' AND ', $where)) : '';
		$where_sql = ' WHERE 1=1'.$where_sql;
		
		return $where_sql;
	}
	
}

?>
