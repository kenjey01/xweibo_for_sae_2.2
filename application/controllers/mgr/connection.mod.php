<?php
include(P_ADMIN_MODULES . '/action.abs.php');
class connection_mod extends action {

	function connection_mod() {
		parent :: action();
	}

	function default_action() {
		$rs = DS('common/sysConfig.get', '', 'xwb_discuz_enable');
		TPL::assign('connected', $rs);
		$url = DS('common/sysConfig.get', '', 'xwb_discuz_url');
		TPL::assign('url', $url);
		$this->_display('connection');
	}

	/**
	 * 开启与插件通讯
	 */
	function connect() {
		$url = V('r:url');
		if (!$url) {
			APP::ajaxRst(false);exit;
		}

		///通知插件开启通信
		$rst = DR('xwbBBSpluginCf.set', '', 1, $url);

		if ($rst['errno'] != 0) {
			APP::ajaxRst(false, $rst['errno'], $rst['err']);
		}
		
		$data = array(
			'xwb_discuz_url' => $url,
			'xwb_discuz_enable' => true
		);

		$rst = DR('common/sysConfig.set', '', $data);
		if (empty($rst['errno'])) {
			APP::ajaxRst(true);
		} else {
			APP::ajaxRst(false,11011, '保存连接状态失败');
		}
	}

	/**
	 * 关闭与插件通讯
	 */
	function disconnect() {
		///通知插件关闭通信
		$url = DS('common/sysConfig.get', '', 'xwb_discuz_url');
		$rst = DR('xwbBBSpluginCf.set', '', 0, $url);
		//$rst = array('rst'=>array('ver'=>'','chatset'=>'','pro'=>''), 'errno'=>0, 'err'=>''); // 模拟返回内容
		if ($rst['errno'] != 0) {
			APP::ajaxRst(false, $rst['errno'], $rst['err']);
		}
		$rst = DR('common/sysConfig.set', '', 'xwb_discuz_enable', false);
		
		if (empty($rst['errno'])) {
			APP::ajaxRst(true);
		} else {
			APP::ajaxRst(false,11011, '保存连接状态失败');
		}
	}

}
