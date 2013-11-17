<?php
/**
 * @file			xwbBBSpluginApi.xapi.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2011-01-25
 * @Modified By:	heli/2011-01-25
 * @Brief			插件通讯调用的方法		
 */

class xwbBBSplugin {

	var $db;
	function xwbBBSplugin()
	{
		$this->db = APP::ADP('db');
		$this->db->setTable('users');
	}

	/**
	 * 检查api是否可使用
	 *
	 *
	 */
	function checkApi() 
	{
		$switch = DS('common/sysConfig.get', '', 'xwb_discuz_enable');
		$url = DS('common/sysConfig.get', '', 'xwb_discuz_url');
		$ret = array('switch' => $switch, 'url' => $url);

		return $ret;
	}

	/**
	 * 开启或关闭跟插件的通讯 
	 *
	 * @params int $value
	 *
	 * @return 
	 */
	function setNotice($value = 1, $url = null)
	{
		/// 开启插件
		if ($value == 1 && $url) {
			if (empty($url)) {
				APP::ajaxRst(false, '5010000', 'Parameter can not be empty');
			}
			/// 更新通讯的接口地址
			$data = array(
				'xwb_discuz_url' => $url,
				'xwb_discuz_enable' => true
			);

			$rst = DS('common/sysConfig.set', '', $data);
		} else {
			/// 关闭插件
			$rst = DR('common/sysConfig.set', '', 'xwb_discuz_enable', false);
		}
		
		if (!empty($rst['errno'])) {
			APP::ajaxRst(false, '5010005', 'Update faileds');
		}
		/// 开启插件通讯，返回xweibo通讯的根url
		if ($value == 1) {
			return array('baseurl'=>W_BASE_HTTP.W_BASE_URL_PATH);
		}
		return true;
	}

	/**
	 * 添加更新绑定用户信息
	 *
	 * @params int|string $site_uid
	 * @params int|string $sina_uid
	 * @params string $access_token
	 * @params string $token_secret
	 * @params string $nickname
	 *
	 * @return bool
	 */
	function updateBindUser($site_uid = false, $sina_uid = false, $access_token = false, $token_secret = false, $nickname = false)
	{
		///是否开启同步通讯
		if (1 != DS('common/sysConfig.get', '', 'xwb_discuz_enable')) {
			APP::ajaxRst(false, '5010008', 'Connection close');
		}

		if (empty($site_uid) || empty($sina_uid) || empty($access_token) || empty($token_secret)) {
			APP::ajaxRst(false, '5010000', 'Parameter can not be empty');
		}

		$data = array();
		$data['sina_uid'] = $sina_uid;
		$data['uid'] = $site_uid;
		$data['access_token'] = $access_token;
		$data['token_secret'] = $token_secret;
		if ($nickname) {
			$data['nickname'] = $nickname;
		} else {
			$sql = 'SELECT * FROM ' . $this->db->getTable() . ' WHERE `sina_uid` = "' . $sina_uid.'"';
			$row = $this->db->getRow($sql);
			if (!empty($row)) {
				$data['nickname'] = $row['nickname'];
				$data['first_login'] = $row['first_login'];
			}
		}

		$this->db->delete($site_uid, '', 'uid');
		$this->db->delete($sina_uid, '', 'sina_uid');

		$ret = $this->db->save($data);

		if ($ret === false){
			APP::ajaxRst(false, '5010005', 'Update faileds');
		}

		return true; 
	}

	/**
	 * 删除绑定用户
	 *
	 * @params int|string $site_uid 合作方用户id
	 *
	 * @return 
	 */
	function delBindUser($site_uid = false)
	{
		///是否开启同步通讯
		if (1 != DS('common/sysConfig.get', '', 'xwb_discuz_enable')) {
			APP::ajaxRst(false, '5010008', 'Connection close');
		}

		if (empty($site_uid)) {
			APP::ajaxRst(false, '5010000', 'Parameter can not be empty');
		}

		if ($this->db->delete($site_uid, '', 'uid')) {
			return true;
		}

		APP::ajaxRst(false, '5010004', 'Del faileds');
	}

	/**
	 * 获取指定的绑定用户信息
	 *
	 * @params int|string $id 要查询的用户id
	 * @params string $type 查询的类型
	 *
	 * @return array
	 */
	function getBindUser($id = false, $type = 'site_uid')
	{
		///是否开启同步通讯
		if (1 != DS('common/sysConfig.get', '', 'xwb_discuz_enable')) {
			APP::ajaxRst(false, '5010008', 'Connection close');
		}

		if (empty($id)) {
			APP::ajaxRst(false, '5010000', 'Parameter can not be empty');
		}

		if ('sina_uid' == $type) {
			$where = ' `sina_uid` = "' . $id . '" AND uid != "" AND access_token != "" AND token_secret != ""';
		} else {
			$where = ' `uid` = "' . $id . '"';
		}

		$sql = 'SELECT * FROM ' . $this->db->getTable() . ' WHERE ' . $where;
		return $this->db->getRow($sql);
	}

	/**
	 * 批量获取指定绑定的用户信息
	 *
	 * @params string $uids 多个id用逗号隔开
	 *
	 * @return array
	 */
	function getBatchBindUser($uids = false) 
	{
		///是否开启同步通讯
		if (1 != DS('common/sysConfig.get', '', 'xwb_discuz_enable')) {
			APP::ajaxRst(false, '5010008', 'Connection close');
		}

		if (empty($uids)) {
			APP::ajaxRst(false, '5010000', 'Parameter can not be empty');
		}

		$sql = 'SELECT * FROM ' . $this->db->getTable() . ' WHERE `uid` in (' . $uids . ')';
		return $this->db->query($sql);
	}
}
