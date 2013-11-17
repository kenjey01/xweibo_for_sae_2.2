<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ($liveInfo['backgroup_color']):?>class="skin<?php echo $liveInfo['backgroup_color'];?>"<?php endif;?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', F('escape', $liveInfo['title']));?></title>
<link href="<?php echo W_BASE_URL ?>css/default/base.css" rel="stylesheet" type="text/css" />
<?php if (WB_LANG_TYPE_CSS):?>
<link href="<?php echo W_BASE_URL ?>css/default/skin_default/skin_<?php echo WB_LANG_TYPE_CSS;?>.css" rel="stylesheet" type="text/css" />
<?php else:?>
<link href="<?php echo W_BASE_URL ?>css/default/skin_default/skin.css" rel="stylesheet" type="text/css" />
<?php endif;?>
<link href="<?php echo W_BASE_URL ?>css/default/app.css" rel="stylesheet" type="text/css" />
<?php if (WB_LANG_TYPE_CSS):?>
<link href="<?php echo W_BASE_URL ?>css/default/language/<?php echo WB_LANG_TYPE_CSS;?>.css" rel="stylesheet" type="text/css" />
<?php endif;?>
<?php TPL::plugin('include/js_link');?>
<script src="<?php echo W_BASE_URL;?>js/mod/bufferedweibolist.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mod/interview.js"></script>
<!-- 自定义样式 -->
<style type="text/css">
<?php if ($liveInfo['custom_color']):?>
	<?php $customs = explode(',', $liveInfo['custom_color']);?>
	html { background-color:<?php echo $customs[0];?>;}
	a,
	a:hover,
	.feed-list .feed-info span a,
	.feed-list .feed-info p a,
	.gotop .txt,
	#footer .ft-con a { color:<?php echo $customs[1];?>;}
<?php endif;?>
.wrap-in { background:url(<?php echo $liveInfo['backgroup_img'];?>) <?php if ($liveInfo['backgroup_style'] == 2):?>no-repeat center top<?php endif;?>;}
</style>
<!-- end -->
</head>
<body id="live-page">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::module('microlive/include/header');?>
			<!-- 头部 结束-->
			<div id="container">
            	<!-- banner 开始-->
            	<div class="banner-cont">
                	<img src="<?php echo $liveInfo['banner_img'];?>" alt="" />
                </div>
                <!-- banner 结束-->
				<div class="content">
					<div class="main">
						<?php if ( !USER::isUserLogin() && ($liveInfo['end_time']>APP_LOCAL_TIMESTAMP) ) {?>
						<div class="not-login-tips">
							<p><?php LO('modules_microlive_live_detail_login_tip');?></p>
							<a href="#" class="btn-login" rel="e:lg"><?php LO('modules_microlive_live_detail_login_tag');?></a>
						</div>
						<?php }?>
						
						<?php if ($liveInfo['end_time'] > APP_LOCAL_TIMESTAMP):?>
						<!-- 微博发布框 开始-->
						<?php Xpipe::pagelet('weibo.input', $input_params); ?>
						<!-- 微博发布框 结束-->
						<?php endif;?>
						
						<!-- 微博列表 开始-->                	
						<?php Xpipe::pagelet('live.liveWblist', array('liveInfo' => $liveInfo)); ?>
						<!-- 微博列表 结束-->

					</div>
				</div>
				<div class="aside">
					<!-- 直播简介视频 开始-->
					<?php Xpipe::pagelet('live.liveDetailsInfo', array('liveInfo' => $liveInfo));?>
					<!-- end-->
					                    
                    <!-- 主持人 , 嘉宾 开始-->
                    <?php Xpipe::pagelet('live.usersList', array('liveInfo' => $liveInfo));?>
                    <!-- end -->
					                    
                    <!-- 直播列表 开始-->
                    <?php Xpipe::pagelet('live.sideNewsLive', array('liveInfo' => $liveInfo));?>
                    <!-- 直播列表 结束-->
				</div>
			</div>
			<!-- 底部 开始-->
			<?php TPL::module('footer');?>
			<!-- 底部 结束-->
		</div>
	</div>

	<!-- 返回顶部 开始-->
	<?php TPL::module('gotop');?>
	<!-- 返回顶部 结束-->
    
	<!-- 所有浮层弹出窗口 开始-->
	<?php //include '../module/win_pop.html' ?>
	<!-- 所有浮层弹出窗口 结束-->

	<!-- 黑色半透明遮罩层 开始-->
	<div class="shade-div hidden "></div>
	<iframe class="shade-div shade-iframe hidden" frameborder="0"></iframe>
	<!-- 黑色半透明遮罩层 开始-->
</body>
</html>
