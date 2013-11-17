<?php
/**
 *  检查用户吧被迫配置为禁言、禁止访问、清除、正常列表
 */

function user_action_check($checked, $uid = NULL,$isRet=FALSE) {

	$list = DR('mgr/userCom.getUserActionList', 'g/0');
	
	if ($list['errno'] == 0) {
		
		if ($uid == NULL && !USER::isUserLogin()) return NULL;
		
		if ($uid == NULL) {
			$uid = USER::uid();
		}
		
		if (!empty($list['rst'])) {
			foreach ($list['rst'] as $l) {
				
				if ($l['sina_uid'] == $uid && in_array($l['action_type'], $checked)) {
					if($isRet==TRUE){
						return $l['action_type'];
					}
					return TRUE;
				}
			}
			return FALSE;
		}
		return FALSE;
	}
	return FALSE;
}
?>
