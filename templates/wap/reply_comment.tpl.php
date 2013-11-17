<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<?php TPL::plugin('wap/include/top_logo', '', false); ?>
<?php TPL::plugin('wap/include/nav', array('is_top' => true), false); ?>
&nbsp;<a href="<?php echo $backURL; ?>"><?php LO('wbcom__replyComment__goBack');?></a>
<div class="send">
	<form method="post" action="<?php echo WAP_URL('wbcom.sendReplyComment'); ?>">
		<input type="hidden" name="mid" value="<?php echo $mid; ?>" />
		<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
		<input type="hidden" name="reply_user" value="<?php echo F('escape', $reply_user); ?>" />
		<span><?php LO('wbcom__replyComment__label_replyTips', F('escape', $reply_user));?></span><br />
		<textarea id="content" name="content" rows="5" cols="10"></textarea>
		<div><input type="submit" value="<?php LO('wbcom__replyComment__btnReply');?>" /> <input type="submit" value="<?php LO('wbcom__replyComment__btnReplyAndRepost');?>" name="rt" /></div>
	</form>
</div>
<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>