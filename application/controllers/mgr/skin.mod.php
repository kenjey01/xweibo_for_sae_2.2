<?php
include('action.abs.php');
class skin_mod extends action {
	function skin_mod() {
		parent :: action();
	}
	/**********************以下为皮肤分类管理**********************************************/
	/*
	 * 获取所有皮肤分类
	 */
	function getAllSkinSort() {
		$rs = "";
		$rs = DR('mgr/skinCom.getSkinSortById');
        TPL :: assign('list', $rs['rst']);
        TPL :: display('mgr/skin/skin_categorylist', '', 0, false);
	}

	/*
	 * 添加皮肤分类
	 */
	function addSkinSort() {
		$rs = DR('mgr/skinCom.getSkinSortById');
		$count = count($rs['rst']);
		if($count >= 5) {
			$this->_error('类别个数已达上限，无法添加!', URL('mgr/skin.getAllSkinSort'));
		}

		if($this->_isPost()) {
			$name = htmlspecialchars(trim(V('p:style_name', '')));

			if(empty($name)) {
				$this->_error('类别名称不能为空！', URL('mgr/skin.getAllSkinSort'));
			}
			
			$data = array(
				'style_name' => $name
			);

			$rs = DR('mgr/skinCom.addSkinSort', '', $data);
			if(!$rs['rst']) {
				$this->_error('操作失败！', URL('mgr/skin.getAllSkinSort'));
			}

			$this->_succ('操作已成功', array('getAllSkinSort'));
		}
	
	}

	/*
	 * 删除皮肤分类
	 */
	function delSkinSort() {
		$id = V('g:id', '');
		if (!is_numeric($id)) {
			$this->_error('参数错误！', URL('mgr/skin.getAllSkinSort'));
		}

		$rs = DR('mgr/skinCom.delSkinSort', '', $id);
		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/skin.getAllSkinSort'));
		}

		$this->_succ('操作已成功', array('getAllSkinSort'));
	}

	/*
	 * 编辑皮肤分类
	 */
	function editSkinSort() {
		if($this->_isPost()) {
			$name = htmlspecialchars(trim(V('p:style_name', '')));
			$id = V('p:style_id', '');
			if (!is_numeric($id) || empty($name)) {
				$this->_error('参数错误！', URL('mgr/skin.getAllSkinSort'));
			}
			
			$data = array('style_name' => $name);
			$rs = DR('mgr/skinCom.editSkinSort', '', $data, $id);

			if(!$rs['rst']) {
				$this->_error('操作失败！', URL('mgr/skin.getAllSkinSort'));
			}
			
			$this->_succ('操作已成功', array('getAllSkinSort'));
		}

		$id = V('g:id', '');
		if (!is_numeric($id)) {
			$this->_error('参数错误！', URL('mgr/skin.getAllSkinSort'));
		}

		$rs = DR('mgr/skinCom.getSkinSortById', '', $id);
		if(!$rs['rst']) {
			$this->_error('获取数据失败！', URL('mgr/skin.getAllSkinSort'));
		}
		TPL :: assign('editvalue', $rs['rst']);

	}

	/*
	* 根据skin_id串对皮肤类别进行排序
	*/
	function setSkinSortOrderById() {
		$style_ids = V('p:style_ids', '');	//皮肤类别id串

		if(!$style_ids) {
			exit('{"rst":false,"errno":0,"err":"参数错误！"}');
			//$this->_error('参数错误！', URL('mgr/skin.getAllSkinSort'));
		}

		//$style_arr = explode(",", $style_ids);
		foreach($style_ids as $key=>$style_id) {
			$rs = DR('mgr/skinCom.setSkinSortOrderById', '', $style_id, $key+1);
			if(!$rs['rst']) {
				exit('{"rst":false,"errno":0,"err":"操作失败！"}');
				//$this->_error('操作失败！', URL('mgr/skin.getAllSkinSort'));
			}
		}

		exit('{"rst":true,"errno":0,"err":"操作已成功!"}');
		//$this->_succ('操作已成功', array('getAllSkinSort'));
	}
	
	/**
	  *  皮肤tab页 
	  */
	function getAllSkin(){
		$rs = $rss = $rst = $info = $sort = $rows = $skin_sort_rows = $sysconfig = '';
		//扫描皮肤目录并入库
		$rs = DR('mgr/skinCom.scanSkinDirectory');
		foreach($rs['rst'] as $value) {
			$rss = DR('mgr/skinCom.readSkinConfig', '', $value['location'] . '/' . SKIN_CONFIG);
			if($rss['rst']) {
				$info = DR('mgr/skinCom.getskinByName', '', $value['name']);
				if(!$info['rst']) {
					$rss['rst']['directory'] = $value['name'];
					$rst = DR('mgr/skinCom.InsertSkinInfo', '', $rss['rst']);
				}
			}
		}

		//获取皮肤分类
		$rs = DR('mgr/skinCom.getSkinSortById');

		foreach($rs['rst'] as $value) {
			$sort[$value['style_id']] = $value;
		}
		$sort[0] = array('style_id'=>0, 'style_name'=>'未分类', 'sort_num'=>count($sort));
		
		//从数据库中获取所有皮肤
		$rs = DR('mgr/skinCom.getSkinById');
		foreach($rs['rst'] as $value) {
			if(isset($value['style_id'])&&$sort[$value['style_id']]) {
				$value['skin_group'] = $sort[$value['style_id']];
			}
			if($value['directory'] == SITE_SKIN_CSS_PRE . SITE_SKIN_TYPE) {		//如果是系统默认模板，就不显示
				$value['state'] = -1;
			}
			$rows[$value['skin_id']] = $value;
			$skin_sort_rows[$value['style_id']][$value['skin_id']] = $value;
		}

		$sysconfig = DR('common/sysConfig.get');

		TPL :: assign('list', $rows);	//全部皮肤
		TPL :: assign('skin_sort_list', $skin_sort_rows);	//其他分类皮肤
		TPL :: assign('sort', $sort);
		TPL :: assign('sysconfig', $sysconfig['rst']);
		$customSkin=USER::sys('skin_custom');
		if(isset($customSkin)){
			TPL::assign('customSkin',json_decode($customSkin,TRUE));	
		}
		
		TPL::assign('colorConf',DS('getSkinColors','g/0'));
		TPL :: display('mgr/skin/skin_tab', '', 0, false);
	}
	/**
	  *  后台自定义皮肤 
	  */
	function customSkin(){
		//获取用户自定义属性
		$customSkin=USER::sys('skin_custom');
		if(isset($customSkin)){
			TPL::assign('customSkin',json_decode($customSkin,TRUE));	
		}
		//var_dump($customSkin);
		TPL :: display('mgr/skin/skin_custom', '', 0, false);
	}

	/*
	 * 编辑该皮肤所属的分类
	 */
	function editSkin() {
		if($this->_isPost()) {
			$id = V('p:id', '');	//id
			$style_id = V('p:style_id', '');	//皮肤分类id
			
			if(!is_numeric($id) || !is_numeric($style_id)) {
				$this->_error('参数错误！', URL('mgr/skin.getAllSkin'));
			}

			//检测该皮肤是否符合修改条件
			$rs = DR('mgr/skinCom.getSkinById', '', $id);
			if(!$rs['rst'] || @$rs['rst']['state'] == 2) {
				$this->_error('操作失败！', URL('mgr/skin.getAllSkin'));
			}

			//修改该皮肤的皮肤分类
			$rs = DR('mgr/skinCom.setSkinSort', '', $id, $style_id);
			if(!$rs['rst']) {
				$this->_error('操作失败！', URL('mgr/skin.getAllSkin'));
			}

			$this->_succ('操作已成功', array('getAllSkin'));
		}

		$id = V('g:id', '');	//id
		if(!is_numeric($id)) {
			$this->_error('参数错误！', URL('mgr/skin.getAllSkin'));
		}

		//检测该皮肤是否符合修改条件
		$rs = DR('mgr/skinCom.getSkinById', '', $id);
		if(!$rs['rst'] || @$rs['rst']['state'] == 2) {
			$this->_error('操作失败！', URL('mgr/skin.getAllSkin'));
		}

		//获取所有皮肤分类
		$sort = DR('mgr/skinCom.getSkinSortById');

		TPL :: assign('skin', $rs['rst'][0]);
		TPL :: assign('sort', $sort['rst']);
	    TPL :: display('mgr/skin/editskin', '', 0, false);
	}

	/*
	 * 设置该皮肤为启用，禁用状态
	 */
	function setSkinState() {
		$state = V('g:state', '');	//皮肤状态
		$id = V('g:id', '');	//id
		if(!is_numeric($state) || !is_numeric($id) || $state > 1 || $state < 0) {
			$this->_error('参数错误！', URL('mgr/skin.getAllSkin'));
		}

		//检测该皮肤是否符合设置条件
		$rs = DR('mgr/skinCom.getSkinById', '', $id);
		if(!$rs['rst'] || @$rs['rst']['state'] == 2) {
			$this->_error('操作失败！', URL('mgr/skin.getAllSkin'));
		}

		//设置皮肤状态
		$rs = DR('mgr/skinCom.setSkinState', '', $state, $id);
		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/skin.getAllSkin'));
		}

		$this->_succ('操作已成功', array('getAllSkin'));
	}

	/*
	 * 设置默认模板
	 */
	function setSkinDefault() {
		$id = V('p:skin_default_id', '');	//皮肤id

		if(!$id) {
			$this->_error('所有皮肤已全部禁用，不能设置默认皮肤！', URL('mgr/skin.getAllSkin'));
		}
		if(!is_numeric($id)) {
			$this->_error('参数错误！', URL('mgr/skin.getAllSkin'));
		}

		//检测该皮肤是否符合设置条件
		$rs = DR('mgr/skinCom.getSkinById', '', $id);
		if(!$rs['rst'] || @$rs['rst']['state'] == 2) {
			$this->_error('操作失败！', URL('mgr/skin.getAllSkin'));
		}

		//设置默认模板
		$rs = DR('common/sysConfig.set', '', 'skin_default', $id);
		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/skin.getAllSkin'));
		}
		else{
			DR('common/sysConfig.set', '', 'default_use_custom', 0);
		}
		$this->_succ('操作已成功', array('getAllSkin'));
	}

	/*
	 * 根据皮肤分类id获取该类别的皮肤
	 */
	/*
	function getSkinByStyleId() {
		$id = V('g:style_id', '');	//皮肤id
		if(!is_numeric($id)) {
			$this->_error('参数错误！', URL('mgr/skin.getAllSkin'));
		}

		$rs = DR('mgr/skinCom.getSkinByStyleId', '', $id);
		TPL :: assign('skin', $rs['rst'][0]);
		TPL :: assign('sort', $sort['rst']);
	    TPL :: display('mgr/skin/editskin', '', 0, false);
	}
	*/
}
?>