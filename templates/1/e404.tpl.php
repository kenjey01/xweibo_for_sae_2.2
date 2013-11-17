<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title','','错误提示');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="error">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
                <div class="main">
                    <div class="error-box">
                        <div class="error-404-bg">
                            <div class="error-404-con">
                                <p>抱歉，您访问的页面地址有误，或者该页面不存在</p>
                                <p>请检查输入的网站是否正确，或者<a href="javascript:history.go(-1);">返回上一页</a></p>
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
