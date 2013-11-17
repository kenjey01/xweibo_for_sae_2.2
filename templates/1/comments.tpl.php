<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="comments" class="own">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
			<!-- 头部 结束-->
			<div id="container">
				<div class="content">
					<div class="main">
						<div class="comment-list">
							<div class="tab-s2">
								<span class="current"><span><a href="javascript:void(0)"><?php LO('index__comment__comments');?></a></span></span>
								<span><span><a href="<?php echo URL('index.commentsend');?>"><?php LO('index__comment__commentsend');?></a></span></span>
							</div>
							<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/mod/mycomments.js"></script>
							<?php Xpipe::pagelet('weibo.comments', array('type'=>'to'));?>
						</div>	
					</div>
				</div>
				<div class="aside">
					<!-- 用户信息 开始-->
					<?php Xpipe::pagelet('common.userPreview');?>
					<?php Xpipe::pagelet('common.userMenu');?>
					<!-- 用户标签 开始-->
					<?php Xpipe::pagelet('common.userTag');?>
					<?php Xpipe::pagelet('common.sideComponents', array('type'=>2) );?>
						<?php echo F('show_ad', 'sidebar', '');?>
				</div>
			</div>
			<!-- 底部 开始-->
            <?php TPL::module('footer');?>
			<!-- 底部 结束-->
		</div>
	</div>
	<?php TPL::module('gotop');?>
</body>
</html>
