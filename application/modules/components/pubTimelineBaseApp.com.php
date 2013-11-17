<?php
/**
* 当前站点最新发布的微博列表
*
* @version $Id: pubTimelineBaseApp.com.php 17362 2011-06-20 00:59:48Z heli $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author yaoying
*
*/
require_once P_COMS . '/PageModule.com.php';

class pubTimelineBaseApp extends PageModule{

	var $component_id = 14;

	function pubTimelineBaseApp() {
		parent :: PageModule();
	}

	function get($param = array()) 
	{
		$wb_ids = array();
		$cfg 		= $this->configList();
		$show_num	= isset($param['show_num']) ? (int)$param['show_num'] : 20;

		$wb_list = DR('xweibo/weiboCopy.getList', '', array('disabled' => '0'), $show_num);
		foreach ($wb_list as $wb) {
			$wb_ids[] = $wb['id'];
		}
		//$list = DR('xweibo/xwb.getPublicTimeline', '', 1);
		if ($wb_ids) {
			if (USER::isUserLogin()) {
				$list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $wb_ids));
			} else {
				$list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $wb_ids), true, false);
			}
		} else {
			$list['rst'] = array();
			$list['errno'] = '';
			$list['err'] = '';
		}

		
		return RST($list['rst'], $list['errno'], $list['err']);
	}
}
