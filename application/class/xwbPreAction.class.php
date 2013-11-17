<?php
/**
 * @file			xwbPreAction.class.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <jianzhou@staff.sina.com.cn>
 * @Create Date:	2011-05-18
 * @Modified By:	heli/2011-05-18
 * @Brief			发微博/评论前的附加操作处理
 */

class xwbPreAction 
{
	var $db;
	
	function xwbAdditive()
	{
		$this->db = APP::ADP('db');
	}

	
	/**
	 * demo 方法
	 * @param string $params 传递的参数
	 */
	function extra_test($params) 
	{
		print_r($params);
		die('in xwbPreAction test function.');
	}
	
	
	/**
	 * 先审后发情况下，发布评论的操作
	 * @param $params
	 */
	function extra_comment($params)
	{
		// 如果有屏蔽关键字,直接丢弃
		$isWordPass	= F('filter', $params['content'], 'content');
		if ( true!==$isWordPass ) {
			APP::ajaxRst(1, 30000, '正在审核中');
		}
		
		$data					= $params;
		$data['sina_uid']		= USER::uid();
		$data['sina_nick']		= USER::get('screen_name');
		$userToken				= USER::getOAuthKey(TRUE);
		$data['token']			= $userToken['oauth_token'];
		$data['token_secret']	= $userToken['oauth_token_secret'];
		$data['post_ip']		= F('get_client_ip');
		$data['dateline']		= APP_LOCAL_TIMESTAMP;
		
		if ( DR('CommentVerify.addComment', FALSE, $data) )
		{
			// 成功返回
			APP::ajaxRst(1, 30000, L('xwbPreAction__common__underReview'));
		}
		
		// 失败返回
		APP::ajaxRst(0);
	}

	/**
	 * 先审后发情况下，发布微博的操作
	 * @param $params
	 */
	function extra_update($params, $extends = array())
	{
		// 如果有屏蔽关键字,直接丢弃
		$isWordPass	= F('filter', $params['weibo'], 'content');
		if ( true!==$isWordPass ) {
			APP::ajaxRst(1, 30000, L('xwbPreAction__common__underReview'));
		}
		
		
		/// 如果是微直播
		if (isset($extends['live_id']) && $extends['live_id']) {
			$params['type'] = 'live';
			$params['extend_id'] = $extends['live_id'];
			$params['extend_data'] = json_encode($extends);
		}

		/// 如果是微访谈
		if (isset($extends['interview_id']) && $extends['interview_id']) {
			$params['type'] = 'interview';
			$params['extend_id'] = $extends['interview_id'];
			$params['extend_data'] = json_encode($extends);
		}
		
		/// 如果是活动
		if (isset($extends['event_id']) && $extends['event_id']) {
			$params['type'] = 'event';
			$params['extend_id'] = $extends['event_id'];
			$params['extend_data'] = json_encode($extends);
		}

		$data					= $params;
		$data['sina_uid']		= USER::uid();
		$data['nickname']		= USER::get('screen_name');
		$userToken				= USER::getOAuthKey(TRUE);
		$data['access_token']	= $userToken['oauth_token'];
		$data['token_secret']	= $userToken['oauth_token_secret'];
		$data['dateline']		= APP_LOCAL_TIMESTAMP;

		$result = DR('weiboVerify.addWeiboVerify', FALSE, $data);
		if ($result['rst']) {
			// 成功返回
			$pic = '';
			if (isset($data['picid']) && $data['picid']) {
				$pic = ',p:'.$data['picid'];
			}
			$json['html'] = '<LI rel="w:'.$result['rst'].',v:1'.$pic.'">' . TPL::module('feed', $this->_formatWeibo($data, $result['rst']), false) . '</LI>';
			$json['data'] = APP::getData('json', 'WBDATA',array());
			APP::ajaxRst($json, 30000, L('xwbPreAction__common__underReview'));
		}
		
		// 失败返回
		APP::ajaxRst(0);
	}

	/**
	 * 格式化微博结构
	 *
	 */
	function _formatWeibo($data, $id) {
		$wb = array();
		$wb['uid'] 	  = USER::uid();
		$wb['created_at'] =  date('D M d H:i:s O Y', $data['dateline']);
		$wb['id'] = $id;
		$wb['text'] = $data['weibo'];
		$wb['xwb_weibo_verify'] = 1;
		$wb['source'] = '';
		if (isset($data['picid']) && $data['picid']) {
			$wb['thumbnail_pic'] = F('profile_image_url.thumbnail_pic', $data['picid']);
			$wb['bmiddle_pic'] = F('profile_image_url.thumbnail_pic', $data['picid'], 'bmiddle');
			$wb['original_pic'] = F('profile_image_url.thumbnail_pic', $data['picid'], 'large');
		}
		/// 用户信息
		$users = array();
		$users = DR('xweibo/xwb.getUserShow', false, $data['sina_uid']); 
		$wb['user'] = $users['rst'];
		/// 转发微博信息
		if (!empty($data['retweeted_wid'])) {
			$rts = array();
			$rts = DR('xweibo/xwb.getStatuseShow', false, $data['retweeted_wid']);
			$wb['retweeted_status'] = $rts['rst'];
		}
		
		/// set the header param if exist
		$route = V('p:_route', '');
		if ($route == 'index.profile') {
			$wb['header'] = '-1';
			$wb['author'] = false;
		}
		
		return $wb;
	}
	
}
?>
