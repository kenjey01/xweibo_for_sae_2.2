<?php
/**************************************************
*  Created:  2010-11-25
*
*  weibo皮肤
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/


/**
 * weibo皮肤选择
 *
 * @param string $skinCssDirName
 * @param int $skin_id
 * @param array $skin_list
 * @param array $route
 * @return array
 */
function selectSkin($skinCssDirName, $skin_id, $skin_list, $route)
{
	if (!$skinCssDirName){
		switch($route['class']) {
			case 'index':
				$skin_id = USER::cfg('user_skin');
				if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
					$skinCssDirName =  $skin_list[$skin_id]['directory'];
				}
				break;
			case 'ta':
				if(trim(V('g:id',0))) {
					$sina_uid = trim(V('g:id',0));
				}else{
					$user_info = DR('xweibo/xwb.getUserShow', '', null, null, urldecode(V('g:name','')), false);
					if($user_info['rst']) {
						$sina_uid = $user_info['rst']['id'];
					}
				}
				if(isset($sina_uid)) {
					$skin_rst = DR('common/userConfig.get', '', 'user_skin', $sina_uid);
					$skin_id = $skin_rst['rst'];
					
				}
				if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
					$skinCssDirName =  $skin_list[$skin_id]['directory'];
				}
				break;
			case 'show':
				if (!USER::uid()){
					break;
				}
				$id = trim(V('g:id',0));
				if(isset($id)) {
					$mblog_rst = DR('xweibo/xwb.getStatuseShow', '', $id);
					$mblog_info = $mblog_rst['rst'];
				}
			
				if($mblog_info && isset($mblog_info['user']['id'])) {
					$skin_rst = DR('common/userConfig.get', '', 'user_skin', $mblog_info['user']['id']);
					$skin_id = $skin_rst['rst'];
				}

				if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
					$skinCssDirName =  $skin_list[$skin_id]['directory'];
				}
				break;
		}
	}
	
	if (!$skinCssDirName){
		$skin_id = USER::sys('skin_default');
		if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
			$skinCssDirName =  $skin_list[$skin_id]['directory'];
		}
		if (!$skinCssDirName){
			$skinCssDirName = SITE_SKIN_CSS_PRE . SITE_SKIN_TYPE;
		}
	}
	$user_skin_config['skin_id'] = $skin_id;
	$user_skin_config['skinCssDirName'] = $skinCssDirName;

	return $user_skin_config;
}

function getSkinPath(){
	///未登录使用默认皮肤，登录了，ta和ta的show显示别人的皮肤，自己的仍显示自己的皮肤
	$router = APP::getRequestRoute(true);
	if(in_array($router['class'],array('ta','show'))){
		switch($router['class']){
			case 'show':
				$blogid=trim(V('g:id'),FALSE);
				if(!$blogid&&!USER::uid()){
					$useDefault=TRUE;
				}
				else{
					$mblog_rst = DR('xweibo/xwb.getStatuseShow', '', $blogid);
					if(isset($mblog_rst['rst']['errno'])&&$mblog_rst['rst']['errno']==0){
						
						$sina_uid=$mblog_rst['rst']['user']['id'];
					}
					else{
						$useDefault=TRUE;
					}					
				}
				break;
			case 'ta':
			default:
				$sina_uid=trim(V('g:id'),FALSE);	
		}
	}
	elseif(USER::isUserLogin()){
		$sina_uid=USER::uid();
	}
	if(isset($sina_uid)&&$sina_uid){
		// 这里获取的可能是自己或者别人的皮肤，所以没有用V
		$skin_rst = DR('common/userConfig.get', 'u0/0', 'user_skin', $sina_uid);
		
		//$skin_rst = V('-:userConfig/user_skin');
		if($skin_rst['rst']==NULL){
			$useDefault=TRUE;
		}
		elseif(is_numeric($skin_rst['rst'])){
			//皮肤文件夹
			$rs = DR('mgr/skinCom.getSkinById', 86400,null,0);
			$skinList=$rs['rst'];
			if(isset($skinList[$skin_rst['rst']])){
				return array('dir'=>$skinList[$skin_rst['rst']]['directory'],
					     'style_id'=>$skinList[$skin_rst['rst']]['style_id']
					     );	
			}
			else{
				$useDefault=TRUE;	
			}
			
		}
		else{
			//自定义皮肤
			return array('path'=>URL('setting.getSkin','id='.$sina_uid));
			
		}		
	}
	if(!isset($useDefault)||$useDefault){
		//使用系统默认皮肤
		$default_use_custom=V('-:sysConfig/default_use_custom', 0);
		if(isset($default_use_custom)&&$default_use_custom=='1'){
			return array('path'=>URL('setting.getSkin','sys=1'));
		}
		else{
			$rs = DR('mgr/skinCom.getSkinById', 86400);//好获取所有的皮肤
			$skin_list = $rs['rst'];
			$skin_id = V('-:sysConfig/skin_default', FALSE);
			if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
				$skinCssDirName =  $skin_list[$skin_id]['directory'];
				$style_id=$skin_list[$skin_id]['style_id'];
			}
			else{
				$skinCssDirName='skin_default';
				$style_id=0;
			}
			return array('dir'=>$skinCssDirName,
				     'style_id'=>$style_id);
		}
	}
}

