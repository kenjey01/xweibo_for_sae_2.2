<?php

function parse_skin($preview) {

    $skins = array();
    $skin_arr = explode('$$', $preview);
    foreach ($skin_arr as $skin) {
	$tmp = explode(':', $skin, 2);
	
	if (count($tmp) == 2) {
	    $skins[$tmp[0]] = $tmp[1];
	}
    }
    if (isset($skins['colors'])) {
	$skins['colors'] = explode(',', $skins['colors']);
    }
    return $skins;
}
?>