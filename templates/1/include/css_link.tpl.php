<?php 
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<link rel="shortcut icon" href="<?php echo W_BASE_URL ?>favicon.ico">
<link href="<?php echo W_BASE_URL ?>css/default/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL ?>css/default/tpl_1.css" rel="stylesheet" type="text/css" />
<?php
if(defined('SKIN_CONSTUM_PATH')||defined('SKIN_PREIVEW')):
?>
<!-- 自定义皮肤 -->
<?php
if(defined('SKIN_PREIVEW')):
?>
<link href="<?php echo URL('setting.getSkin','preview='.SKIN_PREIVEW);?>" rel="stylesheet" type="text/css" />
<?php
else:
?>
<link href="<?php echo SKIN_CONSTUM_PATH;?>" rel="stylesheet" type="text/css" id='custom_css'/>
<?php
endif;
?>

<?php
elseif(defined('SKIN_CONSTUM_DIR')):
?>
<!-- 皮肤目录 -->

<?php if (WB_LANG_TYPE_CSS):?>
<link href="<?php echo W_BASE_URL ?>css/default/<?php echo SKIN_CONSTUM_DIR;?>/skin_<?php echo WB_LANG_TYPE_CSS;?>.css" rel="stylesheet" type="text/css" />
<?php else:?>
<link href="<?php echo W_BASE_URL ?>css/default/<?php echo SKIN_CONSTUM_DIR;?>/skin.css" rel="stylesheet" type="text/css" />
<?php endif;?>


<?php
else:
?>
<!-- 默认皮肤-->

<?php if (!WB_LANG_TYPE_CSS):?>
<link href="<?php echo W_BASE_URL ?>css/default/skin_default/skin.css" rel="stylesheet" type="text/css" />
<?php endif;?>


<?php
endif;
?>
<?php if (WB_LANG_TYPE_CSS):?>
<link href="<?php echo W_BASE_URL ?>css/default/language/<?php echo WB_LANG_TYPE_CSS;?>.css" rel="stylesheet" type="text/css" />
<?php endif;?>
