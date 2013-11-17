<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>服务器繁忙 - Powered By X微博</title>
<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/default/error.css" type="text/css" />
</head>
<body id="error">
	<div id="wrap">
    	<div class="error err-busy">
        	<div class="error-con">
            	<h3>错误提示</h3>
            	<p class="b"><?php echo implode('<br />', $msg);?></p>
                <p class="b">请稍候再试</p>
				<p><a href="<?php echo URL('index');?>">返回首页</a></p>
            </div>
        </div>
    </div>
</body>
</html>
