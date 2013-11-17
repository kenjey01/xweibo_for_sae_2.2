<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ($interview['backgroup_color']){ echo "class='skin{$interview['backgroup_color']}'"; }?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', false, F('escape', $interview['title']));?></title>
<?php TPL::module('interview/include/css_link', array('interview'=>$interview) );?>
<?php TPL::module('interview/include/js_link');?>
</head>

<body id="talk-page">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
            	<?php TPL::module('interview/include/header');?>		
            <!-- 头部 结束-->
            
			<div id="container">
            	<!-- banner 开始-->
            	<div class="banner-cont">
                	<img src="<?php echo $interview['banner_img']?$interview['banner_img']:W_BASE_URL.'/img/talk_pic.jpg'; ?>" alt="" />
                </div>
                <!-- banner 结束-->
                
				<div class="content">
					<div class="main">
						<?php if ( !USER::isUserLogin() ) {?>
						<div class="not-login-tips">
							<p><?php LO('modules_interview_login_tip');?></p>
							<a href="#" class="btn-login" rel="e:lg"><?php LO('modules_interview_login_tag');?></a>
						</div>
						<?php }?>
						
						<!-- 微博发布框 开始-->
						<?php 
							// Build Title
							$title  = L('modules_interview_not_start_title');
							$title .= '<ul class="guest-list hidden">';
							foreach ($interview['guest'] as $aGuest) 
							{
								$title .= '<li rel="e:@,n:'.$aGuest['screen_name'].'"><a title="'.$aGuest['screen_name'].'" href="#">@'.$aGuest['screen_name'].'</a></li>';
							}
							$title .= '</ul></div><div class="title-txt">' . L('modules_interview_not_start_ask') . '</div>';
							
							$params['title'] 		= $title;
							$params['show_video']	= FALSE;
							$params['show_music']	= FALSE;
							$params['show_trends']	= FALSE;
							$params['ext_xwbAdditive']['doAction']		= 'interView';
							$params['ext_xwbAdditive']['extra_params']	= array('interview_id'=>$interview['id']);
							
							Xpipe::pagelet('weibo.input', $params); 
						?>
						<!-- 微博发布框 结束-->
						
						<!-- 微博列表 开始-->                	
							<?php Xpipe::pagelet('interview.interviewGoingAskWeiboList', array('tpl'=>'interview/askweibo_list', 'wbList'=>$wbList, 'limit'=>$limit, 'list'=>$list, 'interview'=>$interview)); ?>
						<!-- 微博列表 结束-->

					</div>
				</div>
				<div class="aside">					
					<!-- 访谈简介 开始-->
                    <div class="talk-intro">
                        <div class="hd">
                        	<p><span class="not-started"><?php LO('modules_interview_not_start_ready');?></span></p>
                            <p class="time"><?php LO('modules_interview_not_start_time');?><span><?php echo date($interview['dateFormat'], $interview['start_time']).' - '.date($interview['dateFormat'], $interview['end_time'])?></span></p>
                            <?php if ( isset($interview['notice']) && $interview['notice'] ) {?>
                            <p><a href="#" class="btn-s1" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', L('modules_interview_not_start_toBegin', $interview['title']));?>,c:<?php echo F('share_weibo', 'interview_tips', $interview);?>,n:<?php echo $interview['notice'];?>"><span><?php LO('modules_interview_not_start_remind');?></span></a></p>
                            <?php } ?>
                        	<p><a href="#" class="btn-recommend" rel="e:sd,t:share,m:<?php echo F('share_weibo', 'interview', $interview);?>"><?php LO('modules_interview_not_start_reommmend');?></a></p>
                        </div>
                        <div class="bd">
                            <h4><?php LO('modules_interview_not_start_description');?></h4>
                            	<p><?php echo $interview['desc']; ?></p>
                        </div>
                    </div>
					<!-- 访谈简介 结束-->
                    
                    <!-- 访谈主持人 开始-->
                    <?php TPL::module('interview/include/emcee_list', array('masterList'=>$interview['master'],'friendList'=>$friendList)); ?>
                    <!-- 访谈主持人 结束-->
					
					<!-- 访谈嘉宾 开始-->
					<?php Xpipe::pagelet('interview.guestList', array('guestList'=>$interview['guest'],'friendList'=>$friendList)); ?>
					<!-- 访谈嘉宾 结束-->
                    
                    <!-- 访谈列表 开始-->
                    <?php TPL::module('interview/include/program_list', array('interviewList'=>$interviewList)); ?>
                    <!-- 访谈列表 结束-->
				</div>
			</div>
			<!-- 底部 开始-->
			<?php TPL::module('footer'); ?>
			<!-- 底部 结束-->
		</div>
	</div>

	<!-- 返回顶部 开始-->
	<?php TPL::module('gotop'); ?>
	<!-- 返回顶部 结束-->
    
</body>
</html>
