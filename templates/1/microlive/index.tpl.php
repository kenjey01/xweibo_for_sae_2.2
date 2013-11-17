<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
<script src="<?php echo W_BASE_URL;?>js/mod/bufferedweibolist.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mod/interview.js"></script>
</head>
<body id="live-index">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 结束-->
            <div id="container">
            	<div class="content">
                	<div class="main">
	                	<div class="live-banner">
						<img src="<?php echo $banner_img;?>" alt="" />
	               	 	</div>
						<div class="tit-hd">
						<h3><?php LO('modules_microlive_news_live_list_title');?></h3>
						</div>
						<?php Xpipe::pagelet('live.liveIndexList');?>
					</div>
				</div>
				<div class="aside">
					<!-- 用户信息 开始-->
                    <?php Xpipe::pagelet('common.userPreview');?>
                    <!-- 用户信息 结束-->
                    
                    <!-- 推广区 开始-->
                    <?php //include '../module/publicity.html' ?>
                    <!-- 推广区 结束-->
					<!-- 在线主持人列表 -->
					<?php Xpipe::pagelet('live.liveBaseMaster', array('info' => $liveInfo));?>
					<!-- end -->
					<!-- 在线直播基本信息 -->
					<?php Xpipe::pagelet('live.liveBaseInfo', array('info' => $liveInfo));?>
					<!-- end -->
				</div>
			</div>
			<!-- 尾部 开始 -->
			<?php TPL::module('footer');?>
			<!-- 尾部 结束 -->
		</div>
	</div>
    
	<!-- 返回顶部 开始-->
	<?php TPL::module('gotop');?>
	<!-- 返回顶部 结束-->

	<!-- 所有浮层弹出窗口 开始-->
	<?php //include '../module/win_pop.html' ?>
	<!-- 所有浮层弹出窗口 结束-->
    
</body>
</html>
