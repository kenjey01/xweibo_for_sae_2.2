<?php
function show_ad($flag, $css_class='') {
	$prev = V('r:flag');
	$data = ''; 
	$close_btn = '';
	$display = true;
	if ($prev == $flag) {
		$data = V('r:content', '');
	} else {
		//@todo 从数据库或memcache读配置数据
		$router = APP::getRequestRoute();
		//DD('ad.getUsingAd');
		$rs = DS('ad.getUsingAd', 'g2', 1, $router);
		for ($i=0, $count=count($rs); $i < $count; $i++) {
			if ($rs[$i]['flag'] == $flag && $rs[$i]['using']) {
				$data = $rs[$i]['content'];
				// 处理对联广告
				if (in_array($rs[$i]['flag'], array('global_left', 'global_right')) ) {
					// 如果设置了“按天展现”并且存在cookie则不显示广告
					if (!empty($rs[$i]['config']) && ($config = json_decode($rs[$i]['config'], true)) &&
							isset($config['topic_get']) && $config['topic_get'] == 2 &&
							V('c:ad_' . $rs[$i]['page'] . '_' . $rs[$i]['flag']. '_hide', false)) {
						$display = false;
					}
					$close_btn = '<span class="close-xad"><a href="#" id="xwb_ad_cls">'.LO('function__showAd__close').'</a></span>';
					//$close_btn = '<a href="#" class="ico-close-btn" id="xwb_ad_cls">关闭窗口</a>';
				}

				if ($rs[$i]['flag'] == 'sidebar' && !empty($data)) {
					$data = '<div class="mod-aside aside-xad">' .$data. '</div>';
				}

				break;
			}
		}
	}
	if (!empty($css_class)) {
		$css_class = ' class="' . $css_class. '"';
	}
	return !empty($data) && $display ? '<div id="ad_' . $flag . '" ' . $css_class . '>' . $close_btn  .  $data . '</div>' : '';
}

?>
