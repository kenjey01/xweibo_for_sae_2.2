<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>屏蔽用户  - 用户管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>用户<span> &gt; </span>屏蔽用户</div>
    <div class="set-wrap">
        <h4 class="main-title">屏蔽指定用户</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请输入昵称搜索用户，然后选择相应屏蔽的操作。注意：被屏蔽的用户，其所有的微博及评论将不会被显示。<a href="<?php echo URL('mgr/weibo/disableUser.userList');?>">返回屏蔽用户列表</a></p>
            	<div class="serch-user">
            		<form action="<?php echo URL('mgr/weibo/disableUser.search');?>" method="post">
            			<span><strong>搜索包含以下昵称的用户</strong></span>
                		<span><input name="keyword" class="input-txt box-address-width" type="text" value="<?php if (V('r:keyword', false)) echo V('r:keyword');?>" /></span>
                		<span class="serch-btn"><input type="submit" value="搜索" /></span>
                    </form>
           		</div>
				<?php if (V('r:keyword', false) !== false) {?>
                <ul class="serch-results">
					<?php if (isset($list) && is_array($list) && !empty($list)) { $c = count($list); foreach ($list as $row) {?>
                	<li class="result-line<?php if ($c <= 1) {?>-no<?php }?>">
                    	<div class="results-l">
                        	<p class="results-name"><?php echo htmlspecialchars($row['screen_name']);?></p>
                            <p><span><?php echo $row['location'];?></span><span>粉丝数：<?php echo $row['followers_count'];?>人</span></p>
                        </div>
                        <div class="results-r">
							<?php if ($row['disabled']) {?>
                        	<span>已屏蔽</span>
                            <a href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableUser.resume','uid='.$row['id'], 'admin.php');?>', '确认要解除封禁吗?')" class="unban">解除屏蔽</a>
							<?php } else {?>
							<a href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableUser.disable','uid='.$row['id'] . '&nick=' , 'admin.php');?>' + encodeURIComponent('<?php echo $row['screen_name']?>'),'确认要屏蔽该用户吗?')" class="confirmation">确认屏蔽</a>
							<?php }?>
                        </div>
                    </li>
					<?php }} elseif (V('r:keyword', false)) {?>
					<li class="no-data">没有搜索到相关结果</li>
					<?php } else {?>
					<li class="no-data">请输入搜索关键字</li>
					<?php }?>
                </ul>
				<?php }?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
