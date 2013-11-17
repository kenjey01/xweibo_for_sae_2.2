<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 热门话题列表模块
 * @author yaoying
 * @version $Id: component_6.pls.php 16917 2011-06-08 07:39:22Z jianzhou $
 *
 */
class component_6_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		//取缓存
		$cacheKey  = "component6#".md5( serialize($mod) );
		$cacheTime = V('-:tpl/cache_time/pagelet_component6');
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content; return;
		}
		
		
		$ret = DR('components/hotTopic.get', FALSE, $mod['param']);
		if($ret['errno'] != 0){
			//$this->_error('components/hotTopic.get 返回API失败：'. $ret['err']. '('. $ret['errno']. ')');
			return ;
		}elseif(!is_array($ret['rst'])){
			$this->_error(L('pls__component6__hotTopic__error'));
			return;
	 	}elseif(empty($ret['rst'])){
			//$this->_error('components/hotTopic.get 无数据。');
			return;
	 	}
	 	
	 	
	 	// 设置缓存
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod, 'rs'=>$ret['rst']), false);
		if (ENABLE_CACHE && $content) {
			CACHE::set($cacheKey, $content, $cacheTime);
		}
		
		echo $content; return;
	}
	
}
