<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 微博发布框模块
 * @author yaoying
 * @version $Id: component_16.pls.php 10904 2011-03-01 02:46:42Z zhenquan $
 *
 */
class component_16_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		
		TPL::module('input');
		return array('cls'=>'input');
	}
	
}
