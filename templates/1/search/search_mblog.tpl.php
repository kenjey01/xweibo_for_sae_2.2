<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<link href="<?php echo W_BASE_URL ?>css/default/pub.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="search">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
			<!-- 头部 结束-->
			<div id="container">
				<div class="content">
					<div class="main">
						<!-- 搜索 开始 -->
						<?php Xpipe::pagelet('common.searchMod'); ?>
						<!-- 搜索 结束 -->
						<div class="tab-box">
							<div class="tab-s2">
								<span <?php echo V('r:base_app', '0') == 0 ? 'class="current"' : ''; ?>><span><a href="<?php echo URL('search.weibo', array('k' => V('r:k', ''), 'base_app' => 0)); ?>"><?php LO('search__weibo__fromSina');?></a></span></span>
								<span <?php echo V('r:base_app', '0') == 1 ? 'class="current"' : ''; ?>><span><a href="<?php echo URL('search.weibo', array('k' => V('r:k', ''), 'base_app' => 1)); ?>"><?php LO('search__weibo__local');?></a></span></span>
							</div>
						</div>
						<div class="title-info">
									<p class="sort">
							<a href="<?php echo URL('search.weibo','k=' . urlencode(V('r:k','')).'&base_app=' . V('r:base_app','') . '&filter_pic=0');?>" <?php if(!V('r:filter_pic')) {?>class="current"<?php }?>><?php LO('search__weibo__seeAll');?></a> |
							<a href="<?php echo URL('search.weibo','k=' . urlencode(V('r:k','')).'&base_app=' . V('r:base_app','') . '&filter_pic=2');?>" <?php if(V('r:filter_pic') == 2) {?>class="current"<?php }?>><?php LO('search__weibo__text');?></a> |
							<a href="<?php echo URL('search.weibo','k=' . urlencode(V('r:k','')).'&base_app=' . V('r:base_app','') . '&filter_pic=1');?>" <?php if(V('r:filter_pic') == 1) {?>class="current"<?php }?>><?php LO('search__weibo__pic');?></a>

							<!--
							| <a href="<?php //echo URL('search.weibo','k=' . urlencode(V('r:k','')).'&base_app=' . V('r:base_app','') . '&filter_pic=1');?>"><?php //LO('search__weibo__video');?></a>
							-->
                        </p>
									<p><?php LO('search__weibo__title');?></p>
                                </div>
						<!-- 微博列表 开始-->
						<?php if (!isset($list) || empty($list)) {?>
                    <div class="search-result">
                        <div class="icon-alert"></div>
						<p><strong><?php LO('search__weibo__emptySearch');?></strong></p>
                    </div>
                    <?php } else {?>
                    <!-- 微博列表 开始-->
                    <div class="feed-list">
					<?php Xpipe::pagelet('weibo.weiboOnly', array('list'=>$list)); ?>
                    <?php TPL::module('page', array('extends'=> $extends, 'list'=> isset($list) ? $list : array(), 'limit'=> isset($each_page)? $each_page : 5));?>
                    </div>
                    <?php }?>
						<!-- 微博列表 结束-->
					</div>
				</div>
				<div class="aside">
					<?php Xpipe::pagelet('common.sideComponents', array('type'=>1) );?>
					<!-- 关注的话题 -->
							<?php Xpipe::pagelet('common.subjectFollowed',USER::uid()); ?>
					<!-- 关注的话题 -->	
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
