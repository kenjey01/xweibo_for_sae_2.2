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
			<?php TPL::plugin('include/header');?>
			<div id="container">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav'); ?>
					<!-- 站点导航 结束 -->
				</div>
				<div class="content">
					<div class="main-wrap">
						<div class="main">
                        	<div class="main-bd">
                                <!-- 搜索 开始 -->
								<?php Xpipe::pagelet('common.searchMod'); ?>
                                <!-- 搜索 结束 -->
								<div class="tab-box">
									<div class="tab-s2">
									<span <?php echo V('r:base_app', '0') == 0 ? 'class="current"' : ''; ?>><span><a href="<?php echo URL('search.user', array('k' => V('r:k', ''), 'ut' => V('r:ut', 'nick'), 'base_app' => 0)); ?>"><?php LO('search__user__fromSina');?></a></span></span>
									<span <?php echo V('r:base_app', '0') == 1 ? 'class="current"' : ''; ?>><span><a href="<?php echo URL('search.user', array('k' => V('r:k', ''), 'ut' => V('r:ut', 'nick'), 'base_app' => 1)); ?>"><?php LO('search__user__local');?></a></span></span>
									</div>
                                </div>
                                <!--<div class="title-info hidden">
                                    <p>用户<strong>0</strong>位</p>
                                </div>-->
                                <!-- 用户列表 开始-->
                                <?php if (!isset($data) || !is_array($data) || empty($data)) {?>
                    <div class="search-result">
                        <div class="icon-alert"></div>
						<p><strong><?php LO('search__user__emptySearch');?></strong></p>
                    </div>
                    <?php } else {?>
                    <!--<div class="title-info">
						<p class="hidden">搜索到用户<strong>302</strong>位</p>
                    </div>-->
                    <!-- 用户列表 开始-->
                    <div class="user-list">
						<?php Xpipe::pagelet('user.userSearchList', $data );?>
                        <!-- 分页 开始-->
                        <?php TPL::module('page', array('extends'=> $extends, 'list'=> isset($data) ? $data : array(), 'limit'=> isset($each_page)? $each_page : 5));?>
                        <!-- 分页 结束-->
                    </div>
                    <!-- 用户列表 结束-->
                    <?php }?>
                                <!-- 用户列表 结束-->
                            </div>
						</div>
						<div class="aside">
							<?php Xpipe::pagelet('common.sideComponents', array('type'=>1) );?>
						<?php echo F('show_ad', 'sidebar', '');?>
						</div>
					</div>
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
