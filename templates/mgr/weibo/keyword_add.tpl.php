<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关键字过滤 - 用户管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#submit').click(function(){
		$('#form').submit();
		return false;
		});
	});
</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>关键字过滤</p></div>
    <div class="main-cont">
        <h3 class="title">添加关键字</h3>
		<div class="set-area">
        	<p class="approve-tips">
            	包含设置的关键词时读取的内容将被过滤,同时不允许用户发布含有相关关键词的信息。(关键词一行一个，或用 "|" 隔开)
            </p>
			<form id='form' action="<?php echo URL('mgr/weibo/keyword.add','XDEBUG_SESSION_START=1');?>" method="post">
        	<div class="form">
                <div class="form-row">
                    <div class="form-cont">
                    	<textarea  id="intro" class="input-area area-s1" name='keywords' ><?php echo join('|',$list);?></textarea>
                        <p class="form-tips">关键字设置会消耗大量的系统资源，请尽量不要设置过多的关键字。</p>
                    </div>
                </div>
                <div class="form-cont" id='submit'><a  href="#" class="btn-general highlight"><span>确认</span></a></div>
            </div>
			</form>
        </div>
    </div>
</body>
</html>

