<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<div class="s"></div>
<p class='c'><?php echo $msg; ?></p>
<p class='c'><a href="<?php echo $confirmURL; ?>"><?php LO('wbcom__confirm__ok');?></a> <a href="<?php echo $backURL; ?>"><?php LO('wbcom__confirm__cancel');?></a></p>
<div class="s"></div>
</body>
</html>
