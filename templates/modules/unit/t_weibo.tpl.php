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
		var jqWbCt    = $('.weibo-list');
		var tabLi0=$('.tab-s1 li:eq(0)');
		var tabLi1=$('.tab-s1 li:eq(1)');
		tabLi0.click(function(){
			var self=$(this);
			self.addClass('current');
			tabLi1.removeClass('current');
			jqWbCt[0].scrollTop = 0;
			jqWbCt.find('ul:eq(0)').show();
			jqWbCt.find('div.user-list').hide();
			tabLi1.html('<a href="javascript:;"><span><?php LO("modules_unit_t_weibo_allMembers");?></span></a>');
			tabLi0.html('<span><?php LO("modules_unit_t_weibo_talkAbout");?></span>');
			return false;
		});
		tabLi1.click(function(){
			var self=$(this);
			self.addClass('current');
			tabLi0.removeClass('current');
			jqWbCt[0].scrollTop = 0;
			jqWbCt.find('div.user-list').show();
			jqWbCt.find('ul:eq(0)').hide();
			tabLi1.html('<span><?php LO("modules_unit_t_weibo_allMembers");?></span>');
			tabLi0.html('<a href="javascript:;"><span><?php LO("modules_unit_t_weibo_talkAbout");?></span></a>');
			return false;
		});
	  $('a.btn-addfollow').each(function(){
	  	$(this).click(function(){
	  		var self=$(this);
	  		Xwb.request.follow(self.attr('rel'),0,function(r){
	  			if(r.isOk() || r.getCode()=='1020805'){
	  				self.replaceWith('<a href="#" onclick="javascript:return false;" class="btn-followed"></a>');
	  			}
	  			else {
	  				alert(r.getError());
	  			}
	  		});
	  		return false;
	  	})
	  })
	})
	</script>
</head>
<body>
<div id="showCt" class="weibo-topic <?php if($skin):?>skin<?php echo $skin;?><?php endif;?>" style="height:<?php echo $height;?>px; <?php if ($width):?>width:<?php echo $width;?>px<?php endif;?>">
	<div id="showCtInner" class="<?php if ($show_border):?>weibo<?php else:?>weibo-noborder<?php endif;?>">
		<?php if ($show_title):?>
		<div class="weibo-title">
			<a href="#" class="title" title=""><?php echo F('escape', $unit_name);?></span></a>
		</div>
		<?php endif;?>
		<div class="wb-hd">
				<ul class="tab-s1">
					<li class="current"><span><?php LO('modules_unit_t_weibo_talkAbout');?></span></li>
					<li><a href="javascript:;"><span><?php LO('modules_unit_t_weibo_allMembers');?></span></a></li>
				</ul>
			<?php if ($title): ?><h5><?php echo F('escape', $title); ?></h5><?php endif; ?>
		</div>
		<div class="weibo-main">
			<a href="#this" class="arrow-up arrow-icon" id="upSlider">
				<img id="arrowUp" class="arrow-icon" height="4" width="8" src="<?php echo W_BASE_URL;?>css/component/content_unit/bgimg/transparent.gif" alt="arrow-up" />
			</a>
			<div class="weibo-list">
				<ul>
					<?php if (empty($errno)):?>
					<?php if ($weibo_list):?>
					<?php foreach ($weibo_list as $item):?>
					<?php 
						$text = $item['text'];
						$id = (string)$item['id'];

						//简化的JSON数据对象
						$json_element = array(
							'cr' => $item['created_at'], //create time
							'f' => isset($item['favorited']) ? 1: 0, //is favorited
							's' => $item['source'], //来源
							'tx' => $text //文本内容
						);

						if (isset($item['thumbnail_pic'])) {
							$json_element['tp'] = $item['thumbnail_pic'];
							$json_element['mp'] = $item['bmiddle_pic'];
							$json_element['op'] = $item['original_pic'];
						}

						$json_element['u'] = array(
							'id' => (string)$item['user']['id'], //用户ID
							'sn' => $item['user']['screen_name'], //显示的名称
							'p' => $item['user']['profile_image_url'],
							'v' => $item['user']['verified'] ? 1: 0
						);
					?>
					<?php if (isset($item['retweeted_status'])):?>
						<?php 
							$text = $item['text'].' [转]'.$item['retweeted_status']['text'];
						?>

					<?php endif;?>
					<?php
						$thumbnail_pic = isset($item['retweeted_status']['thumbnail_pic']) ? $item['retweeted_status']['thumbnail_pic'] : (isset($item['thumbnail_pic']) ? $item['thumbnail_pic'] : false);
					?>
						<li id="<?php echo $item['id'];?>">
						<a class="user-pic" href="<?php echo URL('ta', 'id='.$item['user']['id'].'&name='.F('escape', $item['user']['screen_name']));?>" title="<?php echo F('escape', $item['user']['screen_name']);?>" target="_blank">
						<img src="<?php echo F("profile_image_url", $item['user']['profile_image_url'])?>" alt="" />
						</a>
						<div class="weibo-txt">
							<p><?php echo F('format_text', $text, 'feed');?></p>
							<div class="weibo-img">
							<?php if (!empty($thumbnail_pic)):?>
								<a href="<?php echo URL('show', 'id='.$item['id']);?>" title="" target="_blank"><img src="<?php echo $thumbnail_pic;?>" alt="" /></a>
							<?php endif;?>
							</div>
						</div>
						<div class="weibo-info">
							<p><a href="<?php echo URL('show', 'id='.$item['id']);?>" target="_blank" id="fw"><?php LO('modules_unit_t_weibo_forward');?></a>|<a href="<?php echo URL('show', 'id='.$item['id']);?>" target="_blank" id="cm"><?php LO('modules_unit_t_weibo_comment');?></a></p>
							<span><a href="<?php echo URL('show', 'id='.$item['id']);?>" target="_blank"><?php echo F('format_time', $item['created_at']);?></a> <?php LO('modules_unit_t_weibo_from');?> <?php echo $item['source'];?></span>
						</div>
					</li>
					<?php
					//</li>
					//将每条微博的内容保存到一个对象，最后以json格式输出到页面
						$json = APP::getData('json', 'WBDATA', array());

						if (!isset($json[(string)$item['id']])) {
							$json[(string)$item['id']] = $json_element;
							APP::setData('json', $json, 'WBDATA');
						}
					?>
					<?php endforeach;?>
					<?php else:?>
						<div><?php LO('modules_unit_t_weibo_empty');?></div>
					<?php endif;?>
					<?php else:?>
						<div class="int-box ico-load-fail"><?php LO('modules_unit_t_weibo_refresh');?></div>
					<?php endif;?>
				</ul>
				<div class="user-list" style="display: none;">
				<ul>
					<?php if ($user_list):?>
					<?php foreach ($user_list as $user): ?>
						<li>
							<?php if (!USER::isUserLogin()): ?><a href="<?php echo URL('ta', 'id=' . $user['uid']); ?>" class="btn-addfollow" target="_blank"></a><?php endif; ?>
							<span class="user-pic-s"><img src="<?php echo F("profile_image_url", $user['uid'])?>" width="30px" alt="<?php echo F('escape', $user['nickname']);?>" /></span>
							<span class="user-name"><a href="<?php echo $user['http_url']; ?>" target="_blank"><?php echo F('escape', $user['nickname']);?></a></span>
						</li>
					<?php endforeach; ?>
					<?php else:?>
						<div><?php LO('modules_unit_t_weibo_nousers');?></div>
					<?php endif;?>
				</ul>
				</div>
			</div>
			<a href="#this" class="arrow-down arrow-icon" id="downSlider">
				<img id="arrowDown" class="arrow-icon" height="4" width="8" src="<?php echo W_BASE_URL;?>css/component/content_unit/bgimg/transparent.gif" alt="arrow-up" />
			</a>
		</div>
		<?php if ($show_logo):?>
		<div class="xweibo">
			<a href="<?php echo W_BASE_HTTP . W_BASE_URL_PATH;?>" target="_blank">
				<img src="<?php echo F('get_logo_src','output');?>" alt="Xweibo"/>
			</a>
		</div>
		<?php endif;?>
	</div>
</div>
<script type='text/javascript'>
if(!window.Xwb)Xwb={};
Xwb.cfg={	basePath :	'<?php echo W_BASE_URL;?>',
			routeMode:  <?php echo R_MODE;?>,
			routeVname: '<?php echo R_GET_VAR_NAME;?>',
			loginCfg : 	<?php echo V('-:sysConfig/login_way', 1);?>,
			
			wbList: 	<?php echo json_encode(APP::getData('json', 'WBDATA',array()));?>, 
	
			authenCfg:	'<?php echo V("-:sysConfig/authen_enable"); /*用户认证方式 1.使用站点特定的认证 0.使用新浪名人认证*/?>',

			authenTit:	'<?php echo addslashes(V("-:sysConfig/authen_small_icon_title")); /*站点认证小图标提示文字*/?>',

			webName:	'<?php echo addslashes(V("-:sysConfig/site_name")); /*本站名*/?>',

			uid: 		'<?php echo USER::uid(); /*sina uid*/?>', 

			siteUid:	'<?php echo USER::get('site_uid'); /*第三方UID*/?>',

			siteUname:	'<?php echo addslashes(USER::get('site_uname')); /* 第三方用户名 */?>',

			siteName:	'<?php echo addslashes(USER::get('site_name')); /* 第三方站点名 */?>',

			siteReg:	'<?php echo V('-:siteInfo/reg_url'); /* 第三方注册链接 */?>',
			remind: <?php /*新评论等提醒方式*/ echo V('-:userConfig/user_newfeed')?1:0;?>,
			maxid: '<?php echo APP::getData('maxid', 'WBDATA', '');?>',
			page: '<?php /*当前所在的页*/ $page = APP::getData('page', 'WBDATA'); echo !empty($page) ? $page: APP::getRequestRoute();?>',
			akey: '<?php /*appkey 上报用*/ echo WB_AKEY;?>',
			ads: <?php echo F('ad_config'); ?>
};
</script>
</body>
</html>
