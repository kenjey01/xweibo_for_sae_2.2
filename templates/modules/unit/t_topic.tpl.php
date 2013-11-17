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
			var jqBnt=$("#subBnt");
			var jqContent=$('#content');
			var jqKeyTips=$('.key-tips');
			if(Xwb.cfg.uid){
				jqContent.keydown(function(){
					checkText();
				})
				jqBnt.click(function(){
					if(checkText()){
						Xwb.request.post($.trim(jqContent.val()),function(r){
							if(r.isOk()){
								$('#postOk').show();
								setTimeout(location.reload(),1000);
							} else {
								$('#postError').show().html('<span class="load-fail"></span>'+r.getError());
							}
						})
					}
				})
			}
			function checkText(){
				var v = $.trim( jqContent.val() );
		        var left = calWbText(v);
		        if (left >= 0)
		            jqKeyTips.html('<?php LO("modules_unit_t_topic_input");?><span>'+left+'</span><?php LO("modules_unit_t_topic_letter");?>');
		        else
		            jqKeyTips.html('<?php LO('modules_unit_t_topic_overflow');?><span>'+Math.abs(left)+'</span><?php LO("modules_unit_t_topic_letter");?>'); 
		        return left>=0 && v;
			}
			 function calWbText(text, max){
				if(max === undefined)
					max = 140;
					var cLen=0;
					var matcher = text.match(/[^\x00-\xff]/g),
					wlen = (matcher && matcher.length) || 0;
				return Math.floor((max*2 - text.length - wlen)/2);
			}
			checkText();
		})
	</script>
</head>
<body>
<div id="showCt" class="weibo-topic <?php if($skin):?>skin<?php echo $skin;?><?php endif;?>" style="height:<?php echo $height;?>px; <?php if ($width):?>width:<?php echo $width;?>px<?php endif;?>">
	<div id="showCtInner" class="<?php if ($show_border):?>weibo<?php else:?>weibo-noborder<?php endif;?>">
		<?php if ($show_title):?>
		<div class="weibo-title">
			<a href="#" class="title" title=""><?php LO('modules_unit_t_topic_talkAbout');?><span><?php echo F('escape', $topic);?></span></a>
		</div>
		<?php endif;?>
		<div class="weibo-main">
			<?php if ($show_publish): ?>
			<div class="post-box">
				<div class="post-textarea"><div class="inner">
				<textarea id="content"><?php if (USER::isUserLogin()): ?>#<?php echo F('escape', $topic); ?>#<?php endif; ?></textarea>
				</div></div>
				
				<?php if (USER::isUserLogin()): ?>
				<div class="key-tips"></div>
				<div class="share-btn" id="subBnt"></div>
				<div class="post-tips" id='postOk' style="display:none;"><span class="post-success"></span><?php LO('modules_unit_t_topic_succ');?></div>
				<div class="post-tips" id="postError" style="display:none;"><span class="load-fail"></span><?php LO('modules_unit_t_topic_error');?></div>
				<?php else: ?>
				<div class="share-btn share-btn-disable" onclick="javascript:return false;" id="subBnt"></div>
				<div class="login-tips"><span class="act-notbind"><img src="<?php echo W_BASE_URL;?>css/component/content_unit/bgimg/logo_mini.png" alt="" /></span><?php LO('modules_unit_t_topic_nologin', URL('account.login', 'loginCallBack=' . urlencode(V('s:HTTP_REFERER',''))), F('escape', V('-:sysConfig/site_name')));?></div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<a href="#this" class="arrow-up arrow-icon" id="upSlider">
				<img id="arrowUp" class="arrow-icon" height="4" width="8" src="<?php echo W_BASE_URL;?>css/component/content_unit/bgimg/transparent.gif" alt="arrow-up" />
			</a>
			<div class="weibo-list">
				<ul>
					<?php if (empty($errno)):?>
					<?php if ($list):?>
					<?php foreach ($list as $item):?>
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
							<p><a href="<?php echo URL('show', 'id='.$item['id']);?>" target="_blank" id="fw"><?php LO('modules_unit_t_topic_forward');?></a>|<a href="<?php echo URL('show', 'id='.$item['id']);?>" target="_blank" id="cm"><?php LO('modules_unit_t_topic_comment');?></a></p>
							<span><a href="<?php echo URL('show', 'id='.$item['id']);?>" target="_blank"><?php echo F('format_time', $item['created_at']);?></a> <?php LO('modules_unit_t_topic_from');?> <?php echo $item['source'];?></span>
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
						<div><?php LO('modules_unit_t_topic_empty', $show_publish?L('modules_unit_t_topic_publishAgain'):'');?></div>
					<?php endif;?>
					<?php else:?>
						<div class="int-box ico-load-fail"><?php LO('modules_unit_t_topic_refresh');?></div>
					<?php endif;?>
				</ul>
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
			auto_scroll: <?php echo $auto_scroll; ?>,
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


