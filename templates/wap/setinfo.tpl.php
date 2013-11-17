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
	<div class="row"><?php if (HAS_DIRECT_UPDATE_PROFILE):?><span><?php LO('index__setinfo__label_modifyInfo');?></span>&nbsp;<?php endif;?><a href="<?php echo WAP_URL('index.setinfo', 'type=2'); ?>"><?php LO('index__setinfo__label_display');?></a></div>
    <form method="post" action="<?php echo WAP_URL('wbcom.saveInfo'); ?>">
	    <div class="c"><span class="r">*</span><?php LO('index__setinfo__label_nickname');?><input type="text" name="nick" value="<?php echo F('escape', $uInfo['screen_name'], ENT_QUOTES); ?>" /></div>
	    <div class="c"><span class="r">*</span><?php LO('index__setinfo__label_gender');?><input type="radio" name="gender" value="m" <?php echo (!isset($uInfo['gender']) || $uInfo['gender'] != 'f') ? 'checked="checked"' : ''; ?> /><?php LO('index__setinfo__label_genderMale');?>&nbsp;<input type="radio" name="gender" value="f" <?php echo (isset($uInfo['gender']) && $uInfo['gender'] == 'f') ? 'checked="checked"' : ''; ?> /><?php LO('index__setinfo__label_genderFemale');?></div>
	    <div class="c"><?php LO('index__setinfo__label_Description');?><br /><textarea rows="2" name="description"><?php echo F('escape', $uInfo['description'], ENT_QUOTES); ?></textarea><br /><input type="submit" value="<?php LO('index__setinfo__btnSave');?>" /></div>
    </form>
	<?php
	TPL::plugin('wap/include/search', '', false);
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot', '', false);
	?>
</body>
</html>
