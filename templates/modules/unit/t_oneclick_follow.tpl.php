<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base target="_blank" />
	<title><?php echo F('escape', $unit_name);?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL;?>css/component/content_unit/base.css" />
	<?php if (WB_LANG_TYPE_CSS):?>
	<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL;?>css/component/content_unit/skin_<?php echo WB_LANG_TYPE_CSS;?>.css" />
	<?php else:?>
	<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL;?>css/component/content_unit/skin.css" />
	<?php endif;?>
	<script src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
	<script src="<?php echo W_BASE_URL;?>js/base/xwbapp.js"></script>
	<script src="<?php echo W_BASE_URL;?>js/mod/xwbrequestapi.js"></script>
	<script src="<?php echo W_BASE_URL;?>js/mod/wbshowframe.js"></script>
	<script type="text/javascript">
	$(function(){
		var lock = 1;
		$('#submit').click(function(){
			if( ! Xwb.cfg.uid ){
				$(this).removeAttr('href');
				return false;
			}
			if(lock == 0) return false;
			var allcheckbox=$('input:checked'),v=[];
			allcheckbox.each(function(){
				v.push($(this).attr('rel'));
			});
			if(v.length == 0 ) { alert('请选择要关注的用户'); return false;}
			lock = 0;
			Xwb.request.follow(v.join(','),0,function(r){
				if( r.isOk()  || r.getCode() == '1020805' ){

					alert('<?php LO('modules_unit_t_oneclick_follow_followed');?>!');
					window.open(Xwb.request.mkUrl('index'), '');
				} else {
					alert(r.getMsg());
				}
				lock = 1;
			})
			return false;
		})
	})
	</script>
</head>
<body id="weibo">
<div id="showCt" class="weibo-follow batch-follow <?php if ($skin):?>skin<?php echo $skin;?><?php endif;?>" style="height:<?php echo $height;?>px; <?php if ($width):?>width:<?php echo $width;?>px<?php endif;?>">
	<div id="showCtInner" class="<?php if ($show_border):?>weibo<?php else:?>weibo-noborder<?php endif;?>">
		<?php if ($show_title):?>
		<div class="weibo-title">
			<a href="#" class="title" title=""><?php echo F('escape', $unit_name);?></a>
		</div>
		<?php endif;?>
		<div class="weibo-main">
			<a href="#this" class="arrow-up arrow-icon" id="upSlider" onclick='return false;'>
				<img id="arrowUp" class="arrow-icon" height="4" width="8" src="<?php echo W_BASE_URL;?>css/component/content_unit/bgimg/transparent.gif" alt="arrow-up" />
			</a>
				<div class="unlogin-tips <?php if(USER::isUserLogin()) echo 'hidden';?>" style="clear:both">
					<?php
					//var_dump(USER::isUserLogin());
					?>
					<?php
					if(!USER::isUserLogin()):
					?>
					<p><?php LO('modules_unit_t_oneclick_follow_nologin', WB_USER_SITENAME, URL('account.login','loginCallBack='.urlencode(V('s:HTTP_REFERER',''))));?></p>
					
					</script>
					<?php
					endif;
					?>
				</div>
			<div class="recom-list" id="recom">
<!--js定于的滚动取weibo-list做为类属性，请前端统一，不然无法显示滚动效果-->
				<ul>
					<?php
					if(empty($userlist)){
						echo L('modules_unit_t_oneclick_follow_userlistEmpty');
					}
					foreach($userlist as $userinfo):
					
					?>
					<?php
						$profile_image_url = isset($userinfo['profile_image_url']) ? $userinfo['profile_image_url'] : $userinfo['uid'];
					?>
					<li>
						<div class="user-pic"><img src="<?php echo F('profile_image_url', $profile_image_url);?>" alt="" /></div>
						<div class="user-name"><span><a href="<?php echo URL('ta','id='.$userinfo['uid'])?>"><?php echo $userinfo['nickname']?></a></span><input type="checkbox" checked="checked"  rel="<?php echo $userinfo['uid']?>"/></div>
						<p><?php if(isset($userinfo['description'])) echo mb_strlen($userinfo['description'],'utf8')>13?mb_substr($userinfo['description'],0,13,'utf8').'...':$userinfo['description']?></p>
					</li>
					<?php
					endforeach;
					?>
				</ul>
				
			</div>
			<a href="#this" class="arrow-down arrow-icon" id="downSlider" onclick='return false;'>
				<img id="arrowDown" class="arrow-icon" height="4" width="8" src="<?php echo W_BASE_URL;?>css/component/content_unit/bgimg/transparent.gif" alt="arrow-up" />
			</a>
				<div class="btn-area" style="width:106px; margin:0px auto;padding:15px 0 30px 0;">
					<a href="#this" id="submit" class="btn-follow-all btn-center"></a>
				</div>
			
		</div>
		<?php if ($show_logo):?>
		<div class="xweibo">
			<a href="<?php echo W_BASE_HTTP . W_BASE_URL_PATH;?>" target="_blank">
				<img src="<?php echo F('get_logo_src','output');?>" alt="Xweibo"/>
			</a>
		</div>
		<?php endif;?>
	</div>
	<script type='text/javascript'>
		if(!window.Xwb)Xwb={};
		Xwb.cfg={	
			basePath :	'<?php echo W_BASE_URL;?>',
			uid: 		'<?php echo USER::uid(); /*sina uid*/?>'
		}
		Xwb.request.init(Xwb.cfg.basePath);
	</script>
</div>
</body>
</html>


