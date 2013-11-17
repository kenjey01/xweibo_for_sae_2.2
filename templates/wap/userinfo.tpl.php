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
	TPL::plugin('wap/include/my_preview', $uInfo, false);
	?>
    <div class="row"><span><?php LO('index__info__label_profile');?></span>&nbsp;<a href="<?php echo WAP_URL('index.setinfo'); ?>"><?php LO('index__info__label_modify');?></a></div>
    <div class="c"><?php echo F('escape', $uInfo['screen_name'], ENT_QUOTES); ?>/<?php echo ($uInfo['gender'] == 'm' || $uInfo['gender'] == '') ? L('index__info__label_genderMale') : L('index__info__label_genderFemale');?>/<?php echo F('escape', $uInfo['location'], ENT_QUOTES);?></div>
    <div class="c"><img src="<?php echo F('profile_image_url', $uInfo['profile_image_url'], 'profile'); ?>" alt="<?php LO('index__info__label_headPic');?>" /></div>
    <div class="c"><?php LO('index__info__label_description');?><?php echo F('escape', $uInfo['description'], ENT_QUOTES); ?></div>
	<?php
	TPL::plugin('wap/include/search', '', false);
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot', '', false);
	?>
</body>
</html>