<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微博屏蔽 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>微博<span> &gt; </span>微博屏蔽</div>
    <div class="set-wrap">
        <h4 class="main-title">屏蔽指定微博</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请输入需要屏蔽的微博详细页网址，搜索到的内容后将显示在下方，即可对此微博及转发信息进行屏蔽。<a href="<?php echo URL('mgr/weibo/disableWeibo.weiboList');?>">返回屏蔽微博列表</a></p>
				<form method="post" action="<?php echo URL('mgr/weibo/disableWeibo.search')?>">
            	<div class="serch-user">
            		<span><strong>微博地址</strong></span>
                	<input name="url" class="input-txt box-address-width" type="text" value="<?php echo V('g:keyword');?>" />
                	<span class="serch-btn"><input name="" type="submit" value="搜索" /></span>
           		</div>
				</form>
				<?php $d = F('get_filter_cache', 'weibo');?>
				<?php if (isset($info) && $info) {?>
                <ul class="serch-results-shield">
                	<p>作者昵称：<strong><?php echo htmlspecialchars($info['user']['name']);?></strong></p>
                    <p>微博内容：<span><?php echo htmlspecialchars($info['text']);?></span></p>
                    <p>发布时间：<span><?php echo  date('Y-m-d H:i:s', strtotime($info['created_at']));?></span></p>
                    <p>相关操作：
						<span>
							<?php if (isset($d[(string)$info['id']])) {?>
							<a href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableWeibo.resume', 'id=' . $info['id'] . '&type=1', 'admin.php');?>','确认要恢复该微博吗');">恢复该微博</a>
							<?php } else {?>
							<a href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableWeibo.disable', 'id=' . $info['id'], 'admin.php');?>','确认要屏蔽该微博吗?')">屏蔽此微博</a>
							<?php }?>
						</span>
					</p>
                </ul>
				<?php }?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
