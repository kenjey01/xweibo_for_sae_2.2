<?php
function get_logo_src($type='web'){
	$std_src='';
	$types=array('wap','web','output');
	switch($type){
		case 'web':
			if (V('-:sysConfig/logo',false)){
				$std_src=F('fix_url', V('-:sysConfig/logo'));
			}else{
				$std_src=W_BASE_URL. WB_LOGO_DEFAULT_NAME;
			}
			break;
		case 'wap':
			if (V('-:sysConfig/logo_wap',false)){
				$std_src=F('fix_url', V('-:sysConfig/logo_wap'));
			}else{
				$std_src=W_BASE_URL. WB_LOGO_WAP_DEFAULT_NAME;
			}
			break;
		case 'output':
			if (V('-:sysConfig/logo_output',false)){
				$std_src=F('fix_url', V('-:sysConfig/logo_output'));
			}else{
				$std_src=W_BASE_URL. WB_LOGO_OUTPUT_DEFAULT_NAME;
			}
			break;			
	}
	return $std_src;
}
?>