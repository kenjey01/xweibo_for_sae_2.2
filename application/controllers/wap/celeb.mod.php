<?php
/**
 * @file			celeb.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			tangqiping <qiping@staff.sina.com.cn>
 * @Create Date:	2011-03-08
 * @Modified By:	tangqiping/2011-03-08
 * @Brief			名人堂
 */

/*
 * class celeb_mod
*/
require_once ('action.basic.php');

class celeb_mod extends action {
	
	function celeb_mod() {
		parent::action();
	}
	/**
	 * 名人堂
	 */
	
	function default_action() {

		$sort = array();
		$sort = DS('Celeb.getCatList', 0);
		TPL::assign('sort', $sort);
		$this->_display('celeb');
	}
	/**
	 * 名人堂一级分类所有用户数据，不含二级分类，用于wap分页
	 */
	
	function starSortList() {

		$list = array();
		$pages = $num = 0;
		$id = V('g:id', 0);
		$page = V('g:page', 1);
		
		if (!is_numeric($id)) {
			APP::tips(array(
				'tpl' => 'e404',
				'msg' => L('controller__celeb__starSortList__emptyTip')
			));
		}
		$num = DS('Celeb.getUserNum', 'g1/0', $id);
	
		$sort = DS('Celeb.getSort', 'g1/0', $id);
		$limit = 10;
		$list = DS('Celeb.getUserList', '', $id, null, null, null, $limit * ($page - 1) , $limit, 'add_time', 1);
		$pages = ceil($num / $limit);
		if(isset($sort['name'])){
				TPL::assign('title', $sort['name']);		
		}
		
		TPL::assign('sort', $sort);
		TPL::assign('list', $list);
		TPL::assign('pages', $pages);

		//var_dump($list);
		$this->_display('celeb_starSortList');
		$this->_setBackURL();
	}
}
?>
