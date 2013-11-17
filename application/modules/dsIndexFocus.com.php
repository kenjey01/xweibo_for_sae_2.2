<?php
/**
* 首页聚焦位数据读取对象
*
* @version $1.1: IndexFocus.com.php,v 1.0 2010/11/6 23:50 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
class dsIndexFocus {
	var $focus;

	function dsIndexFocus() {
		$this->focus = APP::N('indexFocus');
	}

	function get() {
		$focus = &$this->focus;

		return RST($focus->get());
	}

}