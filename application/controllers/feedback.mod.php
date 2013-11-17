<?php
/**************************************************
*  Created:  2010-06-08
*
*  帐号相关操作
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class feedback_mod {
	/// 获取绑定信息
	function default_action() {
		TPL::display('feedback');
	}
	function resentInstallMsg() {
		$config = array('WB_USER_SITENAME' => WB_USER_SITENAME,
				'WB_USER_SITEINFO' => WB_USER_SITEINFO,
				'WB_AKEY' => WB_AKEY,
				'WB_SKEY' => WB_SKEY,
				'WB_SITE_URL' =>W_BASE_HTTP . W_BASE_URL
				);
		$app_key = WB_AKEY;
		$router = 'install';
		$data = json_encode($config);
		$time = time();

		$data = array(
				'K' => $app_key,
				'A' => $router,
				'P' => $data,
				'T' => $time,
				'F' => md5(sprintf('#%s#%s#%s#%s#%s#', $app_key, $router, $data, $time, WB_SKEY))
				);
		$http = APP::ADP('http');
		$http->setUrl(WB_FEEDBACK_URL);
		$http->setData($data);
		$rst = $http->request('post');
		if ($http->getState() == '200') {
			if (($rst_data = json_decode($rst, true))){
				if ($rst_data['errno'] == 0) {
					// 成功
					return true;
				} 
			} 
		}
		return false;
	}

	function save() {
		$plugins = DS('Plugins.get','',5);
		if (!$plugins['in_use']) {
			APP::ajaxRst(false, 10001,L('controller__feedBack__save__disabled'));
		}
		$keys = array(
				'content','uid','nickname','mail','qq','tel'
				);
		$data = array();
		foreach ($keys as $key) {
			if (V('r:'.$key)) {
				$data[$key] = V('r:'. $key);
			}
		}
		if (USER::isUserLogin()) {
			$data['nickname'] = USER::get('screen_name');
			$data['uid'] = USER::uid();
		}else{
			$data['nickname'] = 'Guest';
			$data['uid'] = 0;
		}
		$data['addtime'] = APP_LOCAL_TIMESTAMP;
		$data['ip'] = F('get_client_ip');
		/*
		   $data = array(
		   'content' => 'this is content',
		   'uid' => 11064,
		   'nickname'=>'simonxzq',
		   'mail'=>'simonxzq@gmail.com'
		   );
		 */
		$rst = DR('feedback.save', '', $data);
		// 向服务器上报反馈信息，以便发现问题
		$app_key = WB_AKEY;
		$router = 'feedback';
		$data = json_encode($data);
		$time = APP_LOCAL_TIMESTAMP;

		$data = array(
				'K' => $app_key,
				'A' => $router,
				'P' => $data,
				'T' => $time,
				'F' => md5(sprintf('#%s#%s#%s#%s#%s#', $app_key, $router, $data, $time, WB_SKEY))
				);
		$http = APP::ADP('http');
		$http->setUrl(WB_FEEDBACK_URL);
		$http->setData($data);
		$rst = $http->request('post');
		//var_dump(WB_FEEDBACK_URL, $data, $rst);
		if ($http->getState() == '200') {
			if (($rst_data = json_decode($rst,true))){
				if ($rst_data['errno'] == 0) {
					// 成功
					APP::ajaxRst($rst_data['rst']);
				} elseif ($rst_data['errno'] == '30000') {// 如果发现数据库没有记录，则重新发安装信息
					if ($this->resentInstallMsg()) {
						$http->setUrl(WB_FEEDBACK_URL);
						$http->setData($data);
						$rst = $http->request('post');
						if ($http->getState() == '200') {
							if (($rst_data = json_decode($rst,true))){
								if ($rst_data['errno'] == 0) {
									// 成功
									APP::ajaxRst($rst_data['rst']);
								}
							}
						}
					} else {
						APP::ajaxRst(false, '10014');
					}
				} 
			} 
		}
		APP::ajaxRst(false, '10015');
	}
}
?>
