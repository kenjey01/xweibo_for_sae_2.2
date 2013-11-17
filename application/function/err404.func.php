<?php
function err404($msg = '') {
	ob_clean();
	//$funDebug = 1;
	if (defined('IS_DEBUG') && IS_DEBUG) {
		trigger_error($msg);
		exit;
	}
	//APP::tips(array('tpl' => 'e404', 'msg' => '你访问的页面不存在'));
	if (Xpipe::isRunning()) {
		echo '<div class="api-error"><p>' . ($msg ? $msg : L('function__common__pageNotExist')) . '</p></div>';
	} else {
		TPL::module('e404');
	}
	exit;
}
