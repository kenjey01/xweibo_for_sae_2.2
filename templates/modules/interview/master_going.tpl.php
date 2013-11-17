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
						<!-- 微博发布框 开始-->
						<?php 
							$params['title'] 		= L('modules_interview_master_title');
							$params['show_video']	= FALSE;
							$params['show_music']	= FALSE;
							$params['show_trends']	= FALSE;
							$params['ext_xwbAdditive']['doAction']		= 'interView';
							$params['ext_xwbAdditive']['extra_params']	= array('interview_id'=>$interview['id']);
							
							Xpipe::pagelet('weibo.input', $params); 
						?>
						<!-- 微博发布框 结束-->
						
						<!-- 访谈内容 开始-->  
						<?php Xpipe::pagelet('interview.interviewWeiboList', array('tpl'=>'interview/answerweibo_list', 'wbList'=>$wbList, 'limit'=>$limit, 'list'=>$list, 'interview'=>$interview, 'isMaster'=>TRUE)); ?>
						<!-- 访谈内容 结束-->
						                        
					</div>
				</div>
                <!-- 右边栏 开始 -->
				<div class="aside">					
					<!-- 访谈简介 开始-->
					<div class="talk-intro">
                        <div class="hd">
                        	<p><?php echo ('P'==$interview['status']) ? L('modules_interview_master_ready') : L('modules_interview_master_going') ?></p>
                            <p class="time"><?php LO('modules_interview_master_time');?><span><?php echo date($interview['dateFormat'], $interview['start_time']).' - '.date($interview['dateFormat'], $interview['end_time'])?></span></p>
                        	<p><a class="btn-recommend" href="#" rel="e:sd,t:share,m:<?php echo F('share_weibo', 'interview', $interview);?>"><?php LO('modules_interview_master_recommend');?></a></p>
                        </div>
                        <div class="bd">
                            <h4><?php LO('modules_interview_master_description');?></h4>
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
                <!-- 右边栏 结束 -->
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
