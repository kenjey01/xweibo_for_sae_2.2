<?php
/**************************************************
*  Created:  2010-10-28
*
*  截取一定长度的字符串
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author guoliang1 <guoliang1@staff.sina.com.cn>
*
***************************************************/

function cut_string($str, $len)
{
	// 检查长度
	if (mb_strwidth($str, 'UTF-8')<=$len)
	{
		return $str;
	}

	
	// 截取
    $i 		= 0;   
    $tlen 	= 0;   
    $tstr 	= '';   
    
    while ($tlen < $len) 
    {   
        $chr 	= mb_substr($str, $i, 1, 'utf8');   
        $chrLen = ord($chr) > 127 ? 2 : 1;   
        
        if ($tlen + $chrLen > $len) break;   
        
        $tstr .= $chr;   
        $tlen += $chrLen;   
        $i ++;   
    }
    
    if ($tstr != $str) 
    {   
        $tstr .= '...';   
    }
    
    return $tstr; 
}