<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title',$userinfo['screen_name']);?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<?php
	TPL::plugin('wap/include/top_logo','',false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	?>
<?php
	TPL::plugin('wap/include/ta_header', array("userinfo"=>$userinfo), false);
?>


	<div class="s" ></div>	
	<?php
	//var_dump($status);
	TPL::plugin('wap/include/feedlist', array("list"=>$list), false);
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
