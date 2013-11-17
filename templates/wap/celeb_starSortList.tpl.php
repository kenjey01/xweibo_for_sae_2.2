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
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	?>
	<div class="row">
	<a href="<?php echo V('s:PHP_SELF','wap.php')."?m=celeb"?>"><?php LO('celeb__celebStarSortList__industry');?></a>
		-<?php echo strip_tags($title);?>
	</div>
   
   
       <?php
       TPL::plugin('wap/include/friendList',array('list'=>$list),false);
       ?>
   
   
   
	<div class="pages">
		<?php
		TPL::plugin('wap/include/pager', array('ctrl' => V('g:m'), 'list' => $list, 'page' => V('g:page',1)), false); 
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
