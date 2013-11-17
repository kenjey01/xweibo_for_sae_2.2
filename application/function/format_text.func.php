<?php
/**************************************************
*  Created:  2010-06-08
*
*  格式化微博显示的内容
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/
function format_text($text, $type = 'feed', $uid = 0, $show_em = true){
	if (empty($text)){return $text;}
	if ($type == 'feed') {
		
		// 短链配置
		static $shortLink = null;
		if(null == $shortLink){
        	$shortLink	= V('-:sysConfig/site_short_link', '');
		}
		
		$newText = '';
		//$c = preg_quote("\"~!@#$%^&*()+`{}[]:'<>?,/|\`·#￥%…—*（）——+－＝：“；‘《》？，。、｜\\");//[^@\.\s\;".$c."]
		$mc = preg_split(";(#[^#]+#|[a-z0-9\-_]*[a-z0-9]@(?:[a-z0-9-]+)(?:\.[a-z0-9-]+)+|@[\x{4e00}-\x{9fa5}0-9A-Za-z_\-]+|http://(?:sinaurl|t)\.cn/[a-z0-9]+|<a\s+href=[\"'][^\"']+[\"'][^>]*>.+?</a>);sium",$text,-1,PREG_SPLIT_DELIM_CAPTURE );
		//print_r($mc);
		foreach ($mc as $i=>$v){
			if ($i%2==1){
				if (substr($v, 0, 1).substr($v, -1, 1)=='##'){
					$newText.=' <a href="'.URL('search.weibo', array('k' => substr($v,1,-1))).'">'.htmlspecialchars($v).'</a> ';
				}elseif(substr($v, 0, 1)=='@'){
					$newText.=' <a href="'.URL('ta', array('name' => substr($v,1))).'">'.htmlspecialchars($v).'</a> ';
				}elseif(preg_match("#^http://(?:sinaurl|t)\.cn/[a-z0-9]+\$#sim",$v)){
					// 短链替换
					if ( $shortLink ) {
						$v = preg_replace("#^http://(?:sinaurl|t)\.cn#sim", $shortLink, $v);
					}
					$newText.=' <a title="'.$v.'" href="'.$v.'" target="_blank">'.$v.'</a> ';
				}elseif(preg_match("#<a\s+href=[\"']([^\"']+)[\"'][^>]*>(.+?)</a>#sim",$v,$ma)){
					if (preg_match("#http://(t.sina.com.cn|weibo.com)/k/([^/]+)\$#sim",$ma[1],$mlink)){
						$newText.=' <a href="'.URL('search', array('k' => $mlink[2])).'">'.htmlspecialchars($ma[2]).'</a> ';
					}elseif(preg_match("#/pub/tags/([^/]+)\$#sim",$ma[1],$tag)){
						/// 标签链接处理
						$newText.=' <a href="'.URL('search.user',array('k'=>urldecode($tag[1]),'ut'=>'tags')).'">'.htmlspecialchars($ma[2]).'</a> ';
					}else{
						$newText .= ($uid == '1257113795' ? $v : htmlspecialchars($v));  //1257113795 为系统管理员ID，不过滤链接
					}
				}else{
					$newText.= htmlspecialchars($v);
				}
			}else{
				$newText.=htmlspecialchars($v);
			}
		}
		$text = $newText;
	}else{
		$text = htmlspecialchars($text);
	}
	
	//替换表情
	if ($show_em && (!defined('ENTRY_SCRIPT_NAME') || ENTRY_SCRIPT_NAME != 'wap')) {
		static $search_em = null;
		static $replace_em = null;
		if(null === $search_em){
			$emoticons_cn = DS('xweibo/xwb.getRepFaces', 'g0/86400');
			$emoticons_tw = DS('xweibo/xwb.getRepFaces', 'g0/86400', 'zh_tw');
			$emoticons['search'] = array_merge($emoticons_cn['search'], $emoticons_tw['search']);
			$emoticons['replace'] = array_merge($emoticons_cn['replace'], $emoticons_tw['replace']);

			$search_em = isset($emoticons['search']) & is_array($emoticons['search']) ? $emoticons['search'] : array() ;
			$replace_em = isset($emoticons['replace']) & is_array($emoticons['replace']) ? $emoticons['replace'] : array() ;
			if (empty($search_em) || empty($replace_em)){
				DD('xweibo/xwb.getRepFaces');
			}
		}
		
		if (!empty($search_em)) {
			$text = str_replace($search_em, $replace_em, $text);
		}
	}
	
	return $text;
}
