<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="scroll-hide">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理中心</title>
<link type="text/css" rel="stylesheet" href="<?php echo W_BASE_URL;?>css/admin/admin.css" media="screen" />
</head>
<body>
<div class="path" id="path">
	<?php
	//var_dump($_SERVER['REQUEST_URI']);
	?>
	<p><span><?php LO('modules__pageLink__pos');?></span>
				<?php
				if(isset($link)):
				?>
				<a target='mainframe' href="<?php echo $link[0]['url']?>"><?php echo $link[0]['title']?></a>&gt;
				<span><?php echo $link[2]['title']?></span>
				<?php
				endif;
				?>
			</p>
</div>
</body>
