<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', F('escape', $userinfo['screen_name']) );?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="weibo">
	<div id="wrap">
		<div class="wrap-in">
			<?php TPL::plugin('include/header');?>
			<div id="container">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav'); ?>
					<!-- 站点导航 结束 -->
				</div>
				<div class="content">
					<div class="main-wrap">
						<div class="main">
                        	<div class="main-bd">
                                <!-- 用户头部介绍 开始-->
								<?php Xpipe::pagelet('user.userHead', $userinfo ); ?>
                                <!-- 用户头部介绍 结束-->
								<?php Xpipe::pagelet('weibo.userTimelineList', $userinfo ); ?>
                            </div>
						</div>
						<div class="aside">
							<div class="user-preview">
								<?php echo F('verified', $userinfo, 'profile');?>
							</div>
							<!-- 用户关注、粉丝、微博信息总数 开始-->
							<?php Xpipe::pagelet('common.userTotal', $userinfo ); ?>
							<!-- 用户关注、粉丝、微博信息总数 结束-->
							<!-- 推广区 开始-->
							<?php //include '../module/publicity.html' ?>
							<!-- 推广区 结束-->
							<!-- 用户标签 开始-->
							<?php Xpipe::pagelet('common.userTag');?>
							<!-- 用户标签 结束-->
							<!-- 可能感兴趣的人 开始-->
							<?php Xpipe::pagelet('common.sideComponents', array('type'=>4) );?>
							<!-- 可能感兴趣的人 结束-->
						<?php echo F('show_ad', 'sidebar', '');?>
						</div>
					</div>
				</div>
			</div>
			<!-- 尾部 开始 -->
            <?php TPL::module('footer');?>
			<!-- 尾部 结束 -->
		</div>
	</div>
	<?php TPL::module('gotop');?>
</body>
</html>
<!-- report -->
<img src="<?php echo F('report', 'me');?>" class="hidden"/>
