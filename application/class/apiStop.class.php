<?php
/*
* API维护处理
*/
class apiStop{
	function setStop() {
		$rst = DS('common/sysConfig.set', '', 'api_checking', true);
		$this->redirect();
	}
	
	function restart() {
		// 测试API是否恢复
		$wb = APP::O('weibo');
		// 如果API未恢复，则跳到对应的错误页，不会向下执行
		$wb->getPublicTimeline(0, false);
		// 清除出错标志
		DS('common/sysConfig.set', '', 'api_checking', false);
		DD('common/sysConfig.get');
		return true;
	}

	function check() {
		$rst = DS('common/sysConfig.get', 3600, 'api_checking');
		if ($rst === true) {
			$this->redirect();
		}
	}
	
	function redirect() {
		APP::redirect(W_BASE_URL . 'upgrade.html', 3);
	}
}
