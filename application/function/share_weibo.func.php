<?php
/**************************************************
*  Created:  2010-06-08
*
*  分享微博内容 
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

/**
 * share weibo
 *
 * @param string $type 要分享微博的类型 
 * @param string|array 分享微博的内容
 * @return string
 */
function share_weibo($type, $info) {
	switch ($type) {
	case 'event':
		$e_url =  W_BASE_HTTP . URL('event.details',array('eid'=>$info['id']));
		$content = L('function__shareWeibo__shareEventWeibo', F('escape', $info['title']), $info['addr'], date('Y',$info['start_time']), date('n',$info['start_time']), date('j',$info['start_time']), $e_url);
		//$content = '我发现了一个很棒的活动“' . F('escape', $info['title']) . '”　地点：'.$info['addr']. '　时间：' . date('Y',$info['start_time']).'年'.date('n',$info['start_time']).'月'.date('j',$info['start_time']) . '　活动链接：' . $e_url; 
		$content = F('escape', $content);
		break;
	case 'event_attend':
		$e_url =  W_BASE_HTTP . URL('event.details',array('eid'=>$info['id']));
		$content = L('function__shareWeibo__shareEventAttend', F('escape', $info['title']), $info['addr'], date('Y',$info['start_time']), date('n',$info['start_time']), date('j',$info['start_time']), $e_url);
		//$content = '我刚刚参加了一个很棒的活动“' . F('escape', $info['title']) . '”　地点：'.$info['addr']. '　时间：' . date('Y',$info['start_time']).'年'.date('n',$info['start_time']).'月'.date('j',$info['start_time']) . '　活动链接：' . $e_url; 
		$content = F('escape', $content);
		break;
	case 'live':
		$e_url = W_BASE_HTTP.URL('live.details',array('id' => $info['id']));
		$guest = DR('microLive.getLiveUsersBatchShow', '', $info['guest']);
		if (empty($guest['errno'])) {
			$guest_list = $guest['rst'];
		}

		$guest_name_str = '';
		if ($guest_list) {
			foreach ($guest_list as $var) {
				$guest_name[] = '@'.$var['screen_name'];
			}
			$guest_name_str = implode(' ', $guest_name);
		}
		$content = L('function__shareWeibo__shareLiveWeibo', F('escape', $info['title']), F('format_time.foramt_show_time', $info['start_time'], 2), F('format_time.foramt_show_time', $info['end_time'], 2), $guest_name_str, $e_url);
		//$content = '给大家推荐一个不错的直播，来看看吧：“'.F('escape', $info['title']).'”，直播时间'.F('format_time.foramt_show_time', $info['start_time'], 2).'-'.F('format_time.foramt_show_time', $info['end_time'], 2).'，特邀嘉宾'.$guest_name_str.' ，直播地址：'.$e_url;
		break;
	case 'live_tips':
		$min = ($info['start_time'] - $info['notice_time']) / 60;
		$url = URL('live.details', array('id' => $info['id'])); 
		$content = L('function__shareWeibo__shareLiveTip', $url, F('escape', $info['title']), $min);
		//$content = '提醒：“<a href="'.$url.'">'.F('escape', $info['title']).'</a>“将在'.$min.'分钟后开始，请您关注';
		$content = F('escape', $content);
		break;

		
	case 'interview':
		$e_url 			= W_BASE_HTTP.URL('interview',array('id' => $info['id']));
		$guest_name_str = '';
		
		if ( is_array($info['guest']) ) 
		{
			$guest_name = array();
			foreach ($info['guest'] as $var) 
			{
				$guest_name[] = '@'.$var['screen_name'];
			}
			$guest_name_str = implode(' ', $guest_name);
		}
		$content = L('function__shareWeibo__shareInterviewWeibo', $info['title'], F('format_time.foramt_show_time', $info['start_time'], 2), F('format_time.foramt_show_time', $info['end_time'], 2), $guest_name_str, $e_url);
		//$content = '给大家推荐一个不错的访谈，来看看吧：“'.$info['title'].'”，访谈时间'.F('format_time.foramt_show_time', $info['start_time'], 2).'-'.F('format_time.foramt_show_time', $info['end_time'], 2).'，访谈嘉宾'.$guest_name_str.' ，访谈地址：'.$e_url;
	break;
	
	case 'interview_tips':
		$content = L('function__shareWeibo__shareInterviewTip', URL('interview', array('id'=>$info['id'])), $info['title'], $info['notice_time']/60);
		//$content = '提醒：在线访谈 “<a href="'.URL('interview', array('id'=>$info['id'])).'">'.$info['title'].'</a>“ 将在'.($info['notice_time']/60).'分后开始，请您关注';
		$content = F('escape', $content);
		break;
	}

	return str_replace(array(':', ','), array('\:', '\,'), $content);
}
?>
