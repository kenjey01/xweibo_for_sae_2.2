<?php
include('action.abs.php');

class page_nav_mod extends action 
{

	/**
	 *\brief construct function
	 */
	function page_nav_mod() 
	{
		parent::action();
	}

	
	
	/**
	 * \brief setting pageType page
	 */
	function default_action() 
	{
		$pageType = DR('common/sysConfig.get', FALSE, PAGE_TYPE_SYSCONFIG);
		TPL::assign('pageType', $pageType['rst']);
		$this->_display('pageNav');
	}

	
	/**
	 * \brief save pageType
	 */
	function updatePageType()
	{
		// get var
		$url 	  = URL('mgr/page_nav');
		$pageType = V('p:pageType');
		$pageType = $pageType ? $pageType : PAGE_TYPE_DEFAULT;
		
		// set db and return
		$result = DR('common/sysConfig.set', FALSE, PAGE_TYPE_SYSCONFIG, $pageType);
		if ($result['rst']) {
			$this->_redirect('default_action');
		}
		$this->_error('操作失败！', $url);
	}

	
	
	/**
	 * 影响到后台页面的布局，引导用户刷新页面
	 */
	function updatePageTypeSuccTip()
	{
		echo '<!DOCTYPE><html><head>'.
		'<link href="' .W_BASE_URL. 'css/admin/admin.css" rel="stylesheet" type="text/css" /></head>
		<body><div id="wrapper"><div class="tips_box"><div class="tips_c"><div class="tips_r"><h3>操作成功</h3>
<p><a href="javascript:topRedirect();">该页面将于3秒后中转,如果你的浏览器不支持自动跳转,请点击这里</a></p></div></div></div></div>'.'<script type="text/javascript">
           				function topRedirect(){
           					var topHref = String(top.location.href);
							top.location.href = topHref.replace(/admin.php(\?)?(random=[\d.]+&)?/, "admin.php?random="+Math.random()+"&");
						}
						setTimeout(topRedirect, 2000);
           			</script>
			</body>
			</html>';  
					
		exit();
	}


	
	/**
	 * \nav setting page
	 */
	function nav()
	{
		$navList  = DR('Nav.getNavList');
		$pageList = DR('PageModule.getPagelistByType');
		TPL::assign('navList', $navList);
		TPL::assign('pageList', $pageList);
		$this->_display('pageNav_nav');
	}
	
	
	
	/**
	 * \nav update info
	 */
	function updateNav()
	{
		// get vars
		$navList = V('p:data');
		$url  	 = URL('mgr/page_nav.nav');
		
		// update and return
		$db = APP::ADP('db');
		foreach ($navList as $id => $aNav)
		{
			// not set the data if the name is null
			$aNav['name'] = trim($aNav['name']);
			if (empty($aNav['name'])) {
				continue;
			}
			
			// fixed the link for outside url
			if (isset($aNav['url']))
			{
				$aNav['url'] = F('fix_url', $aNav['url'], 'http://', 'http://');
			}
			
			if (empty($aNav['page_id']))
			{
				$aNav['url'] = '';
			}
			
			$aNav['in_use'] 	= isset($aNav['in_use']) ? 1 : 0;
			//$aNav['is_blank'] 	= isset($aNav['is_blank']) ? 1 : 0;
			$db->boolSave($aNav, $id, T_NAV);
		}
		
		$this->_succ('操作已成功', $url);
	}
	
	
	
	/**
	 * Delete The Nav Record
	 */
	function delNav()
	{
		$navId = (int)V('g:id');
		$db 	= APP::ADP('db');
		$url	= URL('mgr/page_nav.nav');
		
		if ( $navId && $aNav=$db->get($navId,T_NAV) ) 
		{
			if ($aNav['isNative']){
				$this->_error('温馨提示：不能删除系统预设组件', $url);
			}
			
			if ( $db->delete($navId,T_NAV) ) {
				$sql = 'DELETE FROM ' .	$db->getTable(T_NAV) . ' WHERE parent_id=' . $navId;
				$rs = $db->execute($sql);
				if ($rs !== false) {
					$this->_succ('操作已成功', $url);
				}
			}
		} 
		
		$this->_error('操作失败，请检查输入参数是否正确', $url);
	}
	
	
	
	/**
	 * Create A Nav
	 */
	function doCreateNav()
	{
		$data = V('p:data');
		$url  = URL('mgr/page_nav.nav');
		
		// organize data
		$db 		  		= APP::ADP('db');
		$data['in_use'] = isset($data['in_use'])?'1':'0';
		$data['isNative'] 	= 0;
		$data['sort_num'] 	= 0;
		//$data['in_use'] 	= 0;
		//$data['is_blank'] 	= 0;
		$data['type'] 		= PAGE_TYPE_CURRENT;
		// url过滤
		if ( isset($data['url']) && $data['url'])
		{
			$data['url'] = F('fix_url', $data['url'], 'http://', 'http://'); 
		}
		
		
		if ( $db->save($data,'',T_NAV) )
		{
			// insert page's component
			$this->_succ('操作已成功', $url);
		}
		
		$this->_error('操作失败, 请检查一下参数', $url);
	}
}
