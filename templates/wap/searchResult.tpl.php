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
	
	<div class="ta">
    	<form method='post' id='search_box' action="<?php echo WAP_URL('search');?>">
        <div class="g"><?php LO('search__default__label_keyword');?></div>
		<input type="hidden" name='<?php echo WAP_SESSION_NAME;?>' value='<?php echo V('r:'.WAP_SESSION_NAME) ?>'/>
        <input type="text" name='k' value="<?php echo  htmlspecialchars(V('r:k','')) ;?>" /><br />
	    <input type="hidden" name='m' value='search'/>
        <input type="submit" name='search_sina' value="<?php LO('search__default__btnSearchAll');?>"/>
	    <input type="submit" name='search_app' value="<?php LO('search__default__btnSearchLocal');?>" />
        </form>
    </div>
	<?php
	if(V('r:k',null)):
	?>
	<?php
		$m=V('g:m');
	?>
<div class="row">
<?php
	if($m=='search'):
?>
<span><?php LO('search__default__label_all');?></span>&nbsp;
<?php
	else:
?>
<a href="<?php echo WAP_URL('search','k='.V('r:k')."&base_app=".$base_app)?>"><?php LO('search__default__label_all');?></a>&nbsp;
<?php
endif;
?>

<?php
if($m=='search.user'):
?>
<span><?php LO('search__default__label_user');?></span>&nbsp;
<?php
	else:
?>
<a href="<?php echo WAP_URL('search.user','k='.V('r:k')."&base_app=".$base_app)?>"><?php LO('search__default__label_user');?></a>&nbsp;
<?php
endif;
?>

<?php
if($m=='search.weibo'):
?>
<span><?php LO('search__default__label_weibo');?></span>&nbsp;
<?php
	else:
?>
<a href="<?php echo WAP_URL('search.weibo','k='.V('r:k')."&base_app=".$base_app)?>"><?php LO('search__default__label_weibo');?></a>&nbsp;
<?php
endif;
?>
</div>

<?php
if($m=='search'||$m=='search.user'):
?>
   
    <div class="g row"><?php LO('search__default__label_foundUsersTips');?></div>
    <?php
    if(empty($users)) {
	if(V('g:page')>1) {
		echo '<div class="c">'.L('search__default__label_goBack').'</div>';
	}
	else {
		echo '<div class="c">'.L('search__default__label_noFoundUsers').'</div>';	
	}
	
    }
    else {
	TPL::plugin('wap/include/friendList',array('list'=>$users),false); 
    }
       
    ?>

<?php
endif;
?>    
    
<?php
if($m=='search'||$m=='search.weibo'):
?>

    
    <div class="g row"><?php LO('search__default__label_foundWeibosTips');?></div>
    <?php
    if(empty($list)) {
	if(V('g:page')>1) {
		echo '<div class="c"><a href="'.URL('search',"k=".V('g:k')."&&base_app=".V('g:base_app')).'">'.L('search__default__label_goBack').'</a></div>';
		
	}
	else {	
		echo '<div class="c">'.L('search__default__label_noFoundWeibos').'</div>';
	}
    }
    else {
	TPL::plugin('wap/include/feedlist', array("list"=>$list), false);
    }
	
?>
<?php
endif;
?>

<div class="pages">
<?php
TPL::plugin('wap/include/pager', array('ctrl' => V('g:m'),'query'=>array('base_app'=>isset($base_app)?$base_app:0,'k'=>V('r:k')), 'list' => isset($list)?$list:$users, 'page' => V('g:page',1)), false); 
?>
</div>

<?php
endif;
?>

<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot',"",false);
?>

</body>
</html>
