<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link type="text/css" rel="stylesheet" href="<?php echo W_BASE_URL;?>css/admin/admin.css" media="screen" />
</head>

<body class="main-body">
	<?php
	// 如果没有设置代理帐号	
	if (!DS('accountProxy.issetProxy')) {
		// 设置代理帐号的URL
		$url = URL('mgr/proxy_account.accountList');
		// 如果不是站长
		if (USER::uid() == SYSTEM_SINA_UID) {

		} else{

		}
	}
	?>
	
	<?php
	$contentList=array(array('title'=>'微博秀','preview'=>'wb_show.png','link'=>URL('mgr/content_unit.add','type=1')),
					   array('title'=>'推荐关注','preview'=>'wb_follow.png','link'=>URL('mgr/content_unit.add','type=2')),
					   array('title'=>'互动话题','preview'=>'wb_topic.png','link'=>URL('mgr/content_unit.add','type=3')),
					   array('title'=>'一键关注','preview'=>'wb_userlist.png','link'=>URL('mgr/content_unit.add','type=4')),
					   array('title'=>'群组微博','preview'=>'wb_group.png','link'=>URL('mgr/content_unit.add','type=5')));
	?>
	
	<div class="path"><p>当前位置：扩展工具<span>&gt;</span>站外调用</p></div>
	<div class="main-cont clear">
		<div class="invoke">
			<ul class="pic-item pic-item-s1 clear">
				<?php
				foreach($contentList as $content):
				?>
				<li><?php echo $content['title']?><a href="<?php echo $content['link']?>"><img src="<?php echo W_BASE_URL.'css/admin/bgimg/'.$content['preview']?>" /></a></li>
				<?php
				endforeach;
				?>
			</ul>
		</div>
	</div>
</body>
</html>
