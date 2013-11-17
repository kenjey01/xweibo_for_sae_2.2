<?php
include(P_ADMIN_MODULES . '/action.abs.php');
class feedback_mod extends action {

	function feedback_mod() {
		parent :: action();
	}


	function getList() {

		$page = (int)V('r:page', 1);
		$keyword = V('r:keyword');
		$rows = (int)V('r:rows', 20);
		$query = array(
			'keyword' => $keyword
		);

		if ($page < 1) {
			$page = 1;
		}
		$offset = ($page-1) * $rows;
		TPL::assign('offset', $offset);
		$data = DS('feedback.getList', '', $query, $rows, $offset);
		$pager = APP :: N('pager');
		$count = DS('feedback.getCount', '');
		$page_param = array('currentPage'=> $page, 'pageSize' => $rows, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		$pager->setVarExtends(array('keyword' => $keyword));
		TPL :: assign('pager', $pager->makePage());
		TPL::assign('list', $data);
		$this->_display('feedback_list');
	}
	
	function del() {
		$id = V('r:id');
		DR('feedback.del', '' , $id);
		$this->_succ('已经成功删除', array('getList'));
	}
}
