<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title',$content);?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<?php
TPL::plugin('wap/include/top_logo','',false);
TPL::plugin('wap/include/nav', array('is_top' => true), false);
?>

<div class='row'>
		

<?php
TPL::plugin('wap/include/status', array('content'=>$content), false);
?>
</div>
    <div class="s"></div>
    <div class="g row"><?php LO('ta__mention__label_weiboTips', $content);?></div>
    <?php
       TPL::plugin('wap/include/feedlist', array("list"=>$list), false);
    ?>
    <div class="s"></div>
<div class="pages">
<?php
TPL::plugin('wap/include/pager', array('ctrl' => V('g:m'), 'list' => isset($list)?$list:$users, 'page' => V('g:page',1)), false); 
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
