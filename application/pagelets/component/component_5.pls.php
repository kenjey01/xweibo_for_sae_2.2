<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 微博频道模块
 * @author yaoying
 * @version $Id: component_5.pls.php 17065 2011-06-13 04:24:25Z jianzhou $
 *
 */
class component_5_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		
		//取缓存
		$cacheKey  = "component5#".md5( serialize($mod) );
		$wbListKey = "$cacheKey#wbList";
		$cacheTime = V('-:tpl/cache_time/pagelet_component5');
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
			$wbList = CACHE::get($wbListKey);
		    echo $content;
		    return array('cls'=>'wblist', 'list'=>$wbList);
		}
		
		
		$mod['param']['list_id']  	= isset($mod['param']['list_id']) && !empty($mod['param']['list_id']) ? $mod['param']['list_id'] : FALSE;
		$mod['param']['show_num']  	= isset($mod['param']['show_num']) ? (int)$mod['param']['show_num'] : 1;
		$mod['param']['page_type'] 	= isset($mod['param']['page_type']) && ($mod['param']['page_type'] != 0) ? 1 : 0;
		$mod['param']['page'] 		= (($mod['param']['page_type'] == 1) && USER::isUserLogin()) ? (int)V('g:page', 1) : 1;
		
		if(false == $mod['param']['list_id']){
			$this->_error(L('pls__component5__listIdEmptyTip'));
			return ;
		}
		
		$userList = DR('components/officialWB.getUsers', "g/{$cacheTime}", $mod['param']['list_id'],null, $mod['param']['uid']);
		//减轻API负担：几个api调用时，进行依赖性分级。若api A不正常或者为空，则B可以不运行
		if (/*$userList['errno'] == 0 && */isset($userList['rst']['users']) && is_array($userList['rst']['users']) && !empty($userList['rst']['users'])){
			$weiboList = DR('components/officialWB.get', "g/{$cacheTime}", $mod['param']['show_num'], $mod['param']['list_id'], $mod['param']['page'], $mod['param']['uid']);
		}else{
			if(isset($userList['err']) && false !== strpos(strtolower($userList['err']), 'exist')){
				$weiboList = RST(array(), -999999, L('pls__component5__list__apiError'));
			}else{
				$weiboList = RST(array(), $userList['errno'], L('pls__component5__getUsers__error', $userList['err']));
			}
		}
		
		
		// 设置缓存
		$wbList  = ($weiboList['errno']==0 && is_array($weiboList['rst'])) ? F('format_weibo',$weiboList['rst']) : array();
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod, 'weiboList'=>$weiboList, 'userList'=>$userList), false);
		if (ENABLE_CACHE && $content) 
		{
			CACHE::set($cacheKey, $content, $cacheTime);
			CACHE::set($wbListKey, $wbList, $cacheTime);
		}
		
		echo $content;
		return array('cls'=>'wblist', 'list'=>$wbList);
	}
	
}
