<?php
include('action.abs.php');
define('AUTO_ATTEND_ID', 2);

class plugins_mod extends action {

	function plugins_mod() {
		parent :: action();
	}

	
	/**
	 * 插件列表
	 */
	function default_action() 
	{
		$plugins = DS('Plugins.getList');
		TPL::assign('plugins', $plugins);
		$this->_display('plugin_list');
	}

	
	function config() {
		$id = V('g:id');

		TPL::assign('id', $id);

		switch ($id) {
			case 1:
				$this->ad();
				break;

			case 2:
				$rs = DS('dsIndexFocus.get');

				TPL::assign('cfg', $rs);

				$this->_display('index_focus');
				break;

			case 3:
				$list = DS('plugins/adProfile.get');
				
				TPL :: assign('list', $list);

				$this->_display('ad_profile');
				break;

			case 4:

				$autoFollow = DS('common/sysConfig.get', '', 'guide_auto_follow');


				TPL::assign('autoFollow', $autoFollow);

				//if ($autoFollow) { //自动关注
					$followId = DS('common/sysConfig.get','', 'guide_auto_follow_id');
					$result = DR('mgr/userRecommendCom.getUserById', '', $followId);
					$rst = '';

					if ($result['errno'] == 0) {
						$rst = &$result['rst'];

						if (count($rst) > 3) {
							$rst = array_slice($rst, 0, 3);
						}
						TPL::assign('autoFollowUsers', $rst);
					}

				//}
				$list =  DS('mgr/userRecommendCom.getById');
				TPL::assign('list', $list);

				$itemGroup = APP::N('itemGroups');

				$groups = $itemGroup->getItems(AUTO_ATTEND_ID);

				TPL::assign('groups', $groups);

				$auto = DS('common/sysConfig.get', '', 'guide_auto_follow');

				$auto = $auto == '1' ? 1: 0;

				TPL::assign('auto', $auto);

				$autoFollowId = DS('common/sysConfig.get', '', 'guide_auto_follow_id');

				TPL::assign('autoFollowId', $autoFollowId);

				$this->_display('plugins_guide');
			break;
		}
	}

	function pluginGuideView() {
		if ($item_id = V('g:item_id', false)) {
			$itemgroup = APP::N('itemGroups');
			$info = $itemgroup->getItem($item_id);
			TPL::assign('info', $info);
		}
		$this->_display('pluginGuideView');
	}
	
	
	/**
	 * 用户分组推荐异步处理接口
	 *
	 */
	function itemgroup() {
		$op = V('r:op'); //操作:add, del, edit

		$item_id = V('p:item_id');
		$item_name = V('p:item_name');

/*
		$data = V('p:data');
		$item_id = $data['title'];
		$param = V('p:param');
		$item_name =$param['group_id'];
*/
		$id = V('p:id');

		$itemgroup = APP::N('itemGroups');

		$result = '';

		switch ($op){
			case 'add':
				$obj = new stdClass();
				$obj->group_id = 2;
				$obj->item_id = $item_id;
				$obj->item_name = $item_name;

				$result = $itemgroup->addItem($obj);
			break;

			case 'del':
				$result = $itemgroup->delItem($id);
			break;

			case 'edit':
				$obj = new stdClass();
				$obj->group_id = 2;
				$obj->item_id = $item_id;
				$obj->item_name = $item_name;

				$result = $itemgroup->saveItem($obj, $id);
				if ($result !== false) {
					$result = true;
				}
			break;
		}

		if ($result) {
			DD('components/categoryUser.getGroups');
		}

		APP::ajaxRst($result, $result?0:1);
		exit;
	}

	/**
	 * 广告设置
	 *
	 */
	function ad() {
		$this->_display('ad_setting');
	}

	/**
	 * 保存设置
	 *
	 */
	function save() {
		$id = V('r:id');

		if ($id == 1) {
//			$ad_header = V('p:ad_header', '');
			$ad_footer = V('p:ad_footer', '');

			$rs = DS('Plugins.save', '', $id, array(
//				'ad_header' => $ad_header,
				'ad_footer' => $ad_footer
			));


			$this->_succ('操作已成功', array('default_action','plugins'));

		} else if ($id == 3) 
		{
			$title 		= V('r:title');
			$link_id 	= V('r:link_id');
			$link 		= V('r:link');
			$link		= F('fix_url', $link, 'http://', 'http://');
			$op 		= V('r:op');
			
			if ($op == 'add' || $op == 'mod') {

				$rs = DR('plugins/adProfile.save', '', array('title' => $title, 'link' => $link), $link_id);
				APP::ajaxRst(array('id'=>$rs['rst'], 'link'=>$link));
				exit;

			} elseif ($op == 'del') {

				$rs = DR('plugins/adProfile.del', '', $link_id);
			}

			APP::ajaxRst($rs['rst']);
			exit;
		} else if ($id == 2) {
			//图片处理
			$img = V('f:bg');
			$bgPath = '';
			if ($img && $img['name'] && $img['error']) {
				$this->_error('上传的图片不符合规格',$_SERVER['HTTP_REFERER']);
			}

			if ($img && $img['tmp_name']) {
                $uploader = APP::ADP('upload');
                
                $subdir = '/data/index/';
                
                $path = P_VAR_NAME . $subdir;
                
                $uploader->upload('bg', 'indexfc', $path, 'jpg,png');
                
                $error = $uploader->getErrorCode();
                
                if ($error != 0) {
                    $this->_error($uploader->getErrorMsg(), $_SERVER['HTTP_REFERER']);
                }
                
                $fileInfo = $uploader->getUploadFileInfo();
                $bgPath = $fileInfo['savepath'];//$subdir . $fileInfo['savename'] . '.' . $fileInfo['extension'];

			}

			$keys = array('title', 'text', 'oper', 'topic', 'link', 'btnTitle');
			$data = array();
			foreach ($keys as $key) {
				$data[$key] = V('p:'.$key);
			}
			
			//判断链接地址是否以http开头
			$data['link'] = F('fix_url', $data['link'], 'http://', 'http://');

			//背景图
			$data['bg_pic'] = $bgPath;

			$focus = APP::N('indexFocus');

			$rs = $focus->save($data);

			if ($rs) {
				//清除缓存
				DD('dsIndexFocus.get');

				//APP::redirect(URL('mgr/plugins.config', array('id' => 2)), 3);
				$this->_succ('操作已成功', URL('mgr/plugins.config', array('id' => 2)));
				exit;
			}
			echo '保存失败';
		} else if ($id == 4) {
			$autoFollow = V('p:auto_follow');
			$autoFollowId = V('p:autoFollowId');

			DS('common/sysConfig.set', '', 'guide_auto_follow', $autoFollow);
			DS('common/sysConfig.set', '', 'guide_auto_follow_id', $autoFollowId);

			$this->_succ('操作已成功', array('default_action','plugins'), true);
		}
	}

	
	
	/**
	 * 保存设置
	 */
	function setStatus() 
	{
		$id 	= V('g:id');
		$status = V('g:inuse');
		$rs 	= DS('Plugins.setStatus', '', $id, $status);

		APP::redirect(URL('mgr/plugins'), 3);
	}

}
