<?php
function xwb_iconv($source, $in, $out){
	$in		= strtoupper($in);
	$out	= strtoupper($out);
	if ($in == "UTF8"){$in = "UTF-8";}
	if ($out == "UTF8"){$out = "UTF-8";}
	if($in==$out){ return $source;}

	if(function_exists('mb_convert_encoding')) {
		return mb_convert_encoding($source, $out, $in );
	}elseif (function_exists('iconv'))  {
		return iconv($in,$out."//IGNORE", $source);
	}
	return $source;
}
