<?php
include(P_ADMIN_MODULES . '/action.abs.php');

class notice_mod extends action
{
	function notice_mod()
	{
		parent :: action();
	}
	
	function default_action()
	{
		$this->showList();
	}
	
	/**
	* 通知管理列表
	* 
	*/
	function showList()
	{
		$page = (int)V('g:page', 1);
		$limit = 15;
		$offset = ($page - 1) * $limit;
		
		$count = DS('notice.getNoticeNum', '', 0, true);
		$noticeList = DS('notice.getNoticeList', '', 0, $offset, $limit, true);
		
		$pager = APP::N('pager');
		$pager->initParam($count);
		TPL :: assign('pager', $pager->makePage());
		
		TPL::assign('offset', $offset);
		TPL::assign('list', $noticeList);
		$this->_display('notice_list');
	}
	
	/**
	* 发布通知
	* 
	*/
	function saveNotice()
	{
		$title = trim(V('p:title', ''));
		$content = trim(V('p:content', ''));
		$recipient_type = (int)V('p:recipient_type', 1);
		$recipients = trim(V('p:recipients', ''));
		
		if ($title === '' || $content === '') {
			$this->_error('通知标题和内容不能为空', array('showList'));
		}
		
		if ($recipient_type === 2 && $recipients === '') {
			$this->_error('请输入接收用户的昵称', array('showList'));
		}
		
		if ($recipient_type === 2) {
			$recipent_id = null;
			$recipients = preg_split('/((\r(?!\n))|((?<!\r)\n)|(\r\n))/', $recipients, -1, PREG_SPLIT_NO_EMPTY);
		} else {
			$recipent_id = 0;
			$recipients = null;
		}
		
		$sendResult = DR('notice.sendNotice', '', $title, $content, $recipent_id, $recipients, USER::uid(), APP_LOCAL_TIMESTAMP);
		if (!empty($sendResult['errno'])) {
			$this->_error($sendResult['err'], array('showList'));
		}
		
		$this->_succ('通知发布成功', array('showList'));
	}
	
	/**
	* 删除通知信息
	* 
	*/
	function delNotice()
	{
		$notice_id = (int)V('g:notice_id', 0);
		if (empty($notice_id)) {
			$this->_error('请选择所要删除的通知', array('showList'));
		}
		
		$delResult = DR('notice.deleteNotice', '', $notice_id);
		if (!empty($delResult['errno'])) {
			$this->_error($delResult['err'], array('showList'));
		}
		
		$this->_succ('删除成功', array('showList'));
	}
	
	/**
	* 获取接收用户列表
	* 
	*/
	function getRecipients()
	{
		$notice_id = (int)V('r:notice_id', 0);
		if (empty($notice_id)) {
			APP::ajaxRst(false, 1010000, 'Parameter can not be empty');
		}
		
		$recipients = DR('notice.getRecipientsByNoticeId', '', $notice_id);
		if (!empty($recipients['errno'])) {
			APP::ajaxRst(false, $recipients['errno'], $recipients['err']);
		}
		
		$recipients = $recipients['rst'];
		$html = '';
		foreach ($recipients as $recipient) {
			if (!empty($recipient['recipient_id'])) {
				$html .= $recipient['nickname'] . ', ';
			} else {
				$html = '全站用户';
				break;
			}
		}
		
		echo rtrim($html, ', ');
	}
}