<?php
/**
 * @file			verified_func.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-11-15
 * @Modified By:	heli/2010-11-15
 * @Brief			WAP字体设置-Xweibo
 */


/**
 * 用户认证
 *
 * @param array $user
 * @return tool	
 */
function wap_font_set() 
{
	$font_config = V('-:userConfig/wap_font_size', 1);
	switch ($font_config) {
		case 2:
			$strHTML = 'class="f14"';
			break;
			
		case 3:
			$strHTML = 'class="f16"';
			break;
			
		case 4:
			$strHTML = 'class="f18"';
			break;
			
		case 1:
		default:
			$strHTML = 'class="f12"';
			break;
	}
	echo $strHTML;
}