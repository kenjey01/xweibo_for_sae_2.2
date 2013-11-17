<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>404 - Powered By X微博</title>
<link rel="stylesheet" href="<?php echo W_BASE_URL ?>css/default/error.css" type="text/css" />
</head>
<body id="error">
	<div id="wrap">
    	<div class="error err-404">
        	<div class="error-con">
            	<p><?php if(isset($msg)) echo $msg; else echo '抱歉，你访问的页面地址有误，或者该页面不存在';?></p>
                <p>请检查输入的网站是否正确，或者<a href="javascript:history.go(-1);">返回上一页</a></p>
            </div>
        </div>
    </div>
</body>
</html>