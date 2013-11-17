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
                            	<div class="talk-banner"><img src="<?php echo (isset($config['banner_img'])?$config['banner_img']:W_BASE_URL.'img/talk_bg.jpg'); ?>" alt="" /></div>
                            	<!-- 精彩访谈 开始-->
                                <div class="tit-hd">
								<h3><?php LO('interview__page__titleTip');?></h3>
                                </div>
                                <!-- 精彩访谈 结束-->
                                
                                <div class="talk-list">
		                        <?php 
		                        	if ( is_array($list) )
		                        	{
		                        		foreach ($list as $aRecord) 
		                        		{
		                        ?>
	                            <div class="item">
	                            	<div class="cover">
	                                	<a href="<?php echo URL('interview', array('id'=>$aRecord['id']) ); ?>" target="_blank"><img src="<?php echo $aRecord['cover_img']; ?>" alt="<?php echo $aRecord['title']; ?>" /></a>
	                                </div>
	                                <div class="info">
									<?php if ( isset($aRecord['notice']) && $aRecord['notice'] ) { ?><a class="ico-remind" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', L('interview__page__remindMeTip', $aRecord['title']));?>,c:<?php echo F('share_weibo', 'interview_tips', $aRecord);?>,n:<?php echo $aRecord['notice'];?>"><?php LO('interview__page__remindMe');?></a> <?php } ?>
	                                	<h4><a href="<?php echo URL('interview', array('id'=>$aRecord['id']) ); ?>" target="_blank"><?php echo $aRecord['title']; ?></a>
	                                       	<?php if ($aRecord['status']=='P'){LO('interview__page__notStarted'); } elseif ($aRecord['status']=='E'){ LO('interview__page__end'); } else {LO('interview__page__going');}?>
	                                    </h4>
	                                    <p class="time"><?php echo date($aRecord['dateFormat'], $aRecord['start_time']).'-'.date($aRecord['dateFormat'], $aRecord['end_time'])?></p>
	                                    <p><?php echo $aRecord['desc']; ?></p>
	                                </div>
	                            </div>  
	                            <?php } } else { ?>  
									<div class="default-tips">
										<div class="icon-tips"></div>
										<?php if (USER::get('isAdminAccount')):?>
										<p><?php LO('interview__page__adminEmptyTip');?></p>
										<?php else:?>
										<p><?php LO('interview__page__emptyTip');?></p>
										<?php endif;?>
									</div>
                                <?php } ?>                              
                            	</div>
                            	
	                            <!-- 分页 结束-->
	                            <?php TPL::module('page', array('list'=>$list, 'count'=>$count, 'limit'=>$limit, 'type'=>'event'));?>
	                            <!-- 分页 结束-->
                            </div>
                        </div>
						<div class="aside">
							<!-- 用户信息 开始-->
							<?php Xpipe::pagelet('common.userPreview');?>
							<!-- 用户信息 结束-->
							
							<!-- 主持人 开始-->
							 <?php Xpipe::pagelet('interview.baseMasterList', array( 'masterList'=>$userlist, 'friendList'=>$friendList ) );?>
							<!-- 主持人 结束-->
                            
                            <!-- 关于 开始-->
							<?php TPL::module('interview/about_live', array( 'about' => isset($config['desc'])?$config['desc']:'' ) ); ?>
							<!-- 关于 结束-->
                            
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
