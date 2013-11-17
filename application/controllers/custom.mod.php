<?php
/**************************************************
*  Created:  2010-06-08
*
*  微博广场
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/
class custom_mod
{
	function default_action() 
	{
		$uid = USER::uid();
		if (!$uid) {
			DR('xweibo/xwb.setToken', '', 2);
		}

		$pageId	 = V('r:page_id', 0);
		$modules = DS('PageModule.getPageModules', /*'g1/300'*/'', $pageId, TRUE);
		
		TPL :: assign('main_modules', isset($modules[1]) ? $modules[1]: array());
		TPL :: assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		APP :: setData('page', 'custom', 'WBDATA');
		TPL :: display('custom');
	}

}
