<?php
/**
* 热门微博排行（热门转发、热门评论）
*
* @version $1.1: hotWB.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/

require_once P_COMS . '/PageModule.com.php';

class hotWB extends PageModule{

	var $component_id = COMID_HOTWB;

	function hotWB() {
		parent :: PageModule();
		
		//如果未登录，使用管理员的token访问
		if (!USER::uid()) {
			DS('xweibo/xwb.setToken', '', 2);
		}
	}


	/*
	 * 获取指定条数的热门微博
	 *
	 */
	function getRepost($param = array()) 
	{
		$cfg 		= $this->configList();
		$source 	= isset($param['source']) 	? $param['source'] 	 : (isset($cfg['source']) ? $cfg['source'] : '0');
		$show_num	= isset($param['show_num']) ? $param['show_num'] : $cfg['show_num'];
		$show_num 	= ($show_num > 0) 			? (int)$show_num	 : 10;
		$fw = DR('xweibo/xwb.getHotRepostDaily', null, $show_num * 2, $source);
		if(!isset($fw['rst']) || !is_array($fw['rst'])){
			return RST(array(), $fw['errno'], $fw['err']);
		}
		$fw['rst'] = array_slice($fw['rst'], 0, $show_num);
		return $fw;
	}

	function getComment($param = array()) 
	{
		$cfg 		= $this->configList();
		$source 	= isset($param['source']) 	? $param['source'] 	 : (isset($cfg['source']) ? $cfg['source'] : '0');
		$show_num	= isset($param['show_num']) ? $param['show_num'] : $cfg['show_num'];
		$show_num 	= ($show_num > 0) 			? (int)$show_num	 : 10;
		$list = DR('xweibo/xwb.getHotCommentsDaily', null, $show_num * 2, $source);
		if(!isset($list['rst']) || !is_array($list['rst'])){
			return RST(array(), $list['errno'], $list['err']);
		}
		$list['rst'] = array_slice($list['rst'], 0, $show_num);
		return $list;
	}
}
