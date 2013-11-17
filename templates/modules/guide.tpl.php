<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL ?>css/default/pub.css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="guide-narrow">
	<div id="wrap">
	<a class="gotop" href="#">
		<span class="gotop-bg">in</span>
		<span class="txt skin-bg"><?php LO('common__template__goTop');?></span>
	</a>
    	<div class="wrap-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
            	<div class="main">
				<?php Xpipe::pagelet('user.guide');?>
				</div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::module('footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
</body>
</html>
