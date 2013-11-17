<?php
/**
 * 模块pipe基础类
 * @author yaoying
 * @version $Id: component_abstract.pls.php 16645 2011-05-31 08:17:38Z linyi1 $
 *
 */
class component_abstract_pls {
	
	/**
	 * component参数，使用run方法进行传入
	 * @var unknown_type
	 */
	var $mod = array();
	
	/**
	 * 在前台运行一个模块
	 * @param array $mod
	 */
	function run($mod){
		$this->mod = $mod;
	}
	
	/**
	 * 输出一个模块错误信息
	 * @param string $msg
	 * @param bool $force 强制输出？否的话受到IS_DEBUG限制
	 */
	function _error($msg = false, $force = false){
		if(true != $force && (!defined('IS_DEBUG') || !IS_DEBUG)){
			return null;
		}
		$msg = $msg ? $msg : L('pls__component__abstract__errorMsg'); 
		$title = isset($this->mod['title']) ? F('escape', (string)$this->mod['title']) : L('pls__component__abstract__emptyTitle');
		$component_id = isset($this->mod['component_id']) ? (int)$this->mod['component_id'] : -999;
		LO('pls__component__abstract__apiError', $title, $component_id, $msg);
		//echo "<div class='int-box ico-load-fail'>{$title}（模块ID：{$component_id}）遇到问题：{$msg}</div>";
	}
	
}
