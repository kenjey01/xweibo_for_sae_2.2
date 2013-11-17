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
	
	<div class="send">
		<div><span><?php LO('index__favs__newsTellSomeBody');?></span></div>
		<form method="post" action="<?php echo WAP_URL('wbcom.postWB'); ?>">
			<div>
				<textarea rows="2" name="content"></textarea>
			</div>
			<div>
			<input type="submit" value=" <?php LO('common__template__published');?> " />
			</div>
		</form>
	</div>
	<div class="row">
	<a href="<?php echo WAP_URL('index'); ?>"><?php LO('index__favs__all');?></a> <?php LO('index__favs__favsTitle');?>
	</div>
	<?php if (!empty($list)): ?>
	<?php TPL::plugin('wap/include/feedlist', array('list' => $list), false); ?>
	<?php else: ?>
		<?php if (V('g:page', 1) > 1):?>
		<p><?php LO('index__favs__endPage');?></p>
		<?php else: ?>
		<p><?php LO('index__favs__emptyTip', WAP_URL('index'));?></p>
		<?php endif; ?>
	<?php endif; ?>
	<?php //TPL::plugin('wap/include/pager', array('ctrl' => APP::getRuningRoute(false), 'list' => $list, 'page' => $page), false); ?>
	<?php TPL::plugin('wap/include/search', '', false); ?>
	<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
	<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>
