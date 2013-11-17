<?php
/**
 * WAP_SEARCH_HIGHLIGHT;
 * 高亮显示是搜索结果
 * @param $search	是搜索的文字
 * @param $status	微博信息内容
 * @return
 */

function wap_search_highlight($search, $status) {

	$mc = preg_split("/((&lt;|<)a.+?\/a(>|&gt;))/", $status, -1, PREG_SPLIT_DELIM_CAPTURE);
	$newText = "";
	foreach ($mc as $m) {
		
		if (!preg_match("/((&lt;|<)a.+?\/a(>|&gt;))/", $m, $ma) && trim($m) != '' && $m != '&lt;' && $m != '&gt;' && $m != '>' && $m != '<') {
			$newText.= preg_replace("/(".$search.")/i", "<span class='search-txt'>$1</span>", $m);
		} elseif($m != '>' && $m != '<') {
			$newText.= $m;
		}
	}
	return $newText;
}
?>