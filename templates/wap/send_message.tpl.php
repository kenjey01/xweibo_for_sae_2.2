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
&nbsp;<?php echo $backLink; ?>
<div class="send">
	<form method="post" action="<?php echo WAP_URL('wbcom.sendMsg'); ?>">
		<?php if ($rid): ?>
		<input type="hidden" name="rid" value="<?php echo $rid; ?>" />
		<input type="hidden" name="nick" value="<?php echo F('escape', $rname, ENT_QUOTES); ?>" />
		<span><?php LO('wbcom__sendMsgFrm__label_messageLimitTips', F('escape', $rname, ENT_QUOTES));?></span><br />
		<?php else: ?>
		<span><?php LO('wbcom__sendMsgFrm__label_fansTips');?></span><br /><input type="text" name="nick" /><br /><span><?php LO('wbcom__sendMsgFrm__label_messageLimitTips_ND');?></span><br />
		<?php endif; ?>
		<textarea name="content" rows="5" cols="10"></textarea>
		<div><input type="submit" value="<?php LO('wbcom__sendMsgFrm__btnSend');?>" /></div>
	</form>
</div>
<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>