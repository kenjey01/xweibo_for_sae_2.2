<?php
/**
 * @file			show.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	heli/2010-11-15
 * @Brief			单条微博控制器-Xweibo
 */

class show_mod {

	function show_mod()
	{
	}

	/**
	 * 某人的单条微博的评论列表
	 *
	 *
	 */
	function default_action()
	{
		$id = V('g:id');

		if (empty($id)) {
			//提示访问的页面不存在，跳转到首页
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__pageNotExist')));
		}

		//调用单条微博的详细信息接口
		$mblog_info = DR('xweibo/xwb.getStatuseShow', '', $id);
		if ($mblog_info['errno']) {
			APP::tips(array('tpl' => 'e404', 'msg'=> L('controller__common__pageNotExist')));
		}
		$mblog_info = $mblog_info['rst'];

		/// 过滤过敏微博
		$mblog_info = APP::F('weibo_filter', $mblog_info, true);
		if (empty($mblog_info)) {
			APP::tips(array('tpl' => 'e404', 'msg'=> L('controller__common__pageNotExist')));
		} elseif (in_array(3, $mblog_info['filter_state'])) {
			// 如果不是管理员则返回出错信息
			if (!USER::aid()) {
				APP::tips(array('tpl' => 'e403', 'msg'=> L('controller__show__weiboDelOrShielding')));
			}
		}

		//获取个人资料
		$userinfo = DR('xweibo/xwb.getUserShow', '', $mblog_info['user']['id']);
		$userinfo = $userinfo['rst'];
		/// 过滤过敏用户
		$userinfo = F('user_filter', $userinfo, true);

		if (empty($userinfo)) {
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		}

		$ids = array();
		$ids[] = (string)$mblog_info['id'];
		if (isset($mblog_info['retweeted_status']['id'])) {
			$ids[] = (string)$mblog_info['retweeted_status']['id'];
		}


		/// 右侧模块数据
		//$modules = DS('PageModule.getPageModules', '', 2, 1);

		TPL::assign('id', $id);
		TPL::assign('userinfo', $userinfo);
		//TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::assign('mblog_info', $mblog_info);
		TPL::assign('uid', USER::uid()); 
		TPL::assign('is_show', 1);
		TPL::display('mblog_detail');
	}

	function disabled() {
		if (!USER::aid()) {
			APP::ajaxRst(false, '-1', L('controller__show__notAdmin'));
		}
		$id = V('r:id', false);
		if (!$id || !is_numeric($id)){
			APP::ajaxRst(false, '1', L('controller__show__missParameter'));
		}
		
		DR('xweibo/xwb.setToken','', 2);
		$rst = DR('xweibo/xwb.getStatuseShow','', $id);
		$data = $rst['rst'];
		if (isset($data['error_code']) && $data['error_code']) {
			APP::ajaxRst(false, '3', L('controller__show__apiError'));
		}
		$values = array(
				'type' => 1,
				'item' => $data['id'],
				'comment' => $data['text'],
				'user' => $data['user']['screen_name'],
				'publish_time' => date('Y-m-d H:i:s', strtotime($data['created_at'])),
				'add_time' =>APP_LOCAL_TIMESTAMP,
				'admin_name' =>  USER::get('screen_name'),
				'admin_id' => USER::aid()
				);
		$rst = DR('xweibo/disableItem.save', '', $values);

		// 添加成功则更新缓存
		if ($rst['rst'] > 0) {
			DD('xweibo/disableItem.getDisabledItems', 'g1/0', 1);
			DR('xweibo/weiboCopy.disabled', '', $id, 1);
			APP::ajaxRst(true);
		}
		
		APP::ajaxRst(false, '2', L('controller__show__shieldWeibo'));
		//APP::ajaxRst(false, 2122202, '屏蔽微博失败,可能该微博已经在屏蔽列表');
	}
	
	
	
	/**
	 * \brief 举报微博内容
	 */
	function reportSpam()
	{
		// check data
		$cid = V('p:cid', FALSE);
		if (empty($cid) || !is_numeric($cid)) {
			APP::ajaxRst(false, '1', L('controller__show__weiboIdNotAllowEmpty'));
		}
		
		$content = V('p:content', FALSE);
		if (empty($content)) {
			APP::ajaxRst(false, '1', L('controller__show__reportContentEmpty'));
		}
		
		// report to API, 不考虑接口出错问题，认为提交都成功
		DR('xweibo/xwb.report_spam','', $content, null, $cid);
		
		APP::ajaxRst(true);
	}
}
?>
