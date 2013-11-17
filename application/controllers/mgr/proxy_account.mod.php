<?php
include('action.abs.php');
class proxy_account_mod extends action{
	// 代理帐号列表
	function accountList() {
		$rs = DR('accountProxy.getList');
		TPL::assign('list', $rs['rst']);
		$this->_display('accountProxyList');
	}
	
	function addAccount() {
		$oauthCbUrl = W_BASE_HTTP . URL('mgr/proxy_account.addAccountCallback');
		$oauthUrl	 = DS('xweibo/xwb.getTokenAuthorizeURL', '', $oauthCbUrl);
		$oauthUrl .= '&forcelogin=true';
		header('Location:' . $oauthUrl);
	}

	// 添加代理帐号
	function addAccountCallback() {
		$oauth_verifier = V('r:oauth_verifier','');
		//非法访问，或者 Oauth 返回错误
		if(empty($oauth_verifier)){
			//APP::tips(); TODO
			die('oauth_verifier error!');
		}

		$last_key = DS('xweibo/xwb.getAccessToken','',$oauth_verifier);
		$token = $last_key['oauth_token'];
		$secret = $last_key['oauth_token_secret'];
		$uid = $last_key['user_id'];


		//USER::setOAuthKey($last_key, true);
		DS('xweibo/xwb.setToken','' ,3, $token, $secret);
		$uInfo = DR('xweibo/xwb.verifyCredentials');
		$data = array(
			'sina_uid' => $uid,
			'screen_name' => $uInfo['rst']['screen_name'],
			'token' => $token,
			'secret' => $secret
		);
		$rs = DR('accountProxy.add', '', $data);
        echo '<html><head><script type="text/javascript">window.opener && window.opener.authoritySuccess();</script></head><body>success!</body></html>';
        exit;
		//$this->_redirect('accountList');
	}

	function delAcount() {
		$id = V('g:id');
		DR('accountProxy.delAccount','', $id);
		$this->_redirect('accountList');
	}
}
