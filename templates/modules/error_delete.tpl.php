<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php LO('modules__errorDelete__errorTitle');?> - Powered By X微博</title>
<link rel="stylesheet" href="<?php echo W_BASE_URL ?>css/default/error.css" type="text/css" />
</head>
<body id="error">
	<div id="wrap">
    	<div class="error err-busy">
        	<div class="error-con">
            	<h3>&nbsp;</h3>
				<p><?php if(isset($msg)) echo $msg; else LO('modules__errorDelete__errorMsg');?></p>
                <p><!--<a href="javascript:history.go(-1);">返回上一页</a>-->
				<p> <?php LO('modules__errorDelete__errorTip', URL('index'));?></p>
				</p>
            </div>
        </div>
    </div>
</body>
</html>
