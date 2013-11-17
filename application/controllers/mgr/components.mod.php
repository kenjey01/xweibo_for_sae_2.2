<?php
include('action.abs.php');

//分类用户推荐分组ID
define('USER_CATEGORY_RECOMMEND_ID', 1);

class components_mod extends action {
	
	//ID ->　组件类的映射
	var $nameMap = array(
			'1' => 'hotWB',
			'2' => 'star',
			'3' => 'recommendUser',
			'4' => 'concern',
			'5' => 'officialWB',
			'6' => 'hotTopic',
			'7' => 'guessYouLike',
			'8' => 'cityWB',
			'9' => 'pubTimeline',
			'10' => 'todayTopic',
			'11' => 'categoryUser',
			'12' => 'todayTopic'
		);

	function components() {
		parent :: action();
	}

	
	/**
	 * 模块列表
	 */
	function default_action() 
	{
		exit('NO SUCH PAGE OR DIRECTORY.');
	}
	

	/**
	 * 显示组件设置
	 *
	 */
	function config() {
		$id = V('g:id');

		if ($id) {
			$cfg = DS('PageModule.configList', null, true, $id);
			$com = DS('PageModule.getComponent', null, $id);
		}

		TPL::assign('id' , $id);
		TPL::assign('cfg', $cfg);
		TPL::assign('com', $com);

		switch ($id) {
			case 11:
				$list =  DS('mgr/userRecommendCom.getById');
				TPL::assign('list', $list);
				
				$itemGroup = APP::N('itemGroups');

				$groups = $itemGroup->getItems(USER_CATEGORY_RECOMMEND_ID);

				TPL::assign('groups', $groups);

				$this->_display('components_config_cate');
			break;

			default:
				$this->_display('components_config');
		}
	}

	/**
	 * 用户分组推荐异步处理接口
	 *
	 */
	function itemgroup() {
		$op = V('p:op'); //操作:add, del, edit

		$item_id = V('p:item_id');
		$item_name = V('p:item_name');
		$id = V('p:id');

		$itemgroup = APP::N('itemGroups');

		$result = '';
		$errno = 0;

		switch ($op){
			case 'add':
					if ($itemgroup->hasItem(USER_CATEGORY_RECOMMEND_ID, $item_id)) {
						$result = false;
						$errno = 11013;
					} else {
						$obj = new stdClass();
						$obj->group_id = USER_CATEGORY_RECOMMEND_ID;
						$obj->item_id = $item_id;
						$obj->item_name = $item_name;

						$result = $itemgroup->addItem($obj);

						if ($result) {
							DS('mgr/userRecommendCom.addRelatedId', '', $item_id, 11, 1);
						}
					}
			break;

			case 'del':
				$g = $itemgroup->getItem($id);

				$result = $itemgroup->delItem($id);

				if ($result && !empty($g)) {
					//维护引用关系
					DS('mgr/userRecommendCom.delRelatedId', '', $g['item_id'], 11, 1);
				}
			break;

			case 'edit':
				$obj = new stdClass();
				$obj->group_id = USER_CATEGORY_RECOMMEND_ID;
				$obj->item_id = $item_id;
				$obj->item_name = $item_name;

				$result = $itemgroup->saveItem($obj, $id);
			break;
		}

		if ($result) {
			DD('components/categoryUser.getGroups');
		}

		APP::ajaxRst($result, $errno);
		exit;
	}

	/**
	 * 设置组件配置
	 *
	 */
	function set() {
		$id = V('p:id');

		//保存显示条数
		$show_num = V('p:show_num');

		$com = 'components/' . $this->nameMap[$id];

		if ($show_num) {
			$numResult = DR($com . '.config', null, 'show_num', $show_num, $id);
		}
		

		///保存是否要数据隔离
		$source = V('p:source');
		if ($source == 1) {
			DR($com . '.config', null, 'source', 0, $id);
		} elseif ($source == 2) {
			DR($com . '.config', null, 'source', 1, $id);
		}

		$cache_key = 'get';

		switch ($id) {
			case 1:
				$cache_key = array('getRepost', 'getComment');
				break;

			case 2:
			case 6:
				$type = V('p:topic_get');
				
				if ($type == 1) {
					$topic_id = '0';
				} else {
					$topic_id = V('p:topic_id');
				}
				DS($com . '.config', null, 'topic_id', $topic_id);

				break;

			case 12:
				$cache_key = 'getTopicWB';
				
				// update 话题内容
				$topic = V('p:topic');
				if ($topic) {
					DR('PageModule.config', null, 'topic', $topic, $id);
				}
			
		}

		//清除配置缓存
		DR($com . '.clearCfgCache');

		//清除数据缓存
		if ($cache_key) {
			if (is_array($cache_key)) {
				foreach($cache_key as $key) {
					DD($com . '.' . $key);
				}
			} else {
				DD($com.'.'.$cache_key);
			}
		}

		$this->_succ('操作已成功', array('default_action'));
	}
}
