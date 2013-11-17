<?php 
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
<link href="<?php echo W_BASE_URL;?>css/default/pub.css" rel="stylesheet" type="text/css" />
</head>
<body id="custom">
	<div id="wrap">
	<div class="wrap-in">
	<!-- 头部 开始-->
	<?php TPL::plugin('include/header'); ?>
	<!-- 头部 结束-->
	<div id="container">
		<div class="content">
			<div class="main">
			<?php
			if (isset($main_modules) && is_array($main_modules)) {
				foreach ($main_modules as $key => $mod) {
					Xpipe::pagelet('component/component_'. $mod['component_id']. '.run', $mod );
					//广告
					if ($mod['component_id'] == 10) {
						echo F('show_ad', 'today_topic', 'xad-box xad-box-p2');
					}
				}
			}
			?>
			</div>
		</div>
		<div class="aside">
		<!-- 用户信息 开始-->
		<?php Xpipe::pagelet('user.userPreview');?>
		<!-- 用户信息 结束-->

		<?php
		if (isset($side_modules) && is_array($side_modules)) {
			foreach ($side_modules as $key => $mod) {
				Xpipe::pagelet('component/component_'. $mod['component_id']. '.run', $mod );
			}
		}
		?>
						<?php echo F('show_ad', 'sidebar', '');?>
		</div>
	</div>
	<!-- 尾部 开始 -->
	<?php TPL::module('footer');?>
	<!-- 尾部 结束 -->
	</div>
</div>
<?php TPL::module('gotop');?>
</body>
</html>
