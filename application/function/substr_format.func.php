<?php
/**
 * 截取指定长度的字符串，超出部分用 ..替换
 * @param string $text
 * @param int $length
 * @param string $replace
 * @param string $encoding
 */
function substr_format($text, $length, $replace='..', $encoding='UTF-8') 
{
	if ($text && mb_strlen($text, $encoding)>$length)
	{
		return mb_substr($text, 0, $length, $encoding).$replace;
	}
	return $text;
}

?>
