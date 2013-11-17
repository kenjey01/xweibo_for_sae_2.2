<?php
/**************************************************
*  Created:  2010-12-22
*
*  名人堂管理控制器
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author guanghui <guanghui1@staff.sina.com.cn>
*
***************************************************/

include(P_ADMIN_MODULES . '/action.abs.php');

class celeb_mgr_mod extends action
{
	
	function celeb_mgr_mod()
	{
		parent :: action();
	}
	
	
	
	/**
	 * 获取名人堂用户列表
	 */
	function starList()
	{
		$nick  		= trim(V('r:nick', ''));
		$cid_1 		= (int)V('r:c_id1', 0);
		$cid_2 		= (int)V('r:c_id2', 0);
		$char_index = (int)V('r:char_index', 0);
		if ($char_index) {
			$char_index = (0<$char_index && 26>=$char_index ) ? $char_index : 0;
		} else {
			$char_index = '';
		}
		
		//获取顶级分类以及对应二级分类的数组
		$topCat = $secCat = array();
		$top_rs = DR('Celeb.getCatList', '', 0);
		foreach ($top_rs['rst'] as $cat) {
			$topCat[$cat['id']] = $cat['name'];
		}
		
		// get the second category
		if ($cid_1) 
		{
			$sec_rs = DR('Celeb.getCatList', '', $cid_1);
			if (is_array($sec_rs['rst'])) 
			{
				foreach ($sec_rs['rst'] as $cat) {
					$secCat[$cat['id']] = $cat['name'];
				}
			}
		}
		
        // Page
        $pager    	= APP::N('pager');
		$rstCount 	= DR('Celeb.getUserNum', '', $cid_1, $cid_2, $char_index, $nick);
		$offset 	= $pager->initParam($rstCount['rst']);
        
        //获取活动列表
        $rss  = '';
		$rss  = DR('Celeb.getUserList', '', $cid_1, $cid_2, $char_index, $nick, $offset, $pager->getParam('pageSize'));
		$list = $rss['rst'];
		
		//获取用户的名人分类信息
		$catArr = $topCat + $secCat;  //名人分类总数组，查询后存到此数组，避免重复查询
		foreach ($list as $key => $value) 
		{
			if (isset($catArr[$value['c_id1']])) {
				$list[$key]['cat_name_1'] = $catArr[$value['c_id1']];
			} else {
				$rs_1 = DR('Celeb.getCatById', '', $value['c_id1']);
				$catArr[$value['c_id1']] = $list[$key]['cat_name_1'] = isset($rs_1['rst']['name']) ? $rs_1['rst']['name'] : '';
			}
			
			if (isset($catArr[$value['c_id2']])) {
				$list[$key]['cat_name_2'] = $catArr[$value['c_id2']];
			} else {
				$rs_2 = DR('Celeb.getCatById', '', $value['c_id2']);
				$catArr[$value['c_id2']] = $list[$key]['cat_name_2'] = isset($rs_2['rst']['name']) ? $rs_2['rst']['name'] : '';
			}
		}
		unset($catArr);
		
		
		//搜索条件
		TPL::assign('search_arr', array('nick'=>$nick, 'cid_1'=>$cid_1, 'cid_2'=>$cid_2, 'char_index'=>$char_index));
		TPL::assign('pager', $pager->makePageForKeyWord('', array('nick'=>urlencode($nick), 'c_id1'=>$cid_1, 'c_id2'=>$cid_2, 'char_index'=>$char_index)));
		TPL::assign('topCat', $topCat);
		TPL::assign('secCat', $secCat);
		TPL::assign('count', $rstCount['rst']);
		TPL::assign('list', $list);
		TPL::assign('num', $offset);
		
		$this->_display('celeb/celebMgr_starList');
	}
	
	
	
	/**
	 * 新增/修改名人
	 */
	function addStar()
	{
		$c_id1 		= (int)V('g:c_id1', 0);
		$c_id2 		= (int)V('g:c_id2', 0);
		$sina_uid 	= V('g:sina_uid', 0);
		$info		= array();
		
		if ($c_id1 && $c_id2 && $sina_uid) {
			$rs = DR('Celeb.getUserByInfo', '', array('c_id1'=>$c_id1, 'c_id2'=>$c_id2, 'sina_uid'=>$sina_uid));
			if ($rs['rst']) {
				$info = $rs['rst'][0];
			}
		}
		
		$topCat = array();
		$rs 	= DR('Celeb.getCatList', '', 0, 0, '', true);
		if (is_array($rs['rst'])) {
			foreach ($rs['rst'] as $cat) {
				$topCat[$cat['id']] = $cat['name'];
			}
		}
		
		TPL :: assign('info', $info);
		TPL :: assign('cat_id', V('g:pid', 0));
		TPL :: assign('topCat', $topCat);
		$this->_display('celeb/celebMgr_addStar');
	}
	
	
	
	/**
	 * 保存名人信息
	 */
	function saveStar()
	{
		$nick 		= trim(V('p:nickname', ''));
		$c_id1 		= (int)V('p:c_id1', 0);
		$c_id2 		= (int)V('p:c_id2', 0);
		$char_index = (int)V('p:char_index', 0);
		$sort 		= (int)V('p:sort', 0);
		
		if (empty($c_id1) || empty($c_id2)) {
			$this->_error('参数错误！', URL('mgr/celeb_mgr.starList'));
		}
		
		//如果获取到昵称，则为新增名人，否则为修改名人
		if ($nick) {
			//检测用户是否已添加到相应的分类当中
			$crs = DR('Celeb.getUserByInfo', '', array('c_id1'=>$c_id1, 'c_id2'=>$c_id2, 'nick'=>$nick));
			if ($crs['rst']) {
				$this->_error('该用户已添加！', $_SERVER['HTTP_REFERER']);
			}
			
			//查询API接口，获取用户信息
//			DR('xweibo/xwb.setSchoolAppKey', '', 1);   //设置API TOKEN
			$user_info = DR('xweibo/xwb.getUserShow', '', null, null, $nick);
			if(empty($user_info['rst'])) {
                $this->_error('该用户不存在！', $_SERVERP['HTTP_REFERER']);
            }
            $sinaUser = $user_info['rst'];
            
            $data 				= array();
            $data['c_id1'] 		= $c_id1;
            $data['c_id2'] 		= $c_id2;
            $data['char_index'] = $char_index;
            $data['sina_uid'] 	= $sinaUser['id'];
            $data['nick'] 		= $sinaUser['screen_name'];
            $data['face'] 		= $sinaUser['profile_image_url'];
            $data['verified'] 	= (int)$sinaUser['verified'];
            $data['sort'] 		= $sort;
            $data['add_time'] 	= APP_LOCAL_TIMESTAMP;
            
            $rs = DR('Celeb.addStarUser', '', $data);
            if ($rs['rst']) {
//            	$this->_log('添加名人堂用户：data=' . serialize($data), 'add');
				$this->_succ('添加成功！', $_SERVER['HTTP_REFERER']);
            } else {
            	$this->_error('添加失败！',$_SERVER['HTTP_REFERER']);
            }
            die();
		} else {
			$old_c_id1 = (int)V('p:old_c_id1', 0);
			$old_c_id2 = (int)V('p:old_c_id2', 0);
			$sina_uid  = V('p:sina_uid', 0);
			
			if (empty($old_c_id1) || empty($old_c_id2) || empty($sina_uid)) {
				$this->_error('参数错误！', URL('mgr/celeb_mgr.starList'));
			}
			
			$data = array();
			//判断是否修改名人所属分类
			if ($old_c_id1 !== $c_id1 || $old_c_id2 !== $c_id2) {
				//检测用户是否已添加到相应的分类当中
				$crs = DR('Celeb.getUserByInfo', '', array('c_id1' => $c_id1, 'c_id2' => $c_id2, 'sina_uid' => $sina_uid));
				if ($crs['rst']) {
					$this->_error('不能修改用户所属分类，因为新分类中已存在此用户！', $_SERVER['HTTP_REFERER']);
				}
				
				$data['c_id1'] = $c_id1;
				$data['c_id2'] = $c_id2;
			}
			$data['char_index'] = $char_index;
			$data['sort'] 		= $sort;
			
			$where = array('c_id1'=>$old_c_id1, 'c_id2'=>$old_c_id2, 'sina_uid'=>$sina_uid);
			
			$rs = DR('Celeb.updateStarUser', '', $data, $where);
            if ($rs['rst']) {
//            	$this->_log('修改名人堂用户：data=' . serialize($data) . ', where=' . serialize($where), 'update');
				$this->_succ('修改成功！', $_SERVER['HTTP_REFERER']);
            } else {
            	$this->_error('修改失败！', $_SERVER['HTTP_REFERER']);
            }
		}
	}
	
	
	
	/**
	 * 删除名人
	 */
	function delStar()
	{
		$c_id1 		= (int)V('g:c_id1', 0);
		$c_id2 		= (int)V('g:c_id2', 0);
		$sina_uid 	= V('g:sina_uid', 0);
		
		if (empty($c_id1) || empty($c_id2) || empty($sina_uid)) {
			$this->_error('参数错误！', URL('mgr/celeb_mgr.starList'));
		}
		
		$rs = DR('Celeb.delStarUser', '', $c_id1, $c_id2, $sina_uid);
		if ($rs['rst']) {
//			$this->_log('删除名人堂用户：c_id1=' . $c_id1 . ', c_id2=' . $c_id2 . ', sina_uid=' . $sina_uid, 'delete');
			$this->_succ('删除成功！', URL('mgr/celeb_mgr.starList'));
		}
		
		$this->_error('删除失败！', URL('mgr/celeb_mgr.starList'));
	}
	
	
	
	/**
	 * 获取名人分类列表
	 */
	function starCatList()
	{
		$parent_id 		 = (int)V('g:pid', 0);
		$parent_cat_name = '';
		
		if ($parent_id) {
			$parentCatInfo = DR('Celeb.getCatById', '', $parent_id);
			if (!$parentCatInfo['rst']) {
				$this->_error('参数错误！', URL('mgr/celeb_mgr.starCatList'));
			}
			$parent_cat_name = $parentCatInfo['rst']['name'];
		}
        
        // Page
        $pager    	= APP::N('pager');
		$rstCount 	= DR('Celeb.getCatNum', '', $parent_id);	//获取分类数量
		$offset 	= $pager->initParam($rstCount['rst']);
		
        //获取分类列表
		$rss = DR('Celeb.getCatList', '', $parent_id, $offset, $pager->getParam('pageSize'));
		
		TPL :: assign('pager', $pager->makePage());
		TPL :: assign('parent_cat_name', $parent_cat_name);
		TPL :: assign('parent_id', $parent_id);
		TPL :: assign('list', $rss['rst']);
		TPL :: assign('num', $offset);
		
		$this->_display('celeb/celebMgr_starCatlist');
	}
	
	
	
	/**
	 * 新增/修改名人分类
	 */
	function addStarCat()
	{
		$id 		= (int)V('g:id', 0);
		$parent_id 	= (int)V('g:parent_id', 0);
		if ($id) 
		{
			$rs = DR('Celeb.getCatById', '', $id);
			if ($rs['rst']) {
				TPL :: assign('info', $rs['rst']);
			}
		}
		
		TPL :: assign('parent_id', $parent_id);
		$this->_display('celeb/celebMgr_addStarCat');
	}
	
	
	
	/**
	 * 保存名人分类
	 */
	function saveStarCat()
	{
		$id 		= (int)V('p:id', 0);
		$parent_id 	= (int)V('p:parent_id', 0);
		$name 		= trim(V('p:name', false));
		if ($name === false) {
			$this->_error('分类名不能为空！', URL('mgr/celeb_mgr.starCatList'));
		}
		
		$crs = DR('Celeb.getCatByName', '', $parent_id, $name, $id);
		if ($crs['rst']) {
			$this->_error('该分类名已添加！', URL('mgr/celeb_mgr.starCatList', "pid=$parent_id"));
		}
		
		$data = array();
		if (empty($id)) {
			$data['add_time'] = APP_LOCAL_TIMESTAMP;
		}
		$data['parent_id'] 	= $parent_id;
		$data['name'] 		= $name;
		$data['sort'] 		= (int)V('p:sort', 0);
		
		$rs = DR('Celeb.saveCat', '', $data, $id);
		if (!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/celeb_mgr.starCatList', 'pid=' . $parent_id));
		}
		
		if ($id) {
//			$this->_log('修改名人分类：id=' . $id . ',name=' . $name, 'update');
			$this->_succ('更新成功！', URL('mgr/celeb_mgr.starCatList', 'pid=' . $parent_id));
		} else {
//			$this->_log('添加名人分类：id=' . $rs['rst'] . ',name=' . $name, 'add');
			$this->_succ('添加成功！', URL('mgr/celeb_mgr.starCatList', 'pid=' . $parent_id));
		}
	}
	
	
	
	/**
	 * 修改名人分类
	 */
	function editStarCat()
	{
		
	}
	
	
	
	/**
	 * 删除名人分类
	 */
	function delStarCat()
	{
		$id 		= (int)V('g:id', 0);
		$parent_id 	= (int)V('g:parent_id', 0);
		
		if (empty($id)) {
			$this->_error('参数错误！', URL('mgr/celeb_mgr.starCatList', "pid=$parent_id"));
		}
		
		//限制不能删除分类下存在用户的分类
		$cid_1 = $parent_id ? $parent_id : $id;
		$cid_2 = $parent_id ? $id : 0;
		$crs   = DR('Celeb.getUserNum', '', $cid_1, $cid_2);
		if ($crs['rst']) {
			$this->_error('该分类下存在用户，不允许删除！', URL('mgr/celeb_mgr.starCatList', "pid=$parent_id"));
		}
		
		$rs = DR('Celeb.delCat', '', $id);
		if (!$rs['rst']) {
			$this->_error('删除失败！', URL('mgr/celeb_mgr.starCatList', "pid=$parent_id"));
		}
		
//		$this->_log('删除名人分类：id=' . $id, 'delete');
		$this->_succ('删除成功！', URL('mgr/celeb_mgr.starCatList', "pid=$parent_id"));
	}
	
	
	/**
	 * Ajax请求获取分组下是否有内容，有内容(包括二级分类或用户)不能删除
	 */
	function ajaxCatHasContent () 
	{
		$id 		= (int)V('g:id', 0);
		$parent_id 	= (int)V('g:parent_id', 0);
		$canDel		= FALSE;
		
		if ($id) 
		{
			$cid_1 = $parent_id ? $parent_id : $id;
			$cid_2 = $parent_id ? $id : 0;
			$crs   = DR('Celeb.getUserNum', '', $cid_1, $cid_2);
			if ($crs['rst']) { // 分类是否有用户
				$canDel = TRUE;
			} else {	// 是否有分类
				$rs 	= DR('Celeb.getCatNum', FALSE, $id);
				$canDel = (bool)$rs['rst'];
			}
		}
		
		APP::ajaxRst($canDel);
	}
	
	
	
	/**
	 * 批量更新
	 */
	function updateCatSort()
	{
		$parent_id 	= (int)V('p:parent_id', 0);
		$data		= V('p:data');
		
		if (!is_array($data) || empty($data)) {
			$this->_error('参数错误！', URL('mgr/celeb_mgr.starCatList', 'pid=' . $parent_id));
		}
		
		$logMsg = '';
		foreach ($data as $id => $aSort) 
		{
			$aSort['sort']	 = intval($aSort['sort']);
			$aSort['status'] = isset($aSort['status']) ? 1 : 0;
			if ($parent_id) {
				$aSort['recommended'] = isset($aSort['recommended']) ? 1 : 0;
			}
			DS('Celeb.saveCat', FALSE, $aSort, $id);
//			$logMsg .= ('id=' . $id . ', sort=' . (int)$sorts[$k] . '|');
		}
		
//		$this->_log('批量修改名人分类排序：' . rtrim($logMsg, '|'), 'update');
		$this->_succ('更新成功！', URL('mgr/celeb_mgr.starCatList', "pid=$parent_id"));
	}
	
	
	
	/**
	 * AJAX获取子分类
	 */
	function ajaxGetCatList()
	{
		$strHTML 	= '<select name="c_id2" class="input-box">';
		$parent_id 	= (int)V('g:parent_id', 0);
		$id 		= (int)V('g:id', 0);
		
		$getAll = (int)V('g:all', 0);   //是否添加'所有分类'选项
		if ($getAll) {
			$strHTML .= '<option value="0">所有二级分类</option>';
		}
		
		// second category
		if ($parent_id) 
		{
			$rs = DR('Celeb.getCatList', '', $parent_id);
			if (is_array($rs['rst'])) {
				foreach ($rs['rst'] as $cat) {
					$strHTML .= ('<option value="' . $cat['id'] . '"' . ($cat['id'] == $id ? ' selected="selected"' : '') . '>' . $cat['name'] . '</option>');
				}
			}
		}
		$strHTML .= '</select>';
		echo $strHTML;
	}
}
