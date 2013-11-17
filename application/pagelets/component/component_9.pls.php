<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 随便看看模块
 * @author yaoying
 * @version $Id: component_9.pls.php 16828 2011-06-07 00:57:23Z jianzhou $
 *
 */
class component_9_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		//取缓存
		$cacheKey  = "component9#".md5( serialize($mod) );
		$wbListKey = "$cacheKey#wbList";
		$cacheTime = V('-:tpl/cache_time/pagelet_component9');
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content;
		    return array('cls'=>'wblist', 'list'=>CACHE::get($wbListKey) );
		}
		
		
		$ret = DR('components/pubTimeline.get', '', $mod['param']);
		if ($ret['errno']) {
			$this->_error(L('pls__component9__pubTimeline__apiError', $ret['err'], $ret['errno']));
			//$this->_error('components/pubTimeline.get 错误：'. $ret['err']. '('. $ret['errno']. ')');
			return;
		}elseif(!is_array($ret['rst'])){
			$this->_error(L('pls__component9__pubTimeline__dbError'));
			return;
		//如果数据为空，则不输出
	 	}elseif(empty($ret['rst'])){
	 		$this->_error(L('pls__component9__pubTimeline__error'));
	 		return;
	 	}
		
	 	
	 	// 设置缓存
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod, 'list'=>$ret['rst']), false);
		$wbList  = F('format_weibo', $ret['rst']);
		if (ENABLE_CACHE && $content) 
		{
			CACHE::set($cacheKey, $content, $cacheTime);
			CACHE::set($wbListKey, $wbList, $cacheTime);
		}
		
		echo $content;
		return array('cls'=>'wblist', 'list'=>$wbList );
	}
	
}
