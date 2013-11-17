<?php
/**
 * 分享（转发）按钮设置
 * @author yaoying<yaoying@staff.sina.com.cn>
 * @copyright SINA INC.
 * @version $Id: share.mod.php 13631 2011-04-16 08:29:16Z yaoying $
 */

if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED');
}

include(P_ADMIN_MODULES . '/action.abs.php');
class share_mod extends action{
	function share_mod() {
		parent :: action();
	}

	function default_action() {
		//$this->_error('错误的请求方式！');
		$this->button();
	}
	
	function button(){
		$this->_display('share/button');
	}
	
	/**
	 * 搜索关联用户接口
	 */
	function searchUser(){
		$username = trim(strval(V('p:username')));
		if(empty($username)){
			APP::ajaxRst('', '1010000', '缺少用户名参数');
		}
		
		$q = array(
			'q' => $username,
			'snick' => 1,
		);
		$rs = DR('xweibo/xwb.searchUser', '', $q);
		if(!is_array($rs['rst'])){
			APP::ajaxRst(array(), $rs['errno'], $rs['err']);
		}elseif(!isset($rs['rst'][0])){
			APP::ajaxRst(array(), '1010001', '搜索的用户不存在');
		}elseif( count($rs['rst']) != 1
				&& strncasecmp($rs['rst'][0]['screen_name'], $username, 100) != 0
				&& strncasecmp($rs['rst'][0]['name'], $username, 100) != 0)
		{
			APP::ajaxRst(array(), '1010001', '搜索的用户不存在');
		}else{
			APP::ajaxRst($rs['rst'][0]);
		}
		
	}

}
?>