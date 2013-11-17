<?php
/**
 * @file			content_unit.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-12-17
 * @Modified By:	heli/2010-12-17
 * @Brief			内容单元设置-Xweibo
 */

include('action.abs.php');
class content_unit_mod extends action {
	var $_unitName = array(
							1 => '微博秀',
							2 => '用户列表',
							3 => '互动话题',
							4 => '一键关注',
							5 => '群组微博'
						);
	
	function content_unit_mod() {
		parent :: action();
	}

	
	/**
	 * 内容单元列表
	 *
	 *
	 */
	function default_action() {
//		$rs = array();
//		$rs = DR('mgr/contentUnitCom.getContentUnitById');
//        TPL :: assign('list', $rs['rst']);
//        TPL :: assign('unitType', $this->_unitName);
//        TPL :: display('mgr/unit/content_unit_list', '', 0, false);
		TPL :: display('mgr/unit/content_unit_type', '', 0, false);
	}

	/**
	 * 内容单元类型
	 *
	 *
	 */
	function show() {
        TPL :: display('mgr/unit/content_unit_type', '', 0, false);
	}

	/**
	 * 添加内容单元
	 *
	 *
	 */
	function add() {
		$type = (int)V('g:type', 1);
		$rs = DR('mgr/contentUnitCom.getContentUnitByType','',$type);
		TPL :: assign('list', $rs['rst']);
		$row = array();
		$row['title'] = '';
		switch ($type) {
			case 1:
				$row['unit_name'] = '微博秀';
				$row['target'] = USER::get('screen_name');
				break;
			case 3:
				$row['target']= 'xweibo';
				$row['unit_name'] = '大家都在聊'.$row['target'];
				break;
			case 2:
			case 4:		
			case 5:
				$rs = DR('mgr/userRecommendCom.getById');
				$re_list = $rs['rst'];
				$row['target']= $re_list[1]['group_id'];
				TPL::assign('re_list', $re_list);
				$row['title'] = $row['unit_name'] = ($type === 2 ? '推荐关注' : $this->_unitName[$type]);
				break;
		}

		TPL::assign('iframe_code', $this->_getUnitCode(null, $row['unit_name'], $row['target'], $row['title'], $type, true));
		TPL::assign('iframe_url', $this->_getUnitCode(null, $row['unit_name'], $row['target'], $row['title'], $type));
		TPL::assign('row', $row);
		TPL::assign('type', $type);
		TPL::assign('unitType', $this->_unitName[$type]);
		TPL::assign('preview_url', W_BASE_HTTP.URL('output', '', 'index.php'));
        TPL :: display('mgr/unit/add_content_unit', '', 0, false);
	}

	/**
	 * 编辑设置内容单元
	 *
	 *
	 */
	function set() {
		$id = V('g:id', false);
		if (empty($id)) {
		} 
		
		$type = (int)V('g:type',1);
		$rs = DR('mgr/contentUnitCom.getContentUnitByType','',$type);
		TPL :: assign('list', $rs['rst']);
		if (in_array($type, array(2, 4, 5))) {
			$rs = DR('mgr/userRecommendCom.getById');
			$re_list = $rs['rst'];
			TPL::assign('re_list', $re_list);
		}

		$rst = array();
		$rst = DR('mgr/contentUnitCom.getContentUnitById', '', $id);
		$rst['rst'][0]['colors'] = explode('|', $rst['rst'][0]['colors']);

		TPL::assign('iframe_code', $this->_getUnitCode($rst['rst'][0], null, null, null, $type, true));
		TPL::assign('iframe_url', $this->_getUnitCode($rst['rst'][0], null, null, null, $type));
		TPL::assign('row', $rst['rst'][0]);
		TPL::assign('type', $type);
		TPL::assign('unitType', $this->_unitName[$type]);
		TPL::assign('id', $id);
		TPL::assign('preview_url', W_BASE_HTTP.URL('output', '', 'index.php'));
        TPL :: display('mgr/unit/add_content_unit', '', 0, false);
	}

	/**
	 * 保存内容单元
	 *
	 *
	 */
	function save() {
		if($this->_isPost()) {
			$id = V('p:id', false);
			$unit_name = htmlspecialchars(trim(V('p:unit_name', '')));
			$title = trim(V('p:title', ''));
			$type = V('p:type', 1);
			$width = trim(V('p:width', 0));
			$height = trim(V('p:height', 0));
			$target = trim(V('p:target', false));
			$show_title = V('p:show_title', 0);
			$show_border = V('p:show_border', 0);
			$show_logo = V('p:show_logo', 0);
			$skin = V('p:skin', 1);
			$show_publish = V('p:show_publish', 0);
			$auto_scroll = V('p:auto_scroll', 0);
			/*
			$color_title = trim(V('p:color_title'), '#');
			$color_bg = trim(V('p:color_bg'), '#');
			$color_font = trim(V('p:color_font'), '#');
			$color_link = trim(V('p:color_link'), '#');
			$colors = empty($skin) ? null : $color_title.'|'.$color_bg.'|'.$color_font.'|'.$color_link;
			 */

			$data = array();
			$data = array('unit_name' => $unit_name,
				'title' => $title,
				'type' => $type,
				'width' => $width,
				'height' => $height,
				'target' => $target,
				'show_title' => $show_title,
				'show_border' => $show_border,
				'show_logo' => $show_logo,
				'skin' => $skin,
				'show_publish' => $show_publish,
				'auto_scroll' => $auto_scroll,
				'add_time' => APP_LOCAL_TIMESTAMP);

			if ($id) {
				/// 编辑内容输出单元
				$rs = DR('mgr/contentUnitCom.editContentUnit', '', $data, $id);
			} else {
				/// 添加内容输入单元
				$rs = DR('mgr/contentUnitCom.addContentUnit', '', $data);
			}
			if(!$rs['rst']) {
				$this->_error('操作失败！', URL('mgr/content_unit.show'));
			}
			
			$this->_succ('操作已成功', URL('mgr/content_unit.add','type='.$type));
		}
	}	

	/**
	 * 删除内容单元
	 *
	 *
	 */
	function del() {
		$id = V('g:id', '');
		$type = V('g:type', '');
		if (!is_numeric($id)) {
			$this->_error('参数错误！', URL('mgr/content_unit'));
		}

		$rs = DR('mgr/contentUnitCom.deleteContentUnit', '', $id);
		if(!$rs['rst']) {
			$this->_error('操作失败！', URL('mgr/content_unit'));
		}

		$this->_succ('操作已成功', URL('mgr/content_unit.add','type='.$type));
	}

	/**
	 * 获取输出单元的url代码
	 *
	 *
	 */
	function _getUnitCode($row, $unit_name = null, $target = null, $title = null, $type = 1, $code = false) {
		$unit_name = isset($row['unit_name']) ? $row['unit_name'] : urlencode($unit_name);
		$target = isset($row['target']) ? $row['target'] : $target;
		$title = isset($row['title']) ? $row['title'] : $title;
		$width = isset($row['width']) ? $row['width'] : 0;
		$height = isset($row['height']) ? $row['height'] : 550;
		$skin = isset($row['skin']) ? $row['skin'] : 1;
		$show_logo = isset($row['show_logo']) ? $row['show_logo'] : 1;
		$show_title = isset($row['show_title']) ? $row['show_title'] : 1;
		$show_border = isset($row['show_border']) ? $row['show_border'] : 1;
		$show_publish = isset($row['show_publish']) ? $row['show_publish'] : 1;
		$auto_scroll = isset($row['auto_scroll']) ? $row['auto_scroll'] : 1;

		$iframe_url = W_BASE_HTTP.URL('output', 'target='.urlencode($target).'&unit_name='.urlencode($unit_name).($type == 5 ? '&title=' . urlencode($title) : '').'&width='.$width.'&height='.$height.($type == 3 ? '&show_publish=' . $show_publish . '&auto_scroll=' . $auto_scroll : '').'&show_logo='.$show_logo.'&show_title='.$show_title.'&show_border='.$show_border.'&skin='.$skin.'&type='.$type.'&_='.APP_LOCAL_TIMESTAMP, 'index.php');
		if ($code) {
			$unit_code = '<iframe class="exp-main" id="export" name="export" frameborder="0" width="100%" height="'.$height.'" src="'.$iframe_url.'"  scrolling="no"></iframe>';
			return $unit_code;
		} 
		return $iframe_url; 
	}
}
