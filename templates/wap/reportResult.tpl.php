<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta http-equiv="refresh" content="3; url=<?php echo $backURL;?>" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>	<?php
	TPL::plugin('wap/include/top_logo','',false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	?>
	<div class='c'>
		<?php
		if(isset($error)):
		?>
		<?php
		echo $error;
		?>
		
		<?php
		else:
		?>
		<?php LO('show__reportSpamResult__label_commonTips');?>
		<?php
		endif;
		?>
		<?php LO('show__reportSpamResult__label_backTips');?>
		
		
	</div>
	<br/>
		<div class='c'>
			<?php LO('show__reportSpamResult__label_tips');?>
		</div>
	</div>
	<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot',"",false);
	?>
</body>
</html>
