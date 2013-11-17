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
	<div class="row">
		<?php if (HAS_DIRECT_UPDATE_PROFILE):?><a href="<?php echo WAP_URL('index.setinfo', 'type=1'); ?>"><?php LO('index__setdisplay__label_modifyInfo');?></a>&nbsp;<?php endif;?><?php LO('index__setdisplay__label_display');?>
	</div>
	<div class="c">
	<form action="<?php echo WAP_URL('wbcom.saveDisplayset'); ?>" method="post">
		<div><?php LO('index__setdisplay__label_font_size');?></div>
		<div>
			<label><input type="radio" name="wap_font_size" value="1" <?php echo V('-:userConfig/wap_font_size', 1) == '1' ? 'checked="checked"' : ''; ?> /><?php LO('index__setdisplay__label_small');?></label>
			<label><input type="radio" name="wap_font_size" value="2" <?php echo V('-:userConfig/wap_font_size') == '2' ? 'checked="checked"' : ''; ?> /><?php LO('index__setdisplay__label_mid');?></label>
			<label><input type="radio" name="wap_font_size" value="3" <?php echo V('-:userConfig/wap_font_size') == '3' ? 'checked="checked"' : ''; ?> /><?php LO('index__setdisplay__label_big');?></label>
			<label><input type="radio" name="wap_font_size" value="4" <?php echo V('-:userConfig/wap_font_size') == '4' ? 'checked="checked"' : ''; ?> /><?php LO('index__setdisplay__label_superbig');?></label>
		</div>
		<div><?php LO('index__setdisplay__label_weiboImageTips');?></div>
		<div>
			<label><input type="radio" name="wap_show_pic" value="1" <?php echo V('-:userConfig/wap_show_pic', 1) == '1' ? 'checked="checked"' : ''; ?> /><?php LO('index__setdisplay__label_display');?></label>
			<label><input type="radio" name="wap_show_pic" value="0" <?php echo V('-:userConfig/wap_show_pic') == '0' ? 'checked="checked"' : ''; ?> /><?php LO('index__setdisplay__label_hidden');?></label>
		</div>
		<div><?php LO('index__setdisplay__label_indexShowNumTips');?></div>
		<div>
			<label><input type="radio" name="wap_page_wb" value="5" <?php echo V('-:userConfig/wap_page_wb') == '5' ? 'checked="checked"' : ''; ?> />5</label>
			<label><input type="radio" name="wap_page_wb" value="10" <?php echo V('-:userConfig/wap_page_wb', 10) == '10' ? 'checked="checked"' : ''; ?> />10</label>
			<label><input type="radio" name="wap_page_wb" value="20" <?php echo V('-:userConfig/wap_page_wb') == '20' ? 'checked="checked"' : ''; ?> />20</label>
			<label><input type="radio" name="wap_page_wb" value="30" <?php echo V('-:userConfig/wap_page_wb') == '30' ? 'checked="checked"' : ''; ?> />30</label>
			<label><input type="radio" name="wap_page_wb" value="40" <?php echo V('-:userConfig/wap_page_wb') == '40' ? 'checked="checked"' : ''; ?> />40</label>
			<label><input type="radio" name="wap_page_wb" value="50" <?php echo V('-:userConfig/wap_page_wb') == '50' ? 'checked="checked"' : ''; ?> />50</label>
		</div>
		<div><?php LO('index__setdisplay__label_noticeTips');?></div>
		<input type="submit" value="<?php LO('index__setdisplay__btnSave');?>" />
	</form>
	</div>
	<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot', '', false);
	?>
</body>
</html>
