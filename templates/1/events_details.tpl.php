<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', F('escape', $info['title']));?></title>
<?php TPL::plugin('include/css_link');?>
<link href="<?php echo W_BASE_URL ?>css/default/pub.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="events">
	<div id="wrap">
		<div class="wrap-in">
			<?php TPL::plugin('include/header');?>
			<div id="container">
				<div class="content">
						<div class="main">
                                <div class="title-box">
								<h3><a class="goback" href="<?php echo URL('event');?>"><?php LO('events__common__back');?>&gt;&gt;</a><?php echo F('escape', $info['title']);?></h2>
                                </div>
                                <div class="event-box">
								<?php Xpipe::pagelet('event.eventinfo', array('info' => $info));?>
								<?php Xpipe::pagelet('event.eventinput', array('info' => $info));?>
								<?php Xpipe::pagelet('event.eventcomment', array('info' => $info));?>
                           	    </div>
						</div>
					</div>
				<div class="aside">
					<!--最新活动 开始-->
						<?php Xpipe::pagelet('event.sideNewsEvents');?>
					<!--最新活动 结束-->
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
