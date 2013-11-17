<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title','','错误提示');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="inhibit">
	<div id="wrap">  
    	<div class="wrap-in">  	
            <!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
            	<div class="content">
                    <div class="main">
                        <div class="main-bd">
                            <div class="inhibit">
                                    <div class="inhibit-icon"></div>
                                    <div class="inhibit-txt">
                            
										<p><strong><?php echo implode(',', $msg);?></strong></p>
                            
										<p><?php if (V('s:HTTP_REFERER')){ ?><a href="<?php echo V('s:HTTP_REFERER')?>">返回上一页</a><?php }?> <a href="<?php echo URL('index')?>">回到首页</a></p>
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
