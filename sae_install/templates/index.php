<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_LANG['welcome_title'];?></title>
<link rel="stylesheet" media="screen"  href="css/base.css"/>
</head>

<body>
	<div id="wrap">
		<!-- header -->
        <?php include_once 'templates/header.php';?>
		<!-- end header -->
		<div id="main">
			<div class="content-box">
				<div class="ct-top"></div>
				<div class="ct-mid">
					<?php include_once 'templates/'.$install_lang.'_license.php';?>
					<div class="btn-area mt20">
						<a href="index.php?step=1" class="btn-agree all-bg"></a>
						<p><?php echo $_LANG['i_agree'];?></p>
					</div>
				</div>
				<div class="ct-bot"></div>
			</div>
		</div>
	</div>
</body>
</html>
