<?php 
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', false, L('lookLook__pug__casualLookTitle'));?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
<link href="<?php echo W_BASE_URL; ?>css/default/pub.css" rel="stylesheet" type="text/css" />
</head>

<body id="pub">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header'); ?>
			<!-- 头部 结束-->
			<div id="container">
				<div class="content">
					<div class="main">
						<!-- 随便看看 开始-->
						<div class="pub-feed-list">
    						<div class="title-box">
								<a class="ico-change" href="#"  rel="e:rl"><?php LO('lookLook__pub__change');?></a>
								<h3><?php LO('lookLook__pug__casualLook');?></h3>
    						</div>

    						<?php if(is_array($list['rst']) || !empty($list['rst'])): 
    							Xpipe::pagelet(
    								'weibo.weiboList',
    									array(
    											'list'=>$list['rst'], 
    											'show_page'=>false, 
    											'filter_type'=> null,
												'show_unread_tip' => false,
    											//'show_filter_type' => false,
    											'show_list_title' => false,
    									)
    							);
    						?>
    						<?php elseif($list['errno'] != 0 && defined('IS_DEBUG') && IS_DEBUG): ?>
								<?php LO('lookLook__pug__errorMsg', $list['err'], $list['errno']);?>
    						<?php endif; ?>

						</div>
						<!-- 随便看看 结束-->
					</div>
				</div>
				<div class="aside">
						<!-- 用户信息 开始-->
						<?php Xpipe::pagelet('common.userPreview');?>
						<!-- 用户信息 结束-->
                        <?php
                        if (isset($side_modules) && is_array($side_modules)) {
	                		foreach ($side_modules as $key => $mod) {
	                			Xpipe::pagelet('component/component_'. $mod['component_id']. '.run', $mod );
	             			}
                        }
                        //echo F('show_ad', 'sidebar', 'xad-box xad-box-p3');
                        ?>
						<?php echo F('show_ad', 'sidebar', '');?>
				</div>
			</div>
			<!-- 底部 开始-->
			<?php TPL::module('footer');?>
			<!-- 底部 结束-->
		</div>
	</div>
	<?php TPL::module('gotop');?>
</body>
</html>
