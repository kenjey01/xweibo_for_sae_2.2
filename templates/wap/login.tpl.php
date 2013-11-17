<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<?php TPL::plugin('wap/include/top_logo', '', false); ?>
<form action="<?php echo WAP_URL('account.doLogin'); ?>" method="post">
<?php LO('account__login__sinaWeibo');?><br/><input type="text" name="account" size="30" value=""/>
<br/>
<?php LO('account__login__password');?><br/><input type="password" name="password" size="30" value=""/><br/>
<input type="hidden" name="backURL" value="<?php echo F('escape', $backURL); ?>" />
<input type="hidden" name="backTitle" value="<?php LO('account__login__weibo');?>" />
<input type="submit" name="submit" value="<?php LO('account__login__loginTitle');?>" /><br/>
</form>
</body>
</html>
