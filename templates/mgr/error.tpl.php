<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo V('-:tpl/title');?>- 首页</title>
<?php if ($timeout):?>
<meta http-equiv='Refresh' content='<?php echo $timeout;?>;URL=<?php echo $location;?>'>
<?php endif;?>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
	<div class="tips_box">
		<div class="tips_c">
			<div class="tips_r">
				<h3 class="error"><?php echo implode('<br />', $msg);?></h3>
				<?php if ($location) {?>
				<p><a href="<?php echo $location;?>">该页面将于<?php echo $timeout;?>秒后中转,如果你的浏览器不支持自动跳转,请点击这里</a></p>
				<?php }?>
			</div>
		</div>
	</div>
</div>
</body>
</html>
