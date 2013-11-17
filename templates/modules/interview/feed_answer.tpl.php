<?php
/**
 * 单条微博格式化
 * @param $user array 该条微博的用户信息
 * @favorited boolean 是否被收藏了
 * 
 */

	$id = (string)$id;
	
	if (!isset($xwb_weibo_verify)) {
		$source = preg_replace("#(<a\s+href=[\"'][^\"']+[\"'][^>]*)(>.+?</a>)#i", "\$1 target=\"_blank\"\$2", $source);
	}

	//if (!isset($xwb_weibo_verify)) {
		//简化的JSON数据对象
		$json_element = array(
			'cr' => $created_at, //create time
			//'f' => isset($favorited) ? 1: 0, //is favorited
			's' => $source, //来源
			'tx' => $text //文本内容
		);

		if (isset($thumbnail_pic)) {
			$json_element['tp'] = $thumbnail_pic;
			$json_element['mp'] = $bmiddle_pic;
			$json_element['op'] = $original_pic;
		}

		$json_element['u'] = array(
			'id' => (string)$user['id'], //用户ID
			'sn' => $user['screen_name'], //显示的名称
			'p' => $user['profile_image_url'],
			'v' => $user['verified'] ? 1: 0
		);
//	}

	// xxx前发表
	$format_time = F('format_time', $created_at);

	//用户头像
	$user_img = &$user['profile_image_url'];

	//用户昵称
	$nick = F('escape', $user['screen_name']);

	//格式化后的内容
	$text = F('format_text', $text);

	$profile_url = URL('ta', array('id' => (string)$user['id'], 'name' => $user['screen_name']));

	//微博链接
	$link = URL('show', array('id' => $id));
 
	//用户头像
	if (!isset($header)) {
		$header = 1;
	}

	if (!isset($disable_comment)) {
		$disable_comment = false;
	}

	if ($header == 1):
?>
	<div class="user-pic">
	<a href="<?php echo $profile_url;?>"><img width="50" height="50" src="<?php echo $user_img;?>" alt="<?php echo $nick;?>" title="<?php echo $nick;?>" /></a>
	<!-- 在线直播 主持人和嘉宾的区别 -->
	<?php if (isset($user['live_user_type']) && $user['live_user_type'] == 'master'):?>
	<span class="emcee-mark"><?php LO('modules__feed__master');?></span>
	<?php elseif (isset($user['live_user_type']) && $user['live_user_type'] == 'guest'):?>
	<span class="guest-mark"><?php LO('modules__feed__guest');?></span>
	<?php endif;?>
	<!-- end -->
	</div>
<?php elseif ($header == 2): //热门转发?>
	<div class="hot-total">
		<strong id="hotNum"></strong>
		<em><?php LO('modules_interview_feedAnswer_forward');?></em>
	</div>
<?php elseif ($header == 3): //热门评论?>
	<div class="hot-total">
		<strong id="hotNum"></strong>
		<em><?php LO('modules_interview_feedAnswer_comment');?></em>
	</div>
<?php endif;?>
	<div class="feed-content">
		<p class="feed-main">
<?php /*默认显示*/ if (!isset($author) || $author):?>
<a href="<?php echo $profile_url;?>" title="<?php echo $nick;?>"><?php echo $nick;?><?php echo F('verified', $user);?></a>：<?php endif;?><?php echo $text;?></p>
	<?php if (isset($thumbnail_pic)): ?>
		<div class="preview-img">
			<div class="feed-img">
				<img class="zoom-move" src="<?php echo $thumbnail_pic;?>" rel="e:zi,fw:0"/>
			</div>
		</div>
	<?php endif;?>
<?php
// 图片内容
/*
		<div class="box-style" style="display:none">
			<div class="box-t skin-bg"><span class="skin-bg"></span></div>
			<div class="box-content">


			<div class="show-img">
				<p>
					<a href="#" class="ico-piup">收起</a>
					<a href="#" class="ico-src">查看原图</a>
					<a href="#" class="ico-turnleft">向左转</a>
					<a href="#" class="ico-turnright">向右转</a>
				</p>


				<div><img alt="" src="../img/50c36080t882adeda566c&amp;690.jpg"></div>
			</div>

			</div>
			<div class="box-b skin-bg"><span class="skin-bg"></span></div>
			<span class="box-arrow skin-bg"></span>
		</div>
*/
?>
	<div class="feed-info"><p>
	<?php if ($uid == $user['id']):?><a href="#" rel="e:dl"><?php LO('modules__feed__delete');?></a>|<?php endif;?><a href="#" rel="e:fw" id="fw"><?php LO('modules__feed__repost');?></a>|<a href="#" rel="e:fr"><?php LO('modules__feed__fav');?></a>|<a href="javascript:;"<?php if (!$disable_comment):?> rel="e:cm"<?php endif;?> id="cm"><?php LO('modules__feed__comment');?></a>
	</p><span><a href="<?php echo $link;?>"><?php echo $format_time;?></a> <?php LO('modules__feed__source', $source);?></span>
	
	<?php if (isset($is_show) && $is_show && USER::uid()){ // 举报功能，只有在微博详细也才显示  ?>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" rel="e:rs"><?php LO('modules__feed__report');?></a>
	<?php } ?>
	
	<?php if (isset($is_show) && $is_show && USER::aid()){?> ｜ <?php if (isset($filter_state) && is_array($filter_state) && in_array(3, $filter_state)) {?><span><?php LO('modules__feed__blocked');?></span><?php } else {?> <a href="#" rel="e:blm"><?php LO('modules__feed__blockWeibo');?></a><?php }}?>
    </div>
  </div>
<?php
//if (!isset($xwb_weibo_verify)) {
	/// 将每条微博的内容保存到一个对象，最后以json格式输出到页面
	$json = APP::getData('json', 'WBDATA', array());

	if (!isset($json[$id])) {
		$json[$id] = $json_element;
		APP::setData('json', $json, 'WBDATA');
	}
//}
?>

<?php if (isset($is_show) && $is_show && USER::uid()){ // 举报功能，只有在微博详细也才显示  ?>
<?php } ?>
