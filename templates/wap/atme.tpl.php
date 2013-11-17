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
<?php TPL::plugin('wap/include/my_preview', '', false); ?>
<?php TPL::plugin('wap/include/msg_common', '', false); ?>
<?php if (!empty($list)): ?>
<?php TPL::plugin('wap/include/feedlist', array('list' => $list), false); ?>
<?php else: ?>
	<div class="f-list">
	<?php if (V('g:page', 1) > 1):?>
	<?php LO('index__atme__endPage');?>
	<?php else: ?>
	<?php LO('index__atme__emptyTip');?>	
	<?php endif; ?>
	</div>
<?php endif; ?>
<?php TPL::plugin('wap/include/pager', array('ctrl' => APP::getRuningRoute(false), 'list' => $list, 'page' => $page), false); ?>
<?php TPL::plugin('wap/include/search', '', false); ?>
<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>
