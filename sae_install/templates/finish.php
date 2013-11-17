<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_LANG['done_title'];?></title>
<link rel="stylesheet" media="screen"  href="css/base.css"/>
</head>

<body>
	<div id="wrap">
		<!-- header -->
        <?php include_once 'templates/header.php';?>
		<!-- end header -->
		<div id="main">
			<div class="content-box">
				<div class="step3 step-bg"></div>
				<div class="ct-mid">
					<div class="title-info">
						<h3 class="lh44"><span class="icon-success all-bg"></span><?php echo $_LANG['xweibo_finish_install'];?></h3>
					</div>
					<ul class="">
						<li>1、<?php echo $_LANG['xweibo_admin_comment'];?></li>
						<li>2、<?php echo $_LANG['xweibo_security_tip'];?></li>
						<li>3、<?php echo $_LANG['xweibo_clear_cache'];?></li>
					</ul>
					<div class="btn-area">
						<a href="<?php echo $admin_url;?>" class="btn-active-admin all-bg"></a>
					</div>
				</div>
				<div class="ct-bot"></div>
			</div>
		</div>
	</div>
</body>
</html>
<img src="http://beacon.x.weibo.com/a.gif?xt=in&akey=<?php echo $site_config['app_key'];?>&name=<?php echo urlencode($site_config['site_name']);?>&content=<?php echo urlencode($site_config['site_info']);?>&uname=<?php echo '';?>&em=<?php echo '';?>&qq=<?php echo '';?>&msn=<?php echo '';?>&tel=<?php echo '';?>&ip=<?php echo get_real_ip();?>&pjt=<?php echo XWEIBO_PROJECT;?>&ver=<?php echo XWEIBO_VERSION;?>&domain=<?php echo urlencode($_SERVER['HTTP_HOST']);?>&random=<?php echo mt_rand();?>" style="display:none" />
