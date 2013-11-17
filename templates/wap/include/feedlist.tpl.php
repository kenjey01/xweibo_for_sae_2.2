<?php
//如果未登录，使用内置的token访问
if (!USER::uid()) {
	DS('xweibo/xwb.setToken', '', 2);
}
/// 过滤微博
$list = F('weibo_filter', $list);

//获取微博的评论数与转发数
$ids = array();
foreach ($list as $wb) {
	$ids[] = $wb['id'];
	if (isset($wb['retweeted_status'])) {
		$ids[] = $wb['retweeted_status']['id'];
	}
}

$stat_counts = array();
$batch_counts = DR('xweibo/xwb.getCounts', '', $ids);
if (empty($batch_counts['errno'])) {
	$batch_counts = $batch_counts['rst'];
	foreach ($batch_counts as $count) {
		$stat_counts[(string)$count['id']] = array('comments' => $count['comments'], 'rt' => $count['rt']);
	}
}

foreach ($list as $wb) {	/// 过滤掉过敏的原创微博
	if ((isset($wb['filter_state']) && !empty($wb['filter_state'])) || (isset($wb['user']['filter_state']) && !empty($wb['user']['filter_state']))) {
		continue;
}

$wb['uid'] 	  = USER::uid();
$wb['author'] = isset($author) ? $author : TRUE;
$wb['counts'] = isset($stat_counts[(string)$wb['id']]) ? $stat_counts[(string)$wb['id']] : array('comments' => 0, 'rt' => 0);
if (isset($wb['retweeted_status'])) {
	$wb['retweeted_status']['counts'] = isset($stat_counts[(string)$wb['retweeted_status']['id']]) ? $stat_counts[(string)$wb['retweeted_status']['id']] : array('comments' => 0, 'rt' => 0);
}

echo '<div class="f-list">';
	TPL::plugin('wap/include/feed', $wb, false);
echo '</div>';
}
?>