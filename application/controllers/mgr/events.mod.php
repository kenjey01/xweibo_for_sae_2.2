<?php
include(P_ADMIN_MODULES . '/action.abs.php');
class events_mod extends action {
	function getList() {
	 // @return int 1:推荐，2进行中,3:正常,4:用户关闭,5:管理员封禁,6:已完成
		$states = array(
			1 => '推荐',
			2 => '进行中',
			3 => '正常',
			4 => '用户关闭',
			5 => '管理员封禁',
			6 => '已完成',
			7 => '未进行'
		);
		$limit = 20;
		$offset = (V('g:page',1) -1) * $limit;
		$state = V('r:state', 0);
		$keyword = V('r:keyword', '');
		$data = DS('events.eventSearch', '', $keyword, $state, 0, false, $offset, $limit);
        $pager    	= APP::N('pager');
		$rstCount 	= DS('events.getCount', '');
		$offset 	= $pager->initParam($rstCount);

		TPL :: assign('pager', $pager->makePage());
		TPL::assign('states', $states);
		TPL::assign('list', $data);
		$this->_display('events');
	}


	function setState() {
		$id = V('r:id', 0);
		$state = V('r:state', 1);
		$rs = DS('events.updateEvents', '', $id, $state);
		$this->_succ('已经成功设置', array('getList'));
	}
}
