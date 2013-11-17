<?php
/**************************************************
*  Created:  2010-06-08
*
*  文件说明
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class pager
{
	//分页参数
	var $pageParam = array();
	//分页格式
	var $formatStr;

	var $varExtends = array();// 添加额外的url变量

	//构造函数
	function pager($pageParam=null)
	{
		$this->formatStr = L('pageClass__title__pageStyle');
		if($pageParam)
			$this->setParam($pageParam);
		if(!isset($pageParam['linkNumber']))
			$this->pageParam['linkNumber'] = 10;
	}

	/**
	 * 添加除$_GET外的内容
	 * @param $data array key/value对应的get
	 */
	function setVarExtends($index, $value = null) {
		if (!is_array($index) && $value === null) {
			return false;
		} elseif (!is_array($index)) {
			$index = array($index => $value);
		}

		$this->varExtends = $index;
	}

	/*
	 * 设置分页形式
	 *
	 * @param string | array 为string时$value为值，为array时$value为null
	 * @param mixed $value $key为string时有效
	 *				currentPage 当前页
	 *				pageSize	每页记录数
	 *				recordCount 总记录数
	 *				linkNumber	显示1 2 3 4..这种形式时，显示的个数
	 */
	function setParam($key, $value=null){
		if(is_array($key)) {
			$this->pageParam = array_merge($this->pageParam, $key);
		}
		else {
			$this->pageParam[$key] = $value;
		}
	}

	/// 取得一个分页参数
	function getParam($key) {
		return $this->pageParam[$key];
	}

	/**
	 * 设置格式
	 *
	 * example "Pages: [current]/[total] 总记录数 [recordCount] [prev]上一页[/prev] [prevnav]前10页[/prevnav] [nav]  [nextnav]后10页[/nextnav] [next]下一页[/next]";
	 * @param $formatStr string
	 *
	 */
	function setFormat($formatStr) {
		$this->formatStr = $formatStr;
	}

	//取得分页格式
	function getFormat() {
		return $this->formatStr;
	}

	function _creRouteUrl($page, $vars=array(), $vName='page', $mRoute=''){
		$vGet = V('g');
		if (isset($vGet[$vName])) {unset($vGet[$vName]);}
		if (empty($mRoute)) { $mRoute = APP::getRequestRoute();}
		if (!empty($vars) && is_array($vars) ) {$vGet = array_merge($vGet,$vars);}
		if (!empty($this->varExtends) && is_array($this->varExtends) ) {$vGet = array_merge($vGet,$this->varExtends);}
		$vGet[$vName] = $page;
		return URL($mRoute, $vGet);
	}

	/**
	 * 生成分页导航条
	 */
	function makePage($vName='page'){
		$currentPage= $this->getParam('currentPage');
		$recordCount= $this->getParam('recordCount');
		$pageCount	= max(1, ceil($recordCount / $this->getParam('pageSize')));
		$linkNumber = $this->getParam('linkNumber');

		//根据当前URL生成新的URL链接
		/*
		if(empty($_SERVER['QUERY_STRING'])){
			$url = $_SERVER['REQUEST_URI'] . "?page=";
		}
		else{
			if(isset($_GET['page'])){
				$url = preg_replace("|page.+|", "page=", $_SERVER['REQUEST_URI']);
			}
			else {
				$url = $_SERVER['REQUEST_URI'] . "&page=";
			}
		}
		*/

		$page = array();
		//生成导航条
		$start = max(1,$currentPage -  $linkNumber / 2);
		$to    = $start + $linkNumber;
		for( $i=$start; $i<$to; $i++ ){
			if( $i > $pageCount ) break;
			if( $i == $currentPage )
				$page[] = "<span class='current'>".$currentPage."</span>";
			else
				$page[] = sprintf('<a href="%s">%d</a>', $this->_creRouteUrl($i), $i );
		}

		$linktpl = '<a href="%s">\\1</a>';
		//$deflink = '<a href="#">\\1</a>';
		$deflink = '<span>\\1</span>';
		$prev = $next = $prevnav = $nextnav = $deflink;
		$first = sprintf($linktpl, $this->_creRouteUrl(1) );
		$last  = sprintf($linktpl, $this->_creRouteUrl($pageCount) );
		//非第一页，生成上一页按钮
		if( $currentPage > 1 )
			$prev = sprintf($linktpl, $this->_creRouteUrl($currentPage-1) );
		//非最后一页，生成下一页按钮
		if( $currentPage < $pageCount )
			$next = sprintf('<a href="%s">\\1</a>', $this->_creRouteUrl($currentPage+1) );
		//非第一页导航
		if( $start > $linkNumber )
			$prevnav = sprintf('<a href="%s">\\1</a>', $this->_creRouteUrl($start-$linkNumber) );
		//非最后一页导航
		if( $start + $linkNumber < $pageCount )
			$nextnav = sprintf('<a href="%s">\\1</a>', $this->_creRouteUrl($start+$linkNumber) );
		$reg = array( "[current]", "[total]", "[recordCount]", "[nav]" );
		$rpt = array( $currentPage, $pageCount, $recordCount, join( " ", $page ) );

		$preFormat = str_replace($reg, $rpt, $this->getFormat());

		$reg = array( "#\[prev\](.+)\[\/prev\]#isU",
					  "#\[next\](.+)\[\/next\]#isU",
					  "#\[first\](.+)\[\/first\]#isU",
					  "#\[last\](.+)\[\/last\]#isU",
					  "#\[prevnav\](.+)\[\/prevnav\]#isU", "#\[nextnav\](.+)\[\/nextnav\]#isU",
					);

		$rpt = array( $prev, $next, $first, $last, $prevnav, $nextnav );
		return preg_replace( $reg, $rpt, $preFormat );
	}

	/**
	 * 生成分页导航条
	 */
	function makePageForKeyWord($vName='page', $vars=array()){
		$currentPage= $this->getParam('currentPage');
		$recordCount= $this->getParam('recordCount');
		$pageCount	= max(1, ceil($recordCount / $this->getParam('pageSize')));
		$linkNumber = $this->getParam('linkNumber');

		//根据当前URL生成新的URL链接
		/*
		if(empty($_SERVER['QUERY_STRING'])){
			$url = $_SERVER['REQUEST_URI'] . "?page=";
		}
		else{
			if(isset($_GET['page'])){
				$url = preg_replace("|page.+|", "page=", $_SERVER['REQUEST_URI']);
			}
			else {
				$url = $_SERVER['REQUEST_URI'] . "&page=";
			}
		}
		*/

		$page = array();
		//生成导航条
		$start = max(1,$currentPage -  $linkNumber / 2);
		$to    = $start + $linkNumber;
		for( $i=$start; $i<$to; $i++ ){
			if( $i > $pageCount ) break;
			if( $i == $currentPage )
				$page[] = "<span class='current'>".$currentPage."</span>";
			else
				$page[] = sprintf('<a href="%s">%d</a>', $this->_creRouteUrl($i,$vars), $i );
		}

		$linktpl = '<a href="%s">\\1</a>';
		//$deflink = '<a href="#">\\1</a>';
		$deflink = '<span>\\1</span>';
		$prev = $next = $prevnav = $nextnav = $deflink;
		$first = sprintf($linktpl, $this->_creRouteUrl(1,$vars) );
		$last  = sprintf($linktpl, $this->_creRouteUrl($pageCount,$vars) );
		//非第一页，生成上一页按钮
		if( $currentPage > 1 )
			$prev = sprintf($linktpl, $this->_creRouteUrl($currentPage-1,$vars) );
		//非最后一页，生成下一页按钮
		if( $currentPage < $pageCount )
			$next = sprintf('<a href="%s">\\1</a>', $this->_creRouteUrl($currentPage+1,$vars) );
		//非第一页导航
		if( $start > $linkNumber )
			$prevnav = sprintf('<a href="%s">\\1</a>', $this->_creRouteUrl($start-$linkNumber,$vars) );
		//非最后一页导航
		if( $start + $linkNumber < $pageCount )
			$nextnav = sprintf('<a href="%s">\\1</a>', $this->_creRouteUrl($start+$linkNumber,$vars) );
		$reg = array( "[current]", "[total]", "[recordCount]", "[nav]" );
		$rpt = array( $currentPage, $pageCount, $recordCount, join( " ", $page ) );

		$preFormat = str_replace($reg, $rpt, $this->getFormat());

		$reg = array( "#\[prev\](.+)\[\/prev\]#isU",
					  "#\[next\](.+)\[\/next\]#isU",
					  "#\[first\](.+)\[\/first\]#isU",
					  "#\[last\](.+)\[\/last\]#isU",
					  "#\[prevnav\](.+)\[\/prevnav\]#isU", "#\[nextnav\](.+)\[\/nextnav\]#isU",
					);

		$rpt = array( $prev, $next, $first, $last, $prevnav, $nextnav );
		return preg_replace( $reg, $rpt, $preFormat );
	}

	/**
	 * 生成分页
	 *
	 * @param array $var
	 * @param string $pname
	 * @param string $preText
	 * @param string $nextText
	 *
	 * @return string
	 */
	function nav($var=array(),$pname='page', $preText=false, $nextText=false){
		$preText = $preText ? $preText : L('pageClass__title__prePage');
		$nextText = $nextText ? $nextText : L('pageClass__title__nextPage');
		//根据当前URL生成新的URL链接
		$curPage = isset($_GET[$pname]) ? $_GET[$pname]*1 : 1;
		$curPage = max(1,$curPage);
		$vGet = V('g',array());
		if (is_array($vGet) && isset($vGet[$pname])){
			unset($vGet[$pname]);
		}

		if (is_array($var)) {
			$vGet = array_merge($vGet,$var);
		}
		$q_str = '';
		foreach($vGet as $k=>$v){
			$q_str .= "&".$k."=".urlencode($v);
		}
		$q_str = empty($q_str) ? $pname."=" : ltrim($q_str, "&")."&".$pname."=";

		$url = V('s:REQUEST_URI')."?";
		if(strpos($url,"?")!==false){
			$url = substr($url, 0, strpos($url, "?")+1);
		}
		$url.= $q_str;

		$navHtml = '';
		if ($curPage>1) {
			$navHtml = sprintf('<a href="%s" class="btn-s1"><span>'.$preText.'</span></a>', $url.($curPage-1) );
		}
		$navHtml .= sprintf('  <a href="%s" class="btn-s1"><span>'.$nextText.'</span></a>', $url.($curPage+1) );
		return $navHtml;
	}


	/**
	 * 生成分页
	 *
	 * @param array $var
	 * @param int $recordCount
	 * @param int $limit
	 * @param string $preField
	 * @param string $nextField
	 * @param string $pname
	 * @param string $preText
	 * @param string $nextText
	 *
	 * @return string
	 */
	function pagehtml($var=array(), $recordCount, $limit = WB_API_LIMIT, $preField = 'start_pos', $nextField = 'end_pos', $pname = 'page', $preText=false, $nextText=false)
	{
		$preText = $preText ? $preText : L('pageClass__title__prePage');
		$nextText = $nextText ? $nextText : L('pageClass__title__nextPage');
		$curPage = isset($_GET[$pname]) ? $_GET[$pname]*1 : 1;
		$curPage = max(1,$curPage);
		$vGet = V('g',array());
		if (is_array($vGet) && isset($vGet[$pname])){
			unset($vGet[$pname]);
		}

		if (is_array($var)) {
			$vGet = array_merge($vGet,$var);
		}
		$q_str = '';
		$return_index = false;
		foreach($vGet as $k=>$v){
			if ($k == 'p' && $v == 'end') {
				continue;
			}
			if ($k == 'return_index') {
				$return_index = true;
				continue;
			}
			if ($k == $preField) {
				$preValue = $v;
				continue;
			}
			if ($k == $nextField) {
				$nextValue = $v;
				continue;
			}
			$q_str .= "&".$k."=".urlencode($v);
		}
		$q_str = empty($q_str) ? $pname."=" : ltrim($q_str, "&")."&".$pname."=";
//		if(strpos($url,"?")!==false){
//			$url = substr($url, 0, strpos($url, "?")+1);
//		}
//		$url.= $q_str;
		$navHtml = '';
		if ($return_index) {
			if ($curPage >= 3) {
					$navHtml = sprintf('<a href="'.URL('index').'" class="btn-s1"><span>'.L('pageClass__title__indexPage').'</span></a>');
			}
		}
		if ($curPage > 1) {
			if ($preValue) {
				$navHtml .= sprintf('<a href="%s" class="btn-s1"><span>'.$preText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage-1).'&'.$preField.'='.$preValue));
			} else {
				$navHtml .= sprintf('<a href="%s" class="btn-s1"><span>'.$preText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage-1)));
			}
		}
		if ($recordCount > $limit) {
			if ($nextValue) {
				$navHtml .= sprintf('  <a href="%s" class="btn-s1"><span>'.$nextText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage+1).'&'.$nextField.'='.$nextValue));
			} else {
				$navHtml .= sprintf('  <a href="%s" class="btn-s1"><span>'.$nextText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage+1)));
			}
		}
		return $navHtml;
	}

	/**
	 * 生成分页
	 *
	 * @param array $list
	 * @param int $limit
	 * @param int $item_count
	 * @param string $preField
	 * @param string $nextField
	 * @param string $pname
	 * @param string $preText
	 * @param string $nextText
	 *
	 * @return string
	 */
	function getPageList($list, $limit = WB_API_LIMITl, $preField = 'start_pos', $nextField = 'end_pos', $pname = 'page', $preText=false, $nextText=false)
	{
		$preText = $preText ? $preText : L('pageClass__title__prePage');
		$nextText = $nextText ? $nextText : L('pageClass__title__nextPage');
		$var = array();
		$route = APP::getRequestRoute();
		$recordCount = count($list);
		/// 当前页码数
		$curPage = isset($_GET[$pname]) ? $_GET[$pname]*1 : 1;
		$curPage = max(1,$curPage);
		switch($route) {
			case 'index':
				$var = array('return_index' => true);
				break;
			case 'index.fans':
			case 'index.follow':
			case 'ta.fans':
			case 'ta.follow':
				$recordCount = count($list['users']);
				if (isset($list['previous_cursor'])) {
					$start_pos = $list['previous_cursor'] - $limit == 0 ? null : $list['previous_cursor'] - $limit;
				}

				$end_pos = isset($list['next_cursor']) ? $list['next_cursor'] : 0;

				$pageCount = ceil($list['x_total']/$limit);
				if ($pageCount == $curPage || $pageCount < $curPage) {
					$recordCount = 0;
				}
				$var = array('start_pos' => $start_pos, 'end_pos' => $end_pos);
				break;
			case 'index.favorites':
				//收藏接口固定显示20条记录
				$limit = 20;
				break;
		}

		$vGet = V('g',array());
		if (is_array($vGet) && isset($vGet[$pname])){
			unset($vGet[$pname]);
		}

		if (is_array($var)) {
			$vGet = array_merge($vGet,$var);
		}
		if (!empty($this->varExtends) && is_array($this->varExtends) ) {$vGet = array_merge($vGet,$this->varExtends);}
		$q_str = '';
		$return_index = false;
		foreach($vGet as $k=>$v){
			if ($k == 'p' && $v == 'end') {
				continue;
			}
			if ($k == 'm') {
				continue;
			}
			if ($k == 'return_index') {
				$return_index = true;
				continue;
			}
			if ($k == $preField) {
				$preValue = $v;
				continue;
			}
			if ($k == $nextField) {
				$nextValue = $v;
				continue;
			}
			$q_str .= "&".$k."=".urlencode($v);
		}
		$q_str = empty($q_str) ? $pname."=" : ltrim($q_str, "&")."&".$pname."=";
		$navHtml = '';
		if ($return_index) {
			if ($curPage >= 3) {
					$navHtml = sprintf('<a href="'.URL(APP::getRequestRoute(), $q_str).'1" class="btn-s1"><span>'.L('pageClass__title__indexPage').'</span></a>');
			}
		}
		if ($curPage > 1) {
			if (isset($preValue)) {
				$navHtml .= sprintf('<a href="%s" class="btn-s1"><span>'.$preText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage-1).'&'.$preField.'='.$preValue));
			} else {
				$navHtml .= sprintf('<a href="%s" class="btn-s1"><span>'.$preText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage-1)));
			}
		}
		if ($recordCount >= ceil($limit/2)) {
			if (isset($nextValue)) {
				$navHtml .= sprintf('  <a href="%s" class="btn-s1"><span>'.$nextText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage+1).'&'.$nextField.'='.$nextValue));
			} else {
				$navHtml .= sprintf('  <a href="%s" class="btn-s1"><span>'.$nextText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage+1)));
			}
		}
		return RST($navHtml);
	}

	/**
	 * 生成分页
	 *
	 *
	 */
	function getPageHtml($list, $pageSize, $recordCount, $pname = 'page', $preText=false, $nextText=false) {
		$preText = $preText ? $preText : L('pageClass__title__prePage');
		$nextText = $nextText ? $nextText : L('pageClass__title__nextPage');
		/// 当前页码数
		$curPage = isset($_GET[$pname]) ? $_GET[$pname]*1 : 1;
		$curPage = max(1,$curPage);

		/// 当前记录数
		$curCount = count($list);
		$pageCount	= max(1, ceil($recordCount / $pageSize));

		$vGet = V('g',array());
		if (is_array($vGet) && isset($vGet[$pname])){
			unset($vGet[$pname]);
		}

		$q_str = '';
		foreach($vGet as $k=>$v){
			if ($k == 'm') {
				continue;
			}
			
			// 处理数组情况
			if ( is_array($v) )
			{
				$vTmp = '';
				foreach ($v as $keyTmp=>$valueTmp)
				{
					$vTmp[] = $k.'['.$keyTmp.']='.$valueTmp;
				}
				$v = implode('&', $vTmp);
			}
			$q_str .= "&".$k."=".urlencode($v);
		}
		$q_str = empty($q_str) ? $pname."=" : ltrim($q_str, "&")."&".$pname."=";


		$navHtml = '';
		if ($curPage > 1) {
			$navHtml .= sprintf('<a href="%s" class="general-btn"><span>'.$preText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage-1)));
		}
		if ($pageCount > $curPage) {
			$navHtml .= sprintf('  <a href="%s" class="general-btn"><span>'.$nextText.'</span></a>', URL(APP::getRequestRoute(), $q_str.($curPage+1)));
		}

		return RST($navHtml);
	}
}
