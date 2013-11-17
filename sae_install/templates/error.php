<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_LANG['message_title'];?></title>
<link rel="stylesheet" media="screen"  href="css/base.css"/>
</head>

<body>
	<div id="wrap">
		<!-- header -->
        <?php //include_once 'templates/header.php';?>
		<!-- end header -->
		<div id="main">
		<div id="main">
			<div class="content-box">
				<div class="step4 step-bg"></div>
				<div class="ct-mid">
					<div class="title-info">
						<h3 class="lh44"><span class="icon-error all-bg"><?php echo $_LANG['error_message'];?></span></h3>
					</div>
					<div class="txt-con">
					<p><strong><?php echo $msg;?></strong></p>
					<?php if ($type ==2):?>
					<p><a href="/"><?php echo $_LANG['message_return'];?></a></p>
					<?php else:?>
					<p><a href="<?php echo empty($url) ? 'javascript:history.back();' : $url;?>"><?php echo $_LANG['message_return'];?></a></p>
					<?php endif;?>
					</div>
				</div>
				<div class="ct-bot"></div>
			</div>
		</div>
	</div>
</body>
</html>
