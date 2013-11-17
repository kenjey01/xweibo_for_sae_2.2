<?php
/**
* 猜你喜欢　用户列表
*
* @version $1.1: guessYouLike.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/

require_once P_COMS . '/PageModule.com.php';

class guessYouLike extends PageModule{

	var $component_id = 7;

	function guessYouLike() {
		parent :: PageModule();
	}

	//getUserSuggestions
	function get($offset = 0, $limit = null) {

		$cfg = $this->configList();
		
		$num = $limit ? $limit: $cfg['show_num'];

		//$rs = DR('xweibo/xwb.getUserSuggestions', null, $offset, $num);
		$rs = DR('xweibo/xwb.getUserSuggestions', null, 0, $num);
		

		//如果得到的结果超过了num，切减
		if ($rs['errno'] == 0 && count($rs['rst']) > $num) {
			$rs['rst'] = array_slice($rs['rst'], 0, $num);
		}

		return $rs;
	}
}
