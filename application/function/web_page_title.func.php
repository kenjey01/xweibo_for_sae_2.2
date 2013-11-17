<?php
/**
 * 页面标题获取方法
 * 
 */
function web_page_title($titVar=false, $myTitle=false, $pre=false, $suf=false, $site_name=false){
	$pre	= $pre===false ? V('-:tpl/title/_pre') : $pre;
	$suf	= $suf===false ? V('-:tpl/title/_suf') : $suf;
	$title	= $myTitle===false ? L(V('-:tpl/title/'.APP::getRequestRoute(),'')) : $myTitle;
	$site_name = $site_name===false ? (empty($title) ? '' : ' - ').V('-:sysConfig/site_name') : ' - '.$site_name;
	$sVar = $titVar===false ? array() : (is_array($titVar) ? $titVar : array($titVar));
	array_unshift($sVar, $title);
	//print_r($sVar);
	return $titVar===false ? $pre.$title.$site_name.$suf : $pre.call_user_func_array('sprintf',$sVar).$site_name.$suf; 
}
