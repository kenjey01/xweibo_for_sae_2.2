<?php
/**
 * @file			sysnotice.func.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			guanghui <guanghui1@staff.sina.com.cn>
 * @Create Date:	2011-04-13
 * @Brief			系统通知系列函数，WAP与WEB通用
 */

/**
* 获取未读通知数
* 注意：WAP与WEB通用
* 
* @return int
*/
function getCount()
{
	$notices = 0;

	$sina_uid = USER::uid();
	$userPreMaxTime = USER::get('user_max_notice_time');
	$maxTime = DR('notice.getSysMaxTime', 'g0/200');
	$maxTime = (int)$maxTime['rst'];
	if ($maxTime > $userPreMaxTime) {
		if (V('-:userConfig/user_newnotice') == 1) {
			$notices = DR('notice.getUnreadNoticeNum', '', $sina_uid, $userPreMaxTime);
			$notices = (int)$notices['rst'];
		}
		if ($notices === 0) {
			$update_result = DR('notice.updateUserPreMaxTime', '', $sina_uid, $maxTime);
			if ($update_result['rst']) {
				USER::set('user_max_notice_time', $maxTime);
			}
		}
	}
	
	return $notices;
}

/**
* 未读通知数清零
* 注意：WAP与WEB通用
* 
*/
function resetCount()
{
	$maxTime = DR('notice.getSysMaxTime', 'g0/200');
	$maxTime = (int)$maxTime['rst'];
	$userPreMaxTime = USER::get('user_max_notice_time');
	if ($maxTime > $userPreMaxTime) {
		$update_result = DR('notice.updateUserPreMaxTime', '', USER::uid(), $maxTime);
		if ($update_result['rst'] !== false) {
			USER::set('user_max_notice_time', $maxTime);
		}
	}
}