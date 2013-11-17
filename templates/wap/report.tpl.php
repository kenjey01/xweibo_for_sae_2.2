<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php
	TPL::plugin('wap/include/top_logo','',false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	?>
	<?php
	if($withid):
	?>
	
	<div class='c'>
		<div><?php LO('show__reportSpam__label_reportUser');?><?php echo $info['user']['screen_name']?></div>
		<div><?php LO('show__reportSpam__label_reportReason');?></div>
		<form method="post" action="<?php echo WAP_URL('show.reportSpamResult')?>">
		<input type="hidden" name="cid" value="<?php echo $info['id']?>"/>
		<textarea id="content" name="content" rows="5" cols="10"></textarea>
		<div><input type="submit" value="<?php LO('show__reportSpam__btnSubmit');?>" /></div>
		</form>
	</div>
	<div class='c'>
		<div>
			<?php LO('show__reportSpam__label_reportContent');?><br />
			<?php
			echo $info['text'];
			?>
		</div>
		
	<?php
	else:
	?>
	<div><?php LO('show__reportSpam__label_notice');?></div>
	<?php
	endif;
	?>
	<br/>
		<div>
			<?php LO('show__reportSpam__label_tips');?>
		</div>
	</div>
		<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot',"",false);
	?>
</body>
</html>
