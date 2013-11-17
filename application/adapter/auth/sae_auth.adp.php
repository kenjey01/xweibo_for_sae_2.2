<?php
/**
 * @file			saeauth.mdp.php
 * @CopyRright (c)	1996-2099 SINA Inc.
 * @Project			Xweibo 
 * @Author			Yang.Zhang <zhangyang@staff.sina.com.cn>
 * @Create Date 	2010-11-30
 * @Modified By 	Yang.Zhang/2010-11-30
 * @Brief			Description
 */
 
class sae_auth
{
	var $session_var = 'verify_code';
	var $vcode = null;
	function sae_auth(){
		$this->vcode = new SaeVCode();
	}
	function adp_init($config=array()) {
		
	}
	function answer(){
		return $this->vcode->answer();
	}
	function errmsg(){
		return $this->vcode->errmsg();
	}
	function errno(){
		return $this->vcode->errno();
	}
	function question(){
		$arr = $this->vcode->question();
		$_SESSION[$this->session_var] = $this->answer();
		return $arr;
	}
	function checkAuthcode($code){
		if (isset($_SESSION[$this->session_var]) && strtolower($_SESSION[$this->session_var]) == strtolower($code)) {
			return true;
		}
		return false;
	}
}
?>