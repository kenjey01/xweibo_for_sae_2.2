<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
<link href="<?php echo W_BASE_URL;?>css/default/pub.css" rel="stylesheet" type="text/css" />
</head>
<body id="guide-wide">
	<div id="wrap">
    	<div class="wrap-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
            	<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav'); ?>
					<!-- 站点导航 结束 -->
				</div>
            	<div class="main">
            	<script type="text/javascript" src="<?php echo W_BASE_URL ?>js/mod/userguide.js"></script>
				<?php Xpipe::pagelet('user.guide');?>
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
