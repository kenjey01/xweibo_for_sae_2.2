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
	<div class="row">
		<?php
		//var_dump($type);
		$type=V('g:type',false);
		
		if(!isset($type)||$type==1||!$type):
		?>
		<span><?php LO('pub__topics__label_lately');?></span>&nbsp;
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('pub.topics', "type=1");?>"><?php LO('pub__topics__label_lately');?></a>&nbsp;
		<?php
		endif;
		?>
		
		<?php
		if($type==2):
		?>
		<span><?php LO('pub__topics__label_today');?></span>&nbsp;
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('pub.topics', "type=2");?>"><?php LO('pub__topics__label_today');?></a>&nbsp;
		<?php
		endif;
		?>
		
		<?php
		if($type==3):
		?>
		<span><?php LO('pub__topics__label_thisWeek');?></span>&nbsp;
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('pub.topics', "type=3");?>"><?php LO('pub__topics__label_thisWeek');?></a>
		<?php
		endif;
		?>
		
		
		
		
	</div>
    <ul class="t-l">
	<?php
	if(empty($data)) {
		echo "<li><a href=".WAP_URL('pub.topics', "type=".V('g:type',1)).">".L('pub__topics__label_noFoundData')."</a></li>";
	}
	$index=1+($page-1)*$limit;
	foreach($data as $d):
	?>
	<li><a href="<?php echo WAP_URL('search',"k=".urlencode($d['name']))?>"><?php echo ($index++).".".$d['name']?></a></li>
	<?php
	endforeach;
	?>
	
	
    </ul>
	<div class="pages">
		<?php
		TPL::plugin('wap/include/pager', array('ctrl' => V('g:m'), 'list' => $data, 'page' => V('g:page',1)), false); 
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
