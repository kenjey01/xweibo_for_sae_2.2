<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="display">
	<div id="wrap">
    	<div class="wrap-in">
            <!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
            	<div class="content">
                    <div class="main userinfo">
                        <div class="form xform-normal">
                            <!-- 个人设置 开始-->
							<?php TPL::module('user_setting');?>
                            <!-- 个人设置 结束-->
                            <!--显示设置 开始-->
							<?php Xpipe::pagelet('user.displayEdit');?>
                            <!--显示设置 结束-->
                        </div>
                    </div>
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
