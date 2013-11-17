<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php
	TPL::plugin('wap/include/top_logo', '', false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	?>
    <div class="c"><a class="back" href="<?php echo $backURL; ?>"><?php LO('wbcom__viewPhoto__label_goBack');?></a></div>
    <div class="c"><img src="<?php echo $image; ?>" alt="<?php LO('wbcom__viewPhoto__label_viewImage');?>" /></div>
    <div class="c"><?php if ($vp): ?><?php LO('wbcom__viewPhoto__label_originalImage');?><?php else: ?><a href="<?php echo WAP_URL('wbcom.viewPhoto', 'id=' . $id . '&v=1'); ?>"><?php LO('wbcom__viewPhoto__label_originalImage');?></a><?php endif; ?>&nbsp;<?php if (!$vp): ?><?php LO('wbcom__viewPhoto__label_thumbnail');?><?php else: ?><a href="<?php echo WAP_URL('wbcom.viewPhoto', 'id=' . $id . '&v=0'); ?>"><?php LO('wbcom__viewPhoto__label_thumbnail');?></a><?php endif; ?></div>
	<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot', '', false);
	?>
</body>
</html>