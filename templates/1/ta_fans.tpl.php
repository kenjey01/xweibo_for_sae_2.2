<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', F('escape', $userinfo['screen_name']));?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body>
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
			<!-- 头部 结束-->
			<div id="container">
				<div class="content">
					<div class="main">
						<?php Xpipe::pagelet('user.userHead', $userinfo ); ?>
						<div class="title-box">
									<h3><?php echo F('escape',$userinfo['screen_name']);?><?php LO('ta__fans_taFans');?>（<?php echo $userinfo['followers_count'];?>）</h3>
						</div>
						<?php Xpipe::pagelet('user.fansList', $userinfo ); ?>
					</div>
				</div>
				<div class="aside">
					<!-- 用户信息 开始-->
					<?php Xpipe::pagelet('common.userTotal', $userinfo ); ?>
					<!-- 用户信息 结束-->
					<!-- 标签 -->
					<?php Xpipe::pagelet('common.userTag', $userinfo);?>
					<!-- end 标签 -->
					<?php Xpipe::pagelet('common.magicFriends', $userinfo ); ?>
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

