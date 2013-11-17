<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link type="text/css" rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php
	TPL::plugin('wap/include/top_logo','',false);
	TPL::plugin('wap/include/nav', array('is_top' =>true), false);
	?>
	<div class="row"><?php LO('celeb__default__industry');?></div>
	<div class="c">
		
		<?php
		foreach($sort as $s):
		?>
		<a href="<?php echo WAP_URL('celeb.starSortList',"id=".$s['id'])?>">
		<?php echo strip_tags($s['name'])?>
		</a>&nbsp;
		<?php
		endforeach;
		?>
		
		
	</div>
	<?php
	TPL::plugin('wap/include/search','',false);
	?>
	<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot',"",false);
	?>
	
	
</body>
</html>
