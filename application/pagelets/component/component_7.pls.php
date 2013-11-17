<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 可能感兴趣的人
 * @author yaoying
 * @version $Id: component_7.pls.php 16827 2011-06-06 23:59:41Z jianzhou $
 *
 */
class component_7_pls extends component_abstract_pls{
	
	function run($mod)
	{
		parent::run($mod);
		
		//未登录，不使用
		$uid = User::uid();
		if (!$uid){
			return;
		}
		
		
		$cacheTime = 'g/'.V('-:tpl/cache_time/pagelet_component7');
		$show_num = isset($mod['param']['show_num']) ? $mod['param']['show_num'] : FALSE;
		$ret 	  = DR('components/guessYouLike.get', $cacheTime, 0, $show_num);
		
		if ($ret['errno']) {
			$this->_error(L('pls__component7__guessYouLike__apiError', $ret['err'], $ret['errno']));
			//$this->_error('components/guessYouLike.get 返回API错误：'. $ret['err']. '('. $ret['errno']. ')');
			return;
		}elseif(empty($ret['rst'])){
			$this->_error(L('pls__component7__guessYouLike__dbError'));
			return;
		}elseif(!is_array($ret['rst'])){
			$this->_error(L('pls__component7__guessYouLike__Error'));
			return;
		}
		
		$followedList = $this->_generateFollowedList($ret['rst']);
		
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod, 'rs' => $ret['rst'], 'followedList' => $followedList));
	}
	
	/**
	 * 生成本组件内的用户rst数组资源内已经关注的用户数组，类型为：
	 * <pre>
	 * array((string)已关注用户id1 => 1, (string)已关注用户id2 => 1, ......);
	 * </pre>
	 * 模板内可通过以下方法判断用户是否已经关注了某用户：
	 * <pre>
	 * isset($followedList[(string)$user['id']]);
	 * array_key_exists((string)$user['id'], $followedList);
	 * </pre>
	 * @param array $rst 本组件内生成的用户rst数组资源
	 * @return array
	 */
	function _generateFollowedList($rst){
		//由于本组件已经确定未登录不使用，故在本子方法删除登录状态判断。
		$flw = $followedList = array();
		$flRet = DR ( 'xweibo/xwb.getFriendIds', 'p1', User::uid(), null, null, null, 2000 );
		$flw = ($flRet ['errno'] == 0) ? (array)$flRet['rst'] : array();
		
		if(empty($flw)){
			return $followedList;
		}
		
		foreach($rst as $tp){
			if(in_array($tp['user']['id'], $flw['ids'])){
				$followedList[(string)$tp['user']['id']] = 1;
			}
		}
		
		return $followedList;
		
	}
	
}
