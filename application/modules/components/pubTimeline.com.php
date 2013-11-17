<?php
/**
* 随便看看
*
* @version $1.1: pubTimeline.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class pubTimeline extends PageModule{

	var $component_id = 9;

	function pubTimeline() {
		parent :: PageModule();
	}

	function get($param = array()) 
	{
		$cfg 		= $this->configList();
		$show_num	= isset($param['show_num']) ? $param['show_num'] : $cfg['show_num'];
		$source 	= isset($param['source'])	? $param['source']	 : (isset($cfg['source']) ? $cfg['source']: '0');

		if (USER::isUserLogin() /* && $source*/) {
			$list = DR('xweibo/xwb.getPublicTimeline', '', $source, true, $show_num*2);
		} else {
			$list = DR('xweibo/xwb.getPublicTimeline', '', $source, false, $show_num*2);
		}
		
		if(!is_array($list['rst'])){
			return RST(array(), $list['errno'], $list['err']);
		}
		
		$list['rst'] = $this->random($list['rst'], $show_num);
		
		return RST($list['rst'], $list['errno'], $list['err']);
	}
}
