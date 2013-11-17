<?php
/**
 * @file			live.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli1 <heli1@staff.sina.com.cn>
 * @Create Date:	2011-04-07
 * @Modified By:	heli1/2011-04-07
 * @Brief			在线直播控制器-Xweibo
 */
class live_mod {

	function live_mod() 
	{	// 代理账号访问
		if ( !USER::isUserLogin() ){ DS('xweibo/xwb.setToken', '', 2); }
	}

	/**
	 * 在线直播首页
	 */
	function default_action() {
		$liveInfo = V('-:sysConfig/microLive_setting') ? json_decode(V('-:sysConfig/microLive_setting'), true) : ''; 
		$banner_img = isset($liveInfo['banner_img']) ? $liveInfo['banner_img'] : (WB_LANG_TYPE_CSS ? W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/live_bg.jpg' : W_BASE_URL.'img/live_bg.jpg');

		TPL::assign('liveInfo', $liveInfo);
		TPL::assign('banner_img', $banner_img);
		TPL::display('microlive/index');
	}

	/**
	 * 详细在线直播
	 */
	function details() {
		/// 在线直播id
		$id = V('g:id');
		if (empty($id)) {
			/// 不存在指定的在线直播
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__liveNotExist')));
		}

		$liveInfo = DS('microLive.getLiveById', 'g0/1800', $id);
		if (empty($liveInfo)) {
			/// 不存在指定的在线直播
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__liveNotExist')));
		}

		/// 发布框参数配置
		$input_params = array('title' => L('controller__live__topic', $liveInfo['trends']),
							'show_video' => false,
							'show_music' => false,
							'show_trends' => false,
							'trends' => $liveInfo['trends'],
							'ext_xwbAdditive' => array('doAction' => 'live', 'extra_params' => array('live_id' => $liveInfo['id']))
						);

		/// 微博列表参数配置
		$weibo_params = array();
		TPL::assign('liveInfo', $liveInfo);
		TPL::assign('input_params', $input_params);
		TPL::display('microlive/details');
	}

	/**
	 * 在线直播列表
	 */
	function livelist() {
		$liveInfo = V('-:sysConfig/microLive_setting') ? json_decode(V('-:sysConfig/microLive_setting'), true) : ''; 

		TPL::assign('liveInfo', $liveInfo);
		TPL::display('microlive/list');
	}

	/**
	 * 获取最新微博信息
	 */
	function unread() 
	{
		$live_id 		= V('p:id');
		$last_id 		= V('p:wb_id');
		$news_list 		= array();
		$list_html 		= array();
		$gMtype 		= V('p:gMType', false);
		$params 		= $gMtype ? array('gMtype'=>$gMtype) : array();
		$wb_id_array 	= DS('microLive.getMicroLiveWbs', '', $live_id, 1, 1, 20, $last_id, $params);
		
		if ($wb_id_array) {
			$wb_ids = array();
			$wids = array();
			foreach ($wb_id_array as $var) {
				$item = json_decode($var['weibo'], true);
				/// 区分发微博者是主持人，嘉宾还是网友
				if ('2' == $var['type']) {
					$item['user']['live_user_type'] = 'master';
				} elseif ('3' == $var['type']) {
					$item['user']['live_user_type'] = 'guest';
				}
				$news_list[] = $item;

				$item['header'] = isset($header) ? $header: 1;
				$item['uid'] 	  = USER::uid();
				$item['author'] = isset($author) ? $author : TRUE;
				$list_html[$item['id']] = '<LI rel="w:'.$item['id'].'">' . TPL::module('feed', $item, false) . '</LI>';
			}
		}
		$json['list'] = F('format_weibo',$news_list);
		$json['html'] = $list_html;
		$json['count'] = count($news_list);
		$json['total'] = DS('microLive.getWbCount', '', $live_id, 1, $params);
		if (!empty($news_list)) {
			$json['wb_id'] = $news_list[0]['id'];
		}
		APP::ajaxRst($json, 0);
	}
}
?>
