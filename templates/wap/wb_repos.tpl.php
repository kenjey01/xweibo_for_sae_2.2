<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title',isset($wb['user']['screen_name'])?$wb['user']['screen_name']:L('show__repos__lable_ta'));?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php TPL::plugin('wap/include/top_logo', '', false); ?>
	<?php TPL::plugin('wap/include/nav', array('is_top' => true), false); ?>
	<div class="f-list">
		<?php TPL::plugin('wap/include/feed', $wb, false); ?>
	</div>
	<div class="send">
		<form method="post" action="<?php echo WAP_URL('wbcom.reposWB'); ?>">
			<input type="hidden" name="mid" value="<?php echo $wb['id']; ?>" />
			<span><?php LO('show__repos__lable_repostCharLimit');?></span><br />
			<textarea cols="10" name="content"></textarea><br />
			<input type="submit" value="<?php LO('show__repos__lable_repost');?>" />&nbsp;<input type="submit" value="<?php LO('show__repos__lable_commentAndRepost');?>" name="is_com" />
		</form>
	</div>
	<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
	<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>