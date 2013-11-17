<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title','','错误提示');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="error">
	<div id="wrap">
    	<div class="wrap-in">
            <!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php TPL::plugin('include/site_nav');?>
					<!-- 站点导航 结束 -->
				</div>
                <div class="content">
                	<div class="main-wrap">
                        <div class="main">
                            <div class="main-bd">
                                <div class="error-box">
                                    <div class="error-rest-bg">
                                        <div class="error-rest-con">
                                            <p>服务器也是人，让他休息下吧</p>
                                            <p><a href="javascript:window.location.reload()">再刷新看看</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 底部 开始-->
			<?php TPL::module('footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
</body>
</html>
