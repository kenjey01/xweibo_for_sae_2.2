<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<link href="<?php echo W_BASE_URL ?>css/default/pub.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
<script type="text/javascript" src="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick-<?php echo APP::getLang();?>.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL ?>js/mod/eventForm.js"></script>
</head>
<body id="events">
	<div id="wrap">
		<div class="wrap-in">
			<?php TPL::plugin('include/header');?>
			<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick.css" />
			<div id="container">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav');?>
					<!-- 站点导航 结束 -->
				</div>
				<div class="content">
					<div class="main-wrap">
						<div class="main">
						<div class="main-bd">
						<div class="title-box">
						<h3><a class="goback" href="<?php echo URL('event');?>"><?php LO('events__common__back');?>&gt;&gt;</a><?php LO('events__common__create');?></h3>
                                </div>
                                <?php Xpipe::pagelet('event.eventForm');?>
								</div>
                            </div>
						<div class="aside">
							<?php Xpipe::pagelet('event.sideNewsEvents');?>
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
