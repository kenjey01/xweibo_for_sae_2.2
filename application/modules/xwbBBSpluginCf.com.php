<?php
/**
 * @file			xwbBBSpluginCf.com.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2011-01-25
 * @Modified By:	heli/2011-01-25
 * @Brief			处理插件配置的操作		
 */

class xwbBBSpluginCf {

	var $db;
	var $http;
	var $k;
	var $s;
	function xwbBBSpluginCf() 
	{
		$this->db = APP::ADP('db');
		$this->http = APP::ADP('http');
		$this->k = WB_AKEY;
		$this->s = WB_SKEY;
	}

	/**
	 * 设置开启或关闭插件通讯
	 *
	 * @params int $value 默认是1，1是开启，0是关闭
	 * @params string $url
	 *
	 * @return 
	 */
	function set($value = 1, $url = false) 
	{
		if ($value == 1) {
			/// 通知插件开启
			$params = array();
			$params = array('LTXCfg' => 1, 'UTXCfg' => W_BASE_HTTP.W_BASE_URL_PATH.'api/xplugin.php', 'BTXCfg' => W_BASE_HTTP.W_BASE_URL_PATH, 'url' => $url);
		
		} else {
			/// 通知插件关闭
			$params = array();
			$params = array('LTXCfg' => 0);
		}

		return $this->request('apiSystem.switchMode', $params);
	}

	/**
	 * 获取插件通讯配置
	 *
	 *
	 */
	function get()
	{
		$sql = "SELECT * FROM " . $this->db->getTable(T_SYS_CONFIG) . " WHERE `key` = 'xwb_discuz_enable'";
		$rst = $this->db->getRow($sql);
		return RST($rst);
	}

	/**
	 * 检查api是否连通
	 *
	 * @params string $url
	 *
	 * @return 
	 */
	function checkApi($url) 
	{
		$params = array();
	
		return $this->request('apiSystem.checkApi', $params);
	}

	/**
	 * 添加更新绑定用户
	 * @params int $uid
	 * @params int $sid
	 * @params string $token
	 * @params string $tsecret
	 * @return
	 */
	function updateBindUser($uid, $sid, $token, $tsecret)
	{
		if(empty($uid)||empty($sid)||empty($token)||empty($tsecret)){
			return RST(false);
		}else{
			$params = array();
			$params = array('uid' => $uid, 'sid' => $sid, 'token' => $token, 'tsecret' => $tsecret);
	
			return $this->request('apiRelate.updateRelate', $params);
		}
	}

	/**
	 * 获取绑定用户的信息
	 *
	 * @params int $id
	 * @params string $type
	 *
	 * @return 
	 */
	function getBindUser($id, $type = 'sina_uid')
	{
		$params = array();
		$params = array('id' => $id, 'type' => $type);
	
		return $this->request('apiRelate.fetchRelate', $params);
	}

	/**
	 * 删除绑定用户的信息
	 * 
	 * @params int $uid
	 * @params int $sid
	 *
	 * @return
	 */
	function deleteBindUser($uid, $sid)
	{
		$params = array();
		$params = array('uid' => $uid, 'sid' => $sid);
	
		return $this->request('apiRelate.deleteRelate', $params);
	}

	/**
	 * 发送api请求
	 *
	 * @params string $name 请求api的接口名称
	 * @params array $array 请求api的参数
	 *
	 * @result
	 */
	function request($name, $array) 
	{
		if (isset($array['url'])) {
			$url = $array['url'];
			unset($array['url']);
		} else {
			$url = DS('common/sysConfig.get', '', 'xwb_discuz_url');
		}
		$params = array();
		$params['A'] = $name; 
		$params['P'] = json_encode($array);
		$params['T'] = APP_LOCAL_TIMESTAMP;
		$params['F'] = md5(sprintf("#%s#%s#%s#%s#%s#", $this->k, $params['A'], $params['P'], $params['T'], $this->s));
		$this->http->setUrl($url);
		$this->http->setData($params);
		$result = $this->http->request('post');
		$result = json_decode($result, true);

		if ($this->http->getState() != 200) {
			return RST('', '1040002', '访问插件api的url超时，请检查一下', 0);
		}

		if (empty($result)) {
			return RST('false', '1040002', '插件api的url可能有误，请检查一下');
		}

		return $result;
	}
}
