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
<body id="talk-index">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 结束-->
			<div id="container">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav');?>
					<!-- 站点导航 结束 -->
				</div>
				
				<div class="content">
					<div class="main-wrap">
                        <div class="main">
                            <div class="main-bd">
							<div class="talk-banner"><img src="<?php echo $banner_img;?>" alt="" /></div>
                            <?php Xpipe::pagelet('interview.index_list');?>
                            </div>
                        </div>
						<div class="aside">
							<!-- 用户信息 开始-->
							<?php Xpipe::pagelet('common.userPreview');?>
							<!-- 用户信息 结束-->
							
							<!-- 在线主持人 开始-->
							<?php Xpipe::pagelet('interview.baseMasterList', array( 'masterList'=>$userlist, 'friendList'=>$friendList ) );?>
							<!-- 在线主持人 结束-->
                            
                            <!-- 关于在线直播 开始-->
							<?php TPL::module('interview/about_live', array( 'about' => isset($config['desc'])?$config['desc']:'' ) ); ?>
							<!-- 关于在线直播 结束-->
                            
                            <!-- 联系方式 开始-->
							<?php TPL::module('interview/live_contact', array('contact'=>isset($config['contact'])?$config['contact']:'' )); ?>
							<!-- 联系方式 结束-->
						</div>
					</div>
				</div>
			</div>
			<!-- 尾部 开始 -->
			<?php TPL::module('footer'); ?>
			<!-- 尾部 结束 -->
		</div>
	</div>
    
	<!-- 返回顶部 开始-->
	<?php TPL::module('gotop'); ?>
	<!-- 返回顶部 结束-->
    
</body>
</html>
