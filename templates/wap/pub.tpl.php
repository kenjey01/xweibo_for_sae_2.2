<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title')?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
		
	<?php
	TPL::plugin('wap/include/top_logo','',false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false)
	?>
	<?php
	if(isset($default_rem_title)&&!empty($users)):
	?>
	<div class="list">
		<div class="hd"><?php echo $default_rem_title;?></div>
		<div class="bd">
			
			<?php
			foreach($users as $user):
			$sina_uid = isset($user['uid']) ? $user['uid'] : $user['id'];
			$href=WAP_URL('ta',"id={$sina_uid}&name=".urlencode(isset($user['name'])?$user['name']:$user['nickname']));
			?>
			<a href="<?php echo $href?>"><?php echo isset($user['screen_name'])?$user['screen_name']:$user['nickname']?></a>
		
			<?php
			endforeach;
			?>
			<a href="<?php echo WAP_URL('celeb')?>">&gt;&gt;</a>
		</div>
	</div>
	<?php
	endif;
	?>
	
	
	<div class="list">
		<div class="hd"><?php LO('pub__default__label_hotTrend');?></div>
		<div class="bd">
			
			
			<?php
			$totalNum = 10;
			
			if(isset($topics)):
			foreach($topics[0] as $topic):
			if($totalNum--<=0) {
				break;
			}
			$href = WAP_URL('search',"k=" . urlencode($topic['name']));
			?>
			<a href="<?php echo $href;?>"><?php echo $topic['name']?></a>
			
			<?php
			
			endforeach;
			?>
			<a href="<?php echo WAP_URL('pub.topics');?>">&gt;&gt;</a>
			
			<?php else:?>
			<?php LO('pub__default__label_notFoundTrend');?>
			<?php endif;?>
		</div>
	</div>
	<div class="f-hd row">
		<?php
		if(V('g:m','pub')=='pub'||V('g:m','pub')=='pub.hotForward'):
		?>
		<span><?php LO('pub__default__label_hotRepost');?></span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('pub.hotForward')?>"><?php LO('pub__default__label_hotRepost');?></a>
		<?php
		endif;
		?>
		<?php
		if(V('g:m','pub')=='pub.hotComments'):
		?>
		<span><?php LO('pub__default__label_hotComment');?></span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('pub.hotComments')?>"><?php LO('pub__default__label_hotComment');?></a>
		<?php
		endif;
		?>
		
	</div>
	<div class="f-list-parent">
	<?php
	//var_dump($status);
	TPL::plugin('wap/include/feedlist', array("list"=>$status), false);
	?>
	</div>
	
	<div class="pages">
		<?php
		TPL::plugin('wap/include/pager', array('ctrl' => APP::getRequestRoute(), 'list' => $status, 'page' => V('g:page',1)), false); 
		?>
	</div>
	<?php
	TPL::plugin('wap/include/search','',false);
	?>
	<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot',"",false);
	?>
</body>
</html>
