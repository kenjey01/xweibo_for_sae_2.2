<?php
/**************************************************
*  Created:  2010-06-08
*
*  搜索
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/

class celeb_mod
{
	var $uInfo = false;
	
	
	function celeb_mod() 
	{
		// Cunstructor Here
	}

	
	
	/**
	 * 名人堂
	 */
	function default_action() 
	{
		$sort_list = $list = array();
		
		//查找大类
		$sort = DS('Celeb.getCatList',0);
		if($sort) 
		{
			foreach($sort as $value) 
			{
				if(!$value['status']){
					continue;
				}
				$id 					= $value['id'];
				$sort_list[$id]['name'] = $value['name'];
				$sort_list[$id]['data'] = DS('Celeb.getCatList', 'g1/0', $id);
				
				if(!is_array($sort_list[$id]['data'])){
					continue;
				}
				
				//仅显示2级块别名人数据
				foreach($sort_list[$id]['data'] as $subList){
					if(!$subList['recommended'] || !$subList['status']){
						continue;
					}
					
					//$list[$subList['id']]['parent_name'] = $value['name'];
					$list[$subList['id']]['name'] = $subList['name'];
					$list[$subList['id']]['data'] = DS('Celeb.getUserList', 'g2/0', $subList['parent_id'], $subList['id'], null, null, 0, 18, 'sort', 0);
				}
				
			}			
		}
		
		TPL :: assign('sort_list', $sort_list);
		TPL :: assign('list', $list);
		TPL::display('celeb/celebMgr_recommend');
	}
	
	/**
	 * 名人堂一级分类用户数据
	 */
	function starSortList() 
	{
		$sort = $sort_list = $list = array();
		$id = V('g:id',0);
		if(!is_numeric($id)) {
			APP::tips(array('tpl'=>'e404', 'msg'=> L('controller__common__dataNotExist')));
		}
		
		$sort 		= DS('Celeb.getSort', 'g1/0', $id);
		$sort_list 	= DS('Celeb.getCatList', 'g1/0', $id);
		
		if(!isset($sort['status']) || !$sort['status']){
			APP::tips(array('tpl'=>'e404', 'msg'=> L('controller__common__dataNotExist')));
		}
		
		foreach($sort_list as $value) {
			if(!$value['status']){
				continue;
			}
			$list[$value['id']]['parent_name'] = $sort['name'];
			$list[$value['id']]['name'] = $value['name'];
			$list[$value['id']]['data'] = DS('Celeb.getUserList', 'g2/0', $id, $value['id'], null, null, 0, 18, 'sort', 0);
		}

		TPL :: assign('sort', $sort);
		TPL :: assign('list', $list);
		TPL :: display('celeb/celeb_starSortList');
	}
	
	

	/**
	 * 名人堂二级分类用户数据
	 */
	function starChildSortList() 
	{
		$sort_list = $list = $index_list = $sort_parent = array();
		$id = V('g:id',0);
		if(!is_numeric($id)) {
			APP::tips(array('tpl'=>'e404', 'msg'=> L('controller__common__dataNotExist')));
		}

		
		$sort = DS('Celeb.getSort', 'g1/0', $id);
		if ( isset($sort['parent_id']) ) {
			$sort_parent = DS('Celeb.getSort', 'g1/0', $sort['parent_id']);
		}
		
		if(!isset($sort['status']) || !$sort['status'] || !isset($sort_parent['status']) || !$sort_parent['status']){
			APP::tips(array('tpl'=>'e404', 'msg'=> L('controller__common__dataNotExist')));
		}
		
		$ret = DS('Celeb.getUserList', 'g2/0', null, $id, null, null, null, null, 'char_index');
		
		if($ret) 
		{
			foreach($ret as $value) 
			{
				$charIndex 							  = $value['char_index'];
				$list[$charIndex][$value['sina_uid']] = $value;
				$index_list[$charIndex] 			  = $charIndex;
			}
		}

		TPL :: assign('index_list', $index_list);
		TPL :: assign('list', $list);
		TPL :: assign('sort', $sort);
		TPL :: assign('sort_parent', $sort_parent);
		TPL :: display('celeb/celeb_starChildSortList');
	}
}
