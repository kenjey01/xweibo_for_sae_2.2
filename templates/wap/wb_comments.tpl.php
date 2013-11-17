<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title',isset($wb['user']['screen_name'])?$wb['user']['screen_name']:L('show__default__lable_ta'));?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php TPL::plugin('wap/include/top_logo', '', false); ?>
	<?php TPL::plugin('wap/include/nav', array('is_top' => true), false); ?>
	<div class="f-list">
		<?php TPL::plugin('wap/include/feed', $wb, false); ?>
	</div>
	<div class="send">
		<form method="post" action="<?php echo WAP_URL('wbcom.comment'); ?>">
			<input type="hidden" name="mid" value="<?php echo $wb['id']; ?>" />
			<span><?php LO('show__default__lable_commentCharLimit');?></span><br />
			<textarea id="content" name="content" rows="2"></textarea><br />
			<input type="submit" value="<?php LO('show__default__lable_comment');?>" />&nbsp;<input type="submit" value="<?php LO('show__default__lable_commentAndRepost');?>" name="is_repos" />
		</form>
	</div>
	<?php if (!empty($list)): ?>
	<?php foreach ($list as $comment): ?>
	<?php if (!empty($comment['filter_state']) 
						|| !empty($comment['user']['filter_state']) 
						|| !empty($comment['user']['status']['filter_state']) 
						|| (isset($comment['user']['status']['retweeted_status']) && !empty($comment['user']['status']['retweeted_status']['filter_state'])) 
						|| (isset($comment['user']['status']['retweeted_status']['user']) && !empty($comment['user']['status']['retweeted_status']['user']['filter_state']))
						|| !empty($comment['status']['user']['filter_state'])
						|| (isset($comment['status']['retweeted_status']) && !empty($comment['status']['retweeted_status']['filter_state']))
						|| (isset($comment['status']['retweeted_status']['user']) && !empty($comment['status']['retweeted_status']['user']['filter_state']))): continue; endif; ?>
	<div class="f-list">
		<a href="<?php echo WAP_URL('ta', 'id=' . $comment['user']['id']); ?>"><?php echo F('verified', $comment['user']); ?></a>:<span class="con"><?php echo F('format_text', $comment['text']); ?></span>&nbsp;<a href="<?php echo WAP_URL('wbcom.replyComment', array('mid' => $wb['id'], 'cid' => $comment['id'], 'reply_user' => $comment['user']['screen_name'])); ?>"><?php LO('show__default__lable_reply');?></a>&nbsp;<?php if ($wb['user']['id'] == USER::uid() || $comment['user']['id'] == USER::uid()): ?><a href="<?php echo WAP_URL('wbcom.delCommentAlert', 'cid=' . $comment['id']); ?>"><?php LO('show__default__lable_delete');?></a>&nbsp;<?php endif; ?><span class="g"><?php echo F('format_time', $comment['created_at']); ?></span>
	</div>
	<?php endforeach; ?>
	<?php else: ?>
		<div class="f-list">
		<?php if (V('g:page', 1) > 1):?>
		<?php LO('show__default__lable_lastPage');?>
		<?php else: ?>
		<?php LO('show__default__lable_noFoundData');?>
		<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php TPL::plugin('wap/include/pager', array('ctrl' => 'show', 'list' => $list, 'page' => $page), false); ?>
	<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
	<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>
