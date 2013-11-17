<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<link href="<?php echo W_BASE_URL ?>css/default/pub.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="search">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
			<!-- 头部 结束-->
			<div id="container">
				<div class="content">
					<div class="main">
						<!-- 搜索 开始 -->
						<?php TPL::module('mod_search');?>
						<!-- 搜索 结束 -->
						<!-- 你可能感兴趣的人 开始 -->
	                    <?php Xpipe::pagelet('user.interestUsers'); ?>
	                    <!-- 你可能感兴趣的人 结束 -->
	                </div>
				</div>
				<div class="aside">
					<?php Xpipe::pagelet('common.sideComponents', array('type'=>1) );?>
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
