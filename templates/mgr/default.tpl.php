<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首页</title>
<link type="text/css" rel="stylesheet" href="<?php echo W_BASE_URL;?>css/admin/admin.css" media="screen" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">
	$(function(){
		$.ajax({
			url:'http://x.weibo.com/papi.php?type=19&records=10',
			type:'get',
			dataType:'jsonp',
			success:function(r){
				$(r).each(function(){
					$("<li><a href='"+this.link_url+"' target='_blank'>"+this.title+"</a><span>"+this.create_time+"</span></li>")
					.appendTo($('#news'));
				});
			}
		})
	})
</script>
</head>

<body class="main-body">
	<div class="path">
			<p>当前位置：首页<span></span></p>
	</div>
	<div class="main-cont">
		<h3 class="title">系统信息</h3>
		<div class="box">
			<div class="btn-group clear">
				<p>Xweibo版本：xweibo标准版<?php echo WB_VERSION;?></p>
				<a class="btn-general" href="http://weibo.com/xweibo" target="_blank"><span>关注Xweibo官方</span></a>
				<a class="btn-general" href="http://x.weibo.com/index.php/help" target="_blank"><span>帮助中心</span></a>
				<a class="btn-general" href="http://x.weibo.com/index.php/cooperation" target="_blank"><span>联系客服 </span></a>
				<a class="btn-general" href="mailto:xweibo@vip.sina.com"><span>意见反馈</span></a>
			</div>
		</div>
		<h3 class="title">官方动态</h3>
		<div class="box">
			<ul class="news-item" id="news">
			</ul>
		</div>
		
		
		<h3 class="title">网站基本数据</h3>
		<div class="box">
		<ul class="group-item">
			<li>总微博数:<span><?php echo $counts['wb'];?></span></li>
			<li>总用户数:<span><?php echo $counts['user'];?></span></li>
			<li>总评论数:<span><?php echo $counts['comment'];?></span></li>
		</ul>
		<ul class="group-item">
			<li>今日微博数:<span><?php echo $counts['t_wb'];?></span></li>
			<li>今日用户数:<span><?php echo $counts['t_user'];?></span></li>
			<li>今日评论数:<span><?php echo $counts['t_comment'];?></span></li>
		</ul>
		</div>
	</div>
</body>
</html>
