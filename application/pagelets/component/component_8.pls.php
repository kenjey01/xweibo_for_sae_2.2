<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 同城微博模块
 * @author yaoying
 * @version $Id: component_8.pls.php 17065 2011-06-13 04:24:25Z jianzhou $
 *
 */
class component_8_pls extends component_abstract_pls
{
	
	var $_assignData = array();
	
	function run($mod)
	{
		parent::run($mod);
		$this->_initAssignData();
		$this->_assignData['mod'] = $mod;
		
		
		//取缓存
		$isLogin   = USER::isUserLogin();
		$cacheKey  = $isLogin ? FALSE : "component8#".md5( serialize($mod).serialize(V('g')) );
		$wbListKey = "$cacheKey#wbList";
		if(ENABLE_CACHE && $cacheKey && ($content=CACHE::get($cacheKey)) ) 
		{
			$wbList = CACHE::get($wbListKey);
		    echo $content;
		    return array('cls'=>'wblist', 'list'=>$wbList, 'currRoute'=>APP::getRequestRoute(), 'page_id'=>$this->_assignData['page_id']);
		}

		
		if(!$this->_assignCityData()){
			return ;
		}
		
		$this->_assignWeiboList();
		
		
		// 设置缓存
		$wbList  = F('format_weibo', $this->_assignData['weiboList']);
		$content = TPL::module('component/component_'.$mod['component_id'], $this->_assignData, false);
		if (ENABLE_CACHE && $cacheKey && $content) 
		{
			$cacheTime = V('-:tpl/cache_time/pagelet_component8');
			CACHE::set($cacheKey, $content, $cacheTime);
			CACHE::set($wbListKey, $wbList, $cacheTime);
		}
		
		echo $content;
		return array('cls'=>'wblist', 'list'=>$wbList, 'currRoute'=>APP::getRequestRoute(), 'page_id'=>$this->_assignData['page_id']);
	}
	
	
	function _initAssignData()
	{
		$this->_assignData['province_id'] 	= (int)V('g:province', '');
		$this->_assignData['city_id'] 		= (int)V('g:city', '');
		$this->_assignData['page_type'] 	= isset($this->mod['param']['page_type']) && ($this->mod['param']['page_type'] != 0) ? 1 : 0;
		$this->_assignData['page'] 			= ($this->_assignData['page_type'] == 1) ? (int)V('g:page', 1) : 1;
		$this->_assignData['source']	  	= isset($this->mod['param']['source']) ? $this->mod['param']['source'] : 0;
		$this->_assignData['show_num'] 		= isset($this->mod['param']['show_num']) 	? (int)$this->mod['param']['show_num'] : 0;
		$this->_assignData['province'] 		= ''; 
		$this->_assignData['city'] 			= '';
		$this->_assignData['citys'] 		= $this->_assignData['provinces'] = array();
		
		$requestRoute = APP::getRequestRoute(true);
		$this->_assignData['route'] 		= isset($requestRoute['class']) ? $requestRoute['class'] : 'pub';
		$this->_assignData['page_id'] 		= (int)V('g:page_id', 0);;
	}
	
	function _assignCityData(){
		$clientIp = F('get_client_ip');
		//$clientIp = '121.14.1.158';
		
		$ret = DR('xweibo/xwb.getProvinces', '86400');
		if ($ret['errno']) {
			$this->_error(L('pls__component8__getProvinces__apiError', $ret['err'], $ret['errno']));
			//$this->_error('xweibo/xwb.getProvinces 返回API错误：'. $ret['err']. '('. $ret['errno']. ')');
			return false;
		}
		
		$result = &$ret['rst'];
		if ($result && isset($result['provinces']) && !empty($result['provinces'])) 
		{
			$this->_assignData['provinces'] = &$result['provinces'];
			if (!($this->_assignData['province_id'] || $this->_assignData['city_id'])) 
			{		
				$cityInfo = F('http_get_contents',"http://int.dpool.sina.com.cn/iplookup/iplookup.php?ip={$clientIp}&charset=utf-8&format=json");
				$info 	  = @json_decode($cityInfo, true);
			
				if (empty($info['province']) || empty($info['city'])) 
				{	//default
					$info['province'] = '北京';
					$info['city'] 	  = '东城区';
				}
			
//				if ($info && ($info['ret'] != -1)) {
					foreach ($this->_assignData['provinces'] as $p) 
					{
						if ($p['name'] == $info['province']) 
						{
							$this->_assignData['province_id'] = $p['id'];
							$this->_assignData['province'] = $p['name'];
						
							$this->_assignData['citys'] = &$p['citys'];
							foreach ($this->_assignData['citys'] as $ct) 
							{
								if (current($ct) == $info['city']) 
								{
									$this->_assignData['city'] = $info['city'];
									$this->_assignData['city_id'] = key($ct);
									break;
								}
							}
							break;
						}
					}
//				}

			} else {
				foreach ($this->_assignData['provinces'] as $p) 
				{
					if ($p['id'] == $this->_assignData['province_id']) 
					{
						$this->_assignData['citys'] = &$p['citys'];
						$this->_assignData['province'] = $p['name'];
						foreach ($this->_assignData['citys'] as $ct) {
							if ($this->_assignData['city_id'] == key($ct)) {
								$this->_assignData['city'] = current($ct);	
							}
						}
						break;
					}
				}
			}
		}
		
		return true;
		
	}
	
	
	function _assignWeiboList(){
		$show_num = isset($this->mod['param']['show_num']) 	? $this->mod['param']['show_num'] : FALSE;
		$source	  = isset($this->mod['param']['source']) ? $this->mod['param']['source'] : FALSE;
		$page = $this->_assignData['page'];
		if(USER::isUserLogin()){
			$cachetype = null;
		}else{
			$cachetype = 'g1/60';
			$page = 1;
		}
		$ret = DR('components/cityWB.get', $cachetype, $this->_assignData['province_id'], $this->_assignData['city_id'], $show_num, $page, $source);
		if($ret['errno'] == 0 && is_array($ret['rst'])){
			$this->_assignData['weiboList'] = $ret['rst'];
			return true;
		}else{
			$this->_assignData['weiboList'] = array();
			$this->_assignData['weiboErrMsg'] = L('pls__component8__cityWB__apiError', $ret['err'], $ret['errno']); 
			//$this->_assignData['weiboErrMsg'] = 'components/cityWB.get 返回API错误：'. $ret['err']. '('. $ret['errno']. ')';
			//$this->_error('components/cityWB.get 返回API错误：'. $ret['err']. '('. $ret['errno']. ')');
			return false;
		}
	}
	
}
