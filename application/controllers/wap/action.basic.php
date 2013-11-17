<?php
/**************************************************
*  Created:  2011-03-07
*
*  WAP控制器基类
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author guanghui <guanghui1@staff.sina.com.cn>
*
***************************************************/
class action
{
    function action()
    {
        if(APP::F('is_robot')) {
            APP::deny();
        }
    }
    
    function _display($tpl)
    {
        echo '<?xml version="1.0" encoding="utf-8"?>';
        TPL :: display('wap/' . $tpl, '', 0, false);
    }
    
    function _showErr($msg, $url='')
    {
		if($url==''){
			$url=WAP_URL('pub');
		}
		header("refresh:3;url=".$url);
		TPL::assign('msg', $msg);
		TPL::assign('backURL', htmlspecialchars($url, ENT_QUOTES));
		$this->_display('error');
		exit;
    }
    
    /**
    * 将当前URL写入SESSION,用于自动返回
    * 
    */
    function _setBackURL($backURL = null)
    {
        if(!$backURL) {
            $router_str = APP::getRequestRoute(false);
	    	$vGet = V('g');
            unset($vGet[R_GET_VAR_NAME]);
            $backURL = URL($router_str, $vGet);
        }
		
		USER::set('__WAP_BACK_URL', $backURL);
    }
    
    /**
    * 获取自动返回的URL
    * @param bool $print 是否页面显示，如果需要显示，则需转换成WAP兼容的形式
    * 
    */
    function _getBackURL($print = false)
    {
		$backURL = USER::get('__WAP_BACK_URL') ? USER::get('__WAP_BACK_URL') : URL('index');
		return $print ? htmlspecialchars($backURL, ENT_QUOTES) : $backURL;
    }
}