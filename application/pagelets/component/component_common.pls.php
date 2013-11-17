<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 各类模块通用pipe
 * @author yaoying
 * @version $Id: component_common.pls.php 17070 2011-06-13 05:54:29Z jianzhou $
 *
 */
class component_common_pls extends component_abstract_pls
{
	
	/**
	 * 获取热门微博
	 */
	function hotWB_getComment($mod)
	{
		//目前没有基于APPKEY的热门微博信息，故强制设置为0
		$mod['param']['source'] = 0;
		parent::run($mod);
		
		//取缓存
		$isLogin   = USER::isUserLogin();
		$cacheKey  = "hotWB_getComment#$isLogin#".md5( serialize($mod) );
		$wbListKey = "$cacheKey#wbList";
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content; 
		    return array('cls'=>'wblist', 'list'=>CACHE::get($wbListKey));
		}
		
		
		$comments = DR('components/hotWB.getComment', '', $mod['param']);
		if ( $comments['errno']==0 && !empty($comments['rst'])) 
		{
			// 设置缓存
			$header    = isset($mod['header']) ? $mod['header'] : null;
			$content   = TPL::module('feedlist', array('list'=>$this->_getWbCounts($comments['rst']), 'header'=>$header), FALSE);
			$wbList    = F('format_weibo', $comments['rst']);
			$cacheTime = V('-:tpl/cache_time/pagelet_component1');
			
			if (ENABLE_CACHE && $content) 
			{
				CACHE::set($cacheKey, $content, $cacheTime);
				CACHE::set($wbListKey, $wbList, $cacheTime);
			}
			
			echo $content;
			return array('cls'=>'wblist', 'list'=>$wbList);
		}
		elseif($comments['errno'] == 0) 
		{
			$this->_show(L('pls__component__common__hotWB_emptyTip'));
			return ;
		}
		else
		{
			if(defined('IS_DEBUG') && IS_DEBUG){
				$this->_error(L('pls__component__common__hotWB_apiError', $comments['err'], $comments['errno']));
				//$this->_error('components/hotWB.getComment 返回API错误：'. $comments['err']. '('. $comments['errno']. ')');
			}else{
				$this->_show(L('pls__component__common__hotWB_dbError'));
			}
			return ;
		}
	}
	
	
	/**
	 * 获取热门转发
	 */
	function hotWB_getRepost($mod)
	{
		//目前没有基于APPKEY的热门微博信息，故强制设置为0
		$mod['param']['source'] = 0;
		parent::run($mod);
		
		//取缓存
		$isLogin   = USER::isUserLogin();
		$cacheKey  = "hotWB_getRepost#$isLogin#".md5( serialize($mod) );
		$wbListKey = "$cacheKey#wbList";
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content; 
		    return array('cls'=>'wblist', 'list'=>CACHE::get($wbListKey));
		}
		
		
		$repost = DR('components/hotWB.getRepost', '', $mod['param']);
		if ($repost['errno'] == 0 && !empty($repost['rst'])) 
		{
			$header 	= isset($mod['header']) ? $mod['header'] : null;
			$content	= TPL::module('feedlist', array('list' =>$this->_getWbCounts($repost['rst']), 'header' => $header), FALSE);
			$wbList     = F('format_weibo', $repost['rst']);
			$cacheTime  = V('-:tpl/cache_time/pagelet_component1');
			
			if (ENABLE_CACHE && $content) 
			{
				CACHE::set($cacheKey, $content, $cacheTime);
				CACHE::set($wbListKey, $wbList, $cacheTime);
			}
			
			echo $content;
			return array('cls'=>'wblist', 'list'=>$wbList);
		}
		elseif($repost['errno'] == 0) 
		{
			$this->_show(L('pls__component__common__hotWB_emptyTip'));
			return ;
		}
		else
		{
			if(defined('IS_DEBUG') && IS_DEBUG){
				$this->_error(L('pls__component__common__hotWB_apiError', $repost['err'], $repost['errno']));
			}else{
				$this->_show(L('pls__component__common__hotWB_dbError'));
			}
			return ;
		}
	}
	
	function _show($msg){
		echo '<div class="int-box ico-load-fail">'. $msg. '</a></div>';
	}
	
	
	function _getWbCounts($wbList)
	{
		// 构建数据
		if ( is_array($wbList) && !USER::isUserLogin() )
		{
			$ids  = array();
			$list = array();
			foreach ($wbList as $aWb)
			{
				$id		 	= $aWb['id'];
				$ids[]	 	= $id;
				$list[$id]	= $aWb;
			}
		
			// 获取counts
			$idStr = implode(',', $ids);
			if ( $idStr )
			{
				DS('xweibo/xwb.setToken', '', 2);
				$batch_counts = DR('xweibo/xwb.getCounts', '', $ids);
				if ( isset($batch_counts['rst']) && is_array($batch_counts['rst']) )
				{
					foreach ($batch_counts['rst'] as $key => $var) 
					{
						$id							= (string)$var['id'];
						$list[$id]['commentCnt'] 	= $var['comments'];
						$list[$id]['repostCnt'] 	= $var['rt'];
					}
				}
				
				return array_values($list);
			}
		}
		
		return $wbList;
	}
}
