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

<body id="pub">
	<div id="wrap">    	
    	<div class="wrap-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header'); ?>
            <!-- 头部 结束-->
            
            <div id="container" class="single">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav'); ?>
					<!-- 站点导航 结束 -->
				</div>
            	<div class="content">
                    <div class="main-wrap">
                        <div class="main">
                            <div class="main-bd">
                                <!-- 话题排行榜 开始-->
                                <div class="ranking-topic">
									<div class="tab-s2">
										<?php if($base_app): ?>
											<span class="current"><span><?php LO('pubTopic__pub__localTopicTop');?></span></span>
											<span><span><a href="<?php echo URL('pub.topics', array('base_app' => 0)); ?>"><?php LO('pubTopic__pub__weiboTopicTop');?></a></span></span>
										 <?php else: ?>
											 <span><span><a href="<?php echo URL('pub.topics', array('base_app' => 1)); ?>"><?php LO('pubTopic__pub__localTopicTop');?></a></span></span>
											 <span class="current"><span><?php LO('pubTopic__pub__weiboTopicTop');?></span></span>
										<?php endif; ?>
									</div>
                                    <div class="r-t-con">
                                        <div class="r-t-item first-item">
                                            <div class="top10">
												<div class="hd"><?php LO('pubTopic__pub__oneHourTopicTop');?></div>
												<div class="bd">
													<ul>
													<?php
														if (!empty($hours))
														{
															$count = 0;
															foreach ($hours as $row) {
																$count++;
																if($count >= 21){
																	break;
																}
													?>
													   <li>
															<div class="ranking <?php if ($count<4):?>r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
														   <a href="<?php echo URL('search.weibo', array('k' => $row['query'], 'base_app' => $base_app));?>"><?php echo F('escape', $row['name']);?></a>
													   </li>
														<?php
															}
														}
													?>
													</ul>
												</div>
                                            </div>
                                        </div>
                                        <div class="r-t-item">
                                            <div class="top10">
												<div class="hd"><?php LO('pubTopic__pub__todayTopicTop');?></div>
												<div class="bd">
													<ul>
													<?php
														if (!empty($days))
														{
															$count = 0;
															foreach ($days as $row) {
																$count++;
																if($count >= 21){
																	break;
																}
													?>
														<li>
														<div class="ranking <?php if ($count<4):?>r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
													  <a href="<?php echo URL('search.weibo', array('k' => $row['query'], 'base_app' => $base_app));?>"><?php echo F('escape', $row['name']);?></a>
													</li>
													<?php
															}
														}
													?>
													</ul>
												</div>
											</div>
                                        </div>
                                        <div class="r-t-item last-item">
                                            <div class="top10">
												<div class="hd"><?php LO('pubTopic__pub__weekTopicTop');?></div>
												<div class="bd">
													<ul>
													<?php
														if (!empty($weeks))
														{
															$count = 0;
															foreach ($weeks as $row) {
																$count++;
																if($count >= 21){
																	break;
																}
													?>
													<li>
															<div class="ranking <?php if ($count<4):?>r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
														   <a href="<?php echo URL('search.weibo', array('k' => $row['query'], 'base_app' => $base_app));?>"><?php echo F('escape', $row['name']);?></a>
													   </li>
													<?php
															}
														}
													?>
													</ul>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 话题排行榜 结束-->
                            </div>
                        </div>
                    </div>
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
