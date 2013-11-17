<?php
/**************************************************
*  Created:  2011-5-17
*
*  Xweibo的安全策略，主要包括黑名单、白名单、先审后发、先发后审
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author guoliang1 <liujz@staff.sina.com.cn>
*
***************************************************/

/**
 * @param string $str
 * @return boolean, true:需要审核；false:不需要审核
 */
function strategy($str)
{
	// 空字符串，返回FALSE
	if ( empty($str) )
	{
		return FALSE;
	}
	
	
	// 策略开始
	$config = json_decode( V('-:sysConfig/xwb_strategy'), TRUE);
	
	// 先审后发 
	if ( isset($config['strategy']) && $config['strategy'] )
	{
		if ( isset($config['type']) )
		{
			$result = TRUE;
			switch ( $config['type'] )
			{
				// 指定用户审核(黑名单)
				case 1:
					$curid	= USER::uid();
					$result	= isset( $config['black'][$curid] );
				break;
					
					
				// 指定用户不审核(白名单)
				case 2:
					$curid	= USER::uid();
					$result = !isset( $config['white'][$curid] );
				break;
				
				
				// 全站
				default:
					$startTime = isset($config['start']) 	? $config['start'] 		: false;
					$endTime   = isset($config['end']) 		? $config['end'] 		: false;
					$keywords  = isset($config['keyword']) 	? $config['keyword'] 	: array();
					
					// 不需要审核时间段
					if ( ($startTime&&APP_LOCAL_TIMESTAMP<$startTime) || ($endTime&&APP_LOCAL_TIMESTAMP>$endTime)) 
					{
						$result = FALSE;
					}
					
					// 关键字过滤, 支持多个关键字
					if ( is_array($keywords) && !empty($keywords) )
					{
						$hitKey = FALSE;
						foreach ( $keywords as $aWord )
						{
							$pos = strpos($str, $aWord);
							if ( $pos || $pos===0 )
							{
								$hitKey = TRUE;
								break;
							}
						}
						$result = $hitKey;
					}
			}
			return $result;
		}
	}
	
	
	// 先发后审
    return FALSE;
}