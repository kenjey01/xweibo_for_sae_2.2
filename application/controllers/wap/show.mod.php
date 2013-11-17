<?php
/**
 * @file			show.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			tangqiping <qiping@staff.sina.com.cn>
 * @Create Date:	2011-03-08
 * @Modified By:	tangqiping/2011-03-08
 * @Brief			单条微博操作
 */

class show_mod extends action {
	
	function show_mod() {

		parent::action();
	}
	/**
	 * 某人的单条微博的评论列表
	 *
	 *
	 */
	
	function default_action() {

		$id = V('g:id');
		
		if (empty($id)) {
			$this->_showErr(L('controller__show__defaultAction__paramsErr'), URL('pub'));
		}
		$mblog_info = DR('xweibo/xwb.getStatuseShow', '', $id);
		
		if ($mblog_info['errno']) {
			$this->_showErr(L('controller__show__defaultAction__notFoundPage'), URL('pub'));
		}

		//检查微博或用户是否被屏蔽
		$wb = F('weibo_filter', $mblog_info['rst'], true);
		
		if (empty($wb)) {
			$this->_showErr(L('controller__show__defaultAction__notFoundPage'), URL('pub'));
		}
		$page = (int)V('g:page', 1);
		$limit = 10;

		//获取当前微博的评论列表
		$list = DR('xweibo/xwb.getComments', '', $id, $limit, $page);
		
		if (!empty($list['errno'])) {
			$this->_showErr(L('controller__show__defaultAction__emptyTip'), URL('show.default_action', 'id=' . $id));
		}
		$list = $list['rst'];

		//记录当前URL
		$this->_setBackURL();

		//过滤过敏评论列表
		$list = APP::F('weibo_filter', $list);

		//获取转发数与评论数
		$counts = DR('xweibo/xwb.getCounts', '', $id);
		$wb['counts'] = isset($counts['rst'][0]) ? array(
			'comments' => $counts['rst'][0]['comments'],
			'rt' => $counts['rst'][0]['rt']
		) : array(
			'comments' => 0,
			'rt' => 0
		);

		//原微博的转发数与评论数
		
		if (isset($wb['retweeted_status'])) {
			$retweeted_counts = DR('xweibo/xwb.getCounts', '', $wb['retweeted_status']['id']);
			$wb['retweeted_status']['counts'] = isset($retweeted_counts['rst'][0]) ? array(
				'comments' => $retweeted_counts['rst'][0]['comments'],
				'rt' => $retweeted_counts['rst'][0]['rt']
			) : array(
				'comments' => 0,
				'rt' => 0
			);
		}
		TPL::assign('wb', $wb);
		TPL::assign('list', $list);
		TPL::assign('page', $page);
		TPL::assign('limit', $limit);
		$this->_display('wb_comments');
	}
	/**
	 * 转发微博页面
	 *
	 */
	
	function repos() {

		$id = V('g:id');
		
		if (empty($id)) {
			$this->_showErr(L('controller__show__repos__paramsErr'), URL('pub'));
		}
		$mblog_info = DR('xweibo/xwb.getStatuseShow', '', $id);
		
		if ($mblog_info['errno']) {
			$this->_showErr(L('controller__show__repos__notFoundPage'), URL('pub'));
		}

		//检查微博或用户是否被屏蔽
		$wb = F('weibo_filter', $mblog_info['rst'], true);
		
		if (empty($wb)) {
			$this->_showErr(L('controller__show__repos__notFoundPage'), URL('pub'));
		}

		//获取转发数与评论数
		$counts = DR('xweibo/xwb.getCounts', '', $id);
		$wb['counts'] = isset($counts['rst'][0]) ? array(
			'comments' => $counts['rst'][0]['comments'],
			'rt' => $counts['rst'][0]['rt']
		) : array(
			'comments' => 0,
			'rt' => 0
		);

		//原微博的转发数与评论数
		
		if (isset($wb['retweeted_status'])) {
			$retweeted_counts = DR('xweibo/xwb.getCounts', '', $wb['retweeted_status']['id']);
			$wb['retweeted_status']['counts'] = isset($retweeted_counts['rst'][0]) ? array(
				'comments' => $retweeted_counts['rst'][0]['comments'],
				'rt' => $retweeted_counts['rst'][0]['rt']
			) : array(
				'comments' => 0,
				'rt' => 0
			);
		}
		TPL::assign('wb', $wb);
		$this->_display('wb_repos');
	}
	/**
	 * \brief 举报微博内容
	 */
	
	function reportSpamResult() {


		// check data
		$cid = V('p:cid', FALSE);
		
		if (empty($cid)) {

			//APP::ajaxRst(false, '1', '微博ID不能为空');
			
			//$this->_setBackURL();

			$this->_setBackURL(WAP_URL('show.reportSpam', "id={$cid}"));
			TPL::assign('error', L('controller__show__reportSpamResult__weiboIdNotAllowEmpty'));
		}

		//设置返回页面url cookie
		
		//$this->_setBackURL();

		$content = V('p:content', FALSE);
		
		if (empty($content)) {
			$this->_setBackURL(WAP_URL('show.reportSpam', "id={$cid}"));
			TPL::assign('error', L('controller__show__reportSpamResult__contentNotAllowEmpty'));
		} elseif (strlen(utf8_decode($content)) > 300) {
			$this->_setBackURL(WAP_URL('show.reportSpam', "id={$cid}"));
			TPL::assign('error', L('controller__show__reportSpamResult__lengthTooLong'));
		}

		//获取返回的页面
		$backURL = $this->_getBackURL(false);

		// report to API, 不考虑接口出错问题，认为提交都成功
		
		if (!empty($cid) && !empty($content)) {
			DR('xweibo/xwb.report_spam', '', $content, null, $cid);
		}
		TPL::assign('backURL', $backURL);
		$this->_display('reportResult');
	}
	/**
	 * \brief 举报微博显示页面
	 */
	
	function reportSpam() {

		$id = V('g:id');
		$mblog_info = DR('xweibo/xwb.getStatuseShow', '', $id);
		
		if ($mblog_info['errno'] == 0) {
			TPL::assign('info', $mblog_info['rst']);
			TPL::assign('withid', true);
		} else {
			TPL::assign('withid', false);
		}
		$this->_display('report');
	}
}
?>
