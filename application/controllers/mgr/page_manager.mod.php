<?php
include('action.abs.php');

class page_manager_mod extends action 
{
	var $pm = null;
	var $component_cty = array( // 组件类别
		 'wb' => '微博','user' => '用户', /*'topic' => '话题', */'others' => '其它'
	);
	
	function page_manager_mod() 
	{
		parent :: action();
		$this->pm = APP::N('pageManager');
	}

	
	function default_action() 
	{
		$list = $this->pm->get();
		TPL::assign('pages', $list);
		$this->_display('pagelist');
	}

	
	
	/**
	 * 页面组件开关设置
	 */
	function set() 
	{
		$page_id = V('g:page_id');
		$pmId 	 = V('g:c');
		$use 	 = V('g:use');

		if ($page_id && $pmId)
		{
			$result = $this->pm->onOff($page_id, $pmId, $use);
			if ($result) {
				DD('PageModule.getPageModules');
			}
		}

		APP::redirect(URL('mgr/page_manager.setting', array('id'=>$page_id)), 3);
	}

	
	
	/** 
	 * 保存排序
	 */
	function savesort() 
	{
		//$ids 		= V('p:ids');
		$main 		= V('p:main');
		$side 		= V('p:side');
		$page_id 	= V('g:page_id');
		//$pos 		= V('g:pos');
		
		$manager 	= APP::N('pageManager');
		$result = array();
		
		$result['main'] 	= $manager->setSort(explode(',', $main), $page_id, 1);
		$result['side'] 	= $manager->setSort(explode(',', $side), $page_id, 2);
		
		APP::ajaxRst($result, $result['main'] && $result['side'] ? 0: 1);
		exit;
	}

	
	
	function setting() 
	{
		$page_id = V('g:id');
		if (!$page_id) {
			exit('param page_id missing');
		}

		$page 		= DS('PageModule.getPage', '', $page_id);
		if (!$page) {
			$this->_error('指定的页面不存在',URL('mgr/page_manager'));
		}
		$list 		= DS('PageModule.getPageModules', '', $page_id);
		$modules 	= DR('PageModule.groupByPos', '', $list, null);
/*
		if ($page['native'] && $page['page_id'] != '1') {
			$this->_error('指定的页面没有可以设置的项',URL('mgr/page_manager'));
		}
*/
		TPL::assign('page_id', $page_id);
		TPL::assign('page', $page);
		TPL::assign('main_modules', isset($modules[1]) ? $modules[1]:null);
		TPL::assign('side_modules', isset($modules[2]) ? $modules[2]:null);

		$this->_display('page_setting');
	}
	
	/**
	 * 组件选择列表
	 */
	function componentCategory() {
		$page_id		= V('g:page_id');
		$componentType  = V('g:componentType');
		$componentList	= $this->pm->getCustomeComponent($componentType);

		// 过滤已经添加的 每个页面只能有一个的模块
		$pageComponentList 	= $this->pm->getPageComponentList($page_id);
		$componentList 		= $this->filterPageComponent($componentList, $pageComponentList);

		// 组件分类
		$componentsByCategory = array();
		foreach ($componentList as $component) {
			//var_dump($component);
			$componentsByCategory[$component['component_cty']][] = $component;
		}
		
		//arsort($componentsByCategory);
		//var_dump(array_keys($componentsByCategory));
		TPL::assign('componentList', $componentsByCategory);
		TPL::assign('component_cty', $this->component_cty);
		TPL::assign('page_id', $page_id);
		$this->_display('componentCategory');
	}
	
	/**
	 * \brief 页面组件增加页面
	 */
	function createComponentView()
	{
		$componentId = V('g:component_id', 0);
		$page_id		= V('g:page_id');
/*
		if (empty($componentId))
		{
			$page_id		= V('g:page_id');
			$componentType  = V('g:componentType');
			$url  			= URL('mgr/page_manager.setting', array('id'=>$page_id));
			$componentList	= $this->pm->getCustomeComponent($componentType);
			
			// Default Component Edit Htm
			if (!empty($componentList))
			{
				// 过滤已经添加的 每个页面只能有一个的模块
				$pageComponentList 	= $this->pm->getPageComponentList($page_id);
				$componentList 		= $this->filterPageComponent($componentList, $pageComponentList);
				
				// get the first component properties setting htm
				reset($componentList);
				$aComponent = current($componentList);
				$editHtm = TPL::plugin('mgr/pageManager_createComStep2', array('component_id' => $aComponent['component_id']), FALSE, FALSE);
				TPL::assign('propertiesHtm', $editHtm);
			}
			
			TPL::assign('componentList', $componentList);
			TPL::assign('componentType', $componentType);
			TPL::assign('page_id', $page_id);
			$this->_display('pageManager_createComponentView');
		}
		else {  // Step 2, Set Component Properties

*/
			//$data=
			$editHtm = TPL::plugin('mgr/pageManager_createComStep2', array('component_id' => $componentId, 'page_id' => $page_id), FALSE, FALSE);
			APP::ajaxRst($editHtm);
//		}
	}
	
	
	/**
	 * 过滤某些页面已经添加的，每个页面只能有一个的组件
	 * @param array $componentList
	 * @param array $pageComponentList
	 */
	function filterPageComponent($componentList, $pageComponentList)
	{
		if (empty($pageComponentList))
		{
			return $componentList;	
		}
		
		// filter page component
		$list = array();
		foreach ($componentList as $aComponent)
		{
			$list[$aComponent['component_id']] = $aComponent;
		}
		
		foreach ($pageComponentList as $aPageCom)
		{
			$compId = $aPageCom['component_id'];
			if (isset($list[$compId]['type']) && $list[$compId]['type']==0)
			{
				unset($list[$compId]);
			}
		}
		
		return array_values($list);
	}
	
	
	
	/**
	 * \brief do the create component action
	 */
	function doCreateComponent()
	{
		$page_id = intval(V('p:page_id'));
		$data 	 = (array)(V('p:data'));
		if (empty($page_id) || empty($data['component_id']) )
		{
			$this->_error('操作失败, 页面ID或 组件ID不能为空！', array('default_action'));
		}
		
		// organize data
		$data['page_id']	= $page_id;
		$data['in_use']		= 1;
		$data['isNative']	= 0;
		
		$component			= DS('PageModule.getComponent', '', $data['component_id']);
		$data['title']		= (isset($data['title'])&&$data['title']) ? $data['title'] : $component['title'];
		$data['position']	= $component['component_type'];
		
		$db 	 			= APP::ADP('db');
		$data['sort_num']	= $db->getOne('select max(sort_num) from '. $db->getTable(T_PAGE_MANAGER)) + 1;
		
		// Param
		$param 			= (array)(V('p:param'));
		if (isset($param['topics']) && is_array($param['topics'])) {
			foreach ($param['topics'] as $key =>$value) {
				if (empty($value)) {
					unset($param['topics'][$key]);
				}
			}
		}
		$data['param'] 	= json_encode($param);
		$url 			= URL('mgr/page_manager.setting', array('id'=>$page_id));
		
		// set db and return
		if ($pmId = $db->save($data, '', T_PAGE_MANAGER))
		{
			if (11 == $data['component_id']) {	// 分类用户推荐组件新增特殊处理
				APP::ajaxRst($pmId);
				exit; 
			} else {
				$this->_succ('操作已成功', $url);
			}
		}
		
		$this->_error('操作失败, 请检查一下参数', $url);
	}
	
	
	
	/**
	 * \brief 页面组件设置页
	 */
	function editComponentView()
	{
		$page_id = intval(V('g:page_id'));
		$pmId 	 = intval(V('g:id'));

		if ($pmId) {
			$data 	 = $this->pm->getPageManager($pmId);
			if (empty($data))
			{
				$url = URL('mgr/page_manager.setting', array('id'=>$page_id));
				$this->_error('找不到对应组件,请检查一下参数', $url);
			}
			$component 		= DS('PageModule.getComponent', '', $data['component_id']);
			$data['param'] 	= $this->getEditViewParam($data['param'], $data['component_id']);
			$data['title'] 	= $data['title'] ? $data['title'] : $component['title'];
			TPL::assign('data', $data);
			TPL::assign('pmId', $pmId);
			TPL::assign('component', $component);
		}

		// 取得页面信息
		$page 			= DS('PageModule.getPage', '', $page_id);

		// assign vars' value
		TPL::assign('page', $page);
		TPL::assign('page_id', $page_id);
		$this->_display('pageManager_editComponent');
	}
	
	/**
	 * \ 获取 组件编辑页面的param参数，主要是和组件的默认值合并
	 * @param array $param
	 * @param id $componentId
	 */
	private function getEditViewParam($param, $componentId)
	{
		$param = json_decode($param, TRUE);
		$param = empty($param) ? array() : $param;
		
		$comCfg = DR('PageModule.configList', '', FALSE, $componentId);
		$comCfg = empty($comCfg) ? array() : $comCfg;
		
		return array_merge($comCfg, $param);
	}
	
	
	/**
	 * \brief 保存页面组件属性的修改
	 */
	function doEditComponent()
	{
		// get vars
		$pmId 	 = intval(V('p:pmId'));
		$url  = URL('mgr/page_manager.setting', array('id'=>V('g:page_id')));
		if (!$pmId || !$aPm = $this->pm->getPageManager($pmId))
		{
			$this->_error('找不到对应组件,请检查一下参数', $url);
		}
		$data = V('p:data');
		
		// build the param vars
		$param = (array)(V('p:param'));
		if (isset($param['topic_get']) && 1<=$param['topic_get']) 
		{
			$param['topic_id'] = 0;
		}
		if (isset($param['topics']) && is_array($param['topics'])) {
			foreach ($param['topics'] as $key =>$value) {
				if (empty($value)) {
					unset($param['topics'][$key]);
				}
			}
		}
		// 随便看看要设置默认值
		if( 9 == $aPm['component_id']) {
			DS('components/pubTimeline.config', '', 'source', $param['source']);
			DR('components/pubTimeline.clearCfgCache');
		}
		
		// 自定义微博新建list
		if (isset($param['listName']) && $param['listName']) 
		{
			$list = DR('components/officialWB.createNewList', FALSE, $param['listName']);
			if(isset($list['rst']['id'])) {
				$param['list_id'] = $list['rst']['id'];
				$url 			  = URL('mgr/site_list.memberList', 'listId='.$list['rst']['id']);
			}
		}
		
		
		// check 页面内焦点图的链接 和 背景图src
		if (isset($param['link'])) {
			$param['link'] = F('fix_url', $param['link'], 'http://', 'http://');
		}
		
		if (isset($param['src']) && empty($param['src'])) {
			unset($param['src']);
		}
		
		
		if (is_array($param))
		{
			$pmParam		= json_decode($aPm['param'], TRUE);
			$pmParam		= is_array($pmParam) ? $pmParam : array();
			$data['param']  = json_encode(array_merge($pmParam, $param));
		}
		
		// update and return
		$db 	= APP::ADP('db');
		$result = $db->save($data, $pmId, T_PAGE_MANAGER);
		if ($result || $result===0) 
		{
			$this->delComponentCache($aPm['component_id']);
			$this->_succ('操作已成功', $url);
		} else {
			$this->_error('操作失败！', $url);
		}
	}
	
	
	
	/**
	 * \delete the cache when update success
	 */
	private function delComponentCache($componentId)
	{
		switch ($componentId)
		{
			case 1:		// 热门转发评论
			case 17:		// 微博广场
				DD('components/hotWB.getRepost');
				DD('components/hotWB.getComment');
				break;
			
			case 2:		// 名人推荐
				DD('components/star.get');
				break;
			
			case 3:		// 用户推荐
				DD('components/recommendUser.get');
				break;
			
			case 4:
				DD('components/concern.get');
				break;
			
			case 5:		// 微博频道
				DD('components/officialWB.get');
				break;
			
			case 6:		// 推荐话题
				DD('components/hotTopic.get');
				break;
			
			case 7:		// 猜你喜欢
				DD('components/guessYouLike.get');
				break;
			
			case 8:		// 同城微博
				DD('components/cityWB.get');
				break;
			
			case 9:		// 随便看看
				DD('components/pubTimeline.get');
				break;
			
			case 10:	// 今日话题
				DD('components/todayTopic.get');
				break;
			
			case 12:	// 话题微博
				DD('components/todayTopic.getTopicWB');
				break;
			
			case 14:
				DD('components/pubTimelineBaseApp.get');
				break;
			
			case 15:	// 本站最新开通微博的用户列表
				DD('components/newestWbUser.get');
				break;
			
			
		}
	}
	
	
	
	/*
	* 上传 页面内焦点图
	*/
	function uploadImage() 
	{
		if ($this->_isPost()) 
		{
			$state = 200;
			$file  = V('f:img');
			while ($file && $file['tmp_name']) 
			{
				if ($file['size'] > (MAX_UPLOAD_FILE_SIZE *1024*1024) ) {
					$state = '上传背景图片的大小不能超过'.MAX_UPLOAD_FILE_SIZE.'M';
					break;
				}
				
				//上传文件
				$file_obj = APP::ADP('upload');
				$fileName = 'component_img_'.time();
				if (!$file_obj->upload('img', $fileName, FALSE, 'png')) {
					$state = '复制文件时出错,上传失败';
					break;
				}
				
				//获取上传文件的信息
				$image = $file_obj->getUploadFileInfo();
				break;			
			}
			$savepath = isset($image['savepath']) ? F('fix_url', $image['savepath']) : '';
			echo '<script>parent.uploadFinished("'.$state.'", "'.$savepath.'");</script>';
		}
	}
		
	
	/**
	 * 分类用户推荐组件特殊处理
	 */
	function component11EditView()
	{
		TPL::assign('group_id', V('p:group_id', 0));
		TPL::assign('item_name', V('p:item_name', ''));
		$this->_display('components_11_edit');
	}
	
	
	/**
	 * 分类用户推荐组件特殊处理
	 */
	function doComponent11Edit()
	{
		$op 		= V('p:op'); //操作:add, del, edit
		$itemgroup  = APP::N('itemGroups');
		$result 	= '';
		$errno  	= 0;
		
		switch ($op)
		{
			case 'add':
				$item_id 	= intval(V('p:item_id'));
				$item_name 	= V('p:item_name');
				$group_id	= v('p:group_id');
				
				if ($itemgroup->hasItem($group_id, $item_id)) 
				{
					$result = false;
					$errno  = 11013;
				} else 
				{
					$obj 			= new stdClass();
					$obj->group_id 	= $group_id;
					$obj->item_id 	= $item_id;
					$obj->item_name = $item_name;

					$result = $itemgroup->addItem($obj);
					if ($result) {
						DS('mgr/userRecommendCom.addRelatedId', '', $item_id, 11, 1);
					}
				}
			break;

			case 'del':
				$id 	= V('p:id');
				$g  	= $itemgroup->getItem($id);
				$result = $itemgroup->delItem($id);

				if ($result && !empty($g)) {
					//维护引用关系
					DS('mgr/userRecommendCom.delRelatedId', '', $g['item_id'], 11, 1);
				}
			break;

			case 'edit':
				$obj = new stdClass();
				$obj->group_id = V('p:group_id');
				$obj->item_id = V('p:item_id');
				$obj->item_name = V('p:item_name');

				$result = $itemgroup->saveItem($obj, V('p:id'));
			break;
		}

		
		if ($result) {
			DD('components/categoryUser.getGroups');
		}

		APP::ajaxRst($result, $errno);
	}
	
	
	
	/**
	 * \brief 删除页面组件
	 */
	function delComponent()
	{
		$pmId 	= intval(V('g:pmId'));
		$db 	= APP::ADP('db');
		$url	= URL('mgr/page_manager.setting', array('id'=>V('g:page_id')));
		
		if ($pmId && $data = $db->get($pmId, T_PAGE_MANAGER)) 
		{
			if (empty($data['isNative']))
			{
				// delete the page_manager record
				if ($db->delete($pmId, T_PAGE_MANAGER)) {
					$this->_succ('操作已成功', $url);
				}
			} else {
				$this->_error('温馨提示：不能删除系统预设组件', $url);
			}
		} 
		$this->_error('操作失败，请检查输入参数是否正确', $url);
	}
	
	
	
	/**
	 * \brief create page view
	 */
	function createPageView()
	{
		$pageList = DR('PagePrototype.prototypeList', FALSE, PAGE_TYPE_CURRENT);
		TPL::assign('pageList', $pageList);
		$this->_display('pageManager_createPageView');
	}
	
	
	/**
	 * \brief do create page
	 */
	function doCreatePage()
	{
		$data 	= (array)(V('p:data'));
		$proId 	= $data['prototype_id'];
		$url 	= URL('mgr/page_manager');
		if ( empty($proId) || !$prototype=DR('PagePrototype.getPrototypeById',FALSE,$proId) )
		{
			$this->_error('操作失败, 页面类型ID为空或页面类型不存在！', $url);
		}
		
		// organize data
		$db 			= APP::ADP('db');
		$data['native']	= 0;
		$data['url']	= $prototype['url'];
		
		if ( $pageId = $db->save($data,'',T_PAGES) )
		{
			// insert page's component
			$this->addPageComponents($db, $pageId, json_decode($prototype['components'], TRUE));
			$this->_succ('操作已成功', URL('mgr/page_manager.setting', array('id'=>$pageId)) );
		}
		
		$this->_error('操作失败, 请检查一下参数', $url);
	}
	
	/**
	 * \brief add page components when create page
	 * @param dbconnect $db
	 * @param int $pageId
	 * @param array $componentList
	 */
	private function addPageComponents(&$db, $pageId, $componentList)
	{
		if (empty($pageId) || empty($componentList)) {
			return FALSE;
		}
		
		foreach ($componentList as $aComponent)
		{
			$aComponent['page_id'] = $pageId;
			$db->save($aComponent, '', T_PAGE_MANAGER);
		}
		return TRUE;
	}
	
	
	
	/**
	 * \brief do the eidt page action
	 */
	function doEditPage()
	{
		// get vars
		$pageId = intval(V('p:id'));
		$db 	= APP::ADP('db');
		if (!$pageId || !$data=$db->get($pageId,T_PAGES,'page_id') )
		{
			$this->_error('找不到对应页面,请检查一下参数', array('default_action'));
		}
		
		// update and return
		$url  = URL('mgr/page_manager.setting', array('id'=> $pageId));
		$data = (array)(V('p:data'));
		if ( $db->save($data,$pageId,T_PAGES,'page_id') ) 
		{
			$this->_succ('操作已成功', $url);
		} 
		
		$this->_error('操作失败！', $url);
	}
	
	
	
	/**
	 * \brief 删除页面
	 */
	function delPage()
	{
		$pageId = intval(V('g:id'));
		$db 	= APP::ADP('db');
		$url	= URL('mgr/page_manager');
		
		if ( $pageId && $data=$db->get($pageId,T_PAGES,'page_id') ) 
		{
			
			//导航是否在使用？（不管是否在显示）
			$navdata = DR('Nav.getNavByPageId', null, $pageId);
			if(!empty($navdata)){
				$this->_error('温馨提示：导航栏正使用该页面，不能删除', $url);
			}
			
			if (empty($data['native']))
			{
				// delete the 页面组件
				$db->delete($pageId, T_PAGE_MANAGER, 'page_id');
				
				// delete the page record
				if ( $db->delete($pageId,T_PAGES,'page_id') ) {
					$this->_succ('操作已成功', $url);
				}
			} else {
				$this->_error('温馨提示：不能删除系统预设组件', $url);
			}
		} 
		$this->_error('操作失败，请检查输入参数是否正确', $url);
	} 
}
