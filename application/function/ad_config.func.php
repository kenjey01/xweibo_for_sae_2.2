<?php
function ad_config() {
	$prev = V('r:flag');
	$data = ''; 
	//@todo 从数据库或memcache读配置数据

	if ($prev) {
		$config = array(
				'flag'=>V('p:flag'),
				'page'=>V('p:page'),
				'cfg' => array()
				);
		$data[] = $config;
	} else {

		$router = APP::getRequestRoute();
		//DD('ad.getUsingAd');
		$rs = DS('ad.getUsingAd', '', 1, $router);
		//$global_ad = DS('ad.getUsingAd', '', 1, 'global');
		//$rs = array_merge($rs, $global_ad);
		for ($i=0, $count=count($rs); $i < $count; $i++) {
			// 如果是对联，并设置了“按天展现”，并且cookie存在，则不输出配置
			if (in_array($rs[$i]['flag'], array('global_left', 'global_right')) &&
					!empty($rs[$i]['config']) && ($cfg= json_decode($rs[$i]['config'], true)) &&
					isset($cfg['topic_get']) && $cfg['topic_get'] == 2 &&
					V('c:ad_' . $rs[$i]['page'] . '_' . $rs[$i]['flag']. '_hide', false)) {
				continue;
			}
			$config = array();
			if (empty($rs[$i]['config'])) {
				$rs[$i]['config'] = '{}';
			}
			$config['flag'] = $rs[$i]['flag'];
			$config['page'] = $rs[$i]['page'];
			$config['cfg'] = json_decode($rs[$i]['config'], true);
			$data[] = $config;
		}
	}
	$data = json_encode($data);
	return $data;
}

?>
