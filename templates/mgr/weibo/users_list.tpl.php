<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>屏蔽用户 - 用户管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>用户<span> &gt; </span>屏蔽用户</div>
    <div class="set-wrap">
        <h4 class="main-title">屏蔽用户列表</h4>
		<div class="set-area-int">
			<div class="user-list-box1">
				<p class="serch-tips">请输入昵称搜索用户，然后选择相应解除屏蔽的操作。您也可以直接<a href="<?php echo URL('mgr/weibo/disableUser.search');?>">屏蔽指定用户</a>。</p>
				<form method="post" action="<?php echo URL('mgr/weibo/disableUser.userList');?>">
            	<div class="serch-user">
            		<span><strong>搜索包含以下昵称的用户</strong></span>
                	<input name="keyword" class="input-txt box-address-width" type="text" value="<?php echo F('escape', strval(V('r:keyword')));?>" />
                	<span class="serch-btn"><input type="submit" value="搜索" /></span>
           		</div>
				</form>
			</div>
			<div class="user-list">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
					<colgroup>
						<col class="serial-number"/>
                        <col class="nikename" />
    					<col />
    					<col class="t-time"/>
    					<col class="operate-w10"/>
    				</colgroup>
                    <thead class="td-title-bg">
					<tr>
						<th><div class="td-inside">编号</div></th>
   					  	<th><div class="td-inside">用户昵称</div></th>
   					  	<th><div class="td-inside">微博地址</div></th>
   					  	<th><div class="td-inside">屏蔽时间</div></th>
   					  	<th><div class="td-inside">操作</div></th>
				  	</tr>
              		</thead>
              		<tfoot class="tfoot-bg">
					<tr>
						<td colspan="5">
						
                        <div class="pre-next">
						<?php if (isset($list) && is_array($list) && !empty($list)) {?>
						<?php echo $pager;?>
						<?php }?>
                        </div>
						
                        </td>
					</tr>
              		</tfoot>
                	<tbody>
					<?php if (isset($list) && is_array($list) && !empty($list)) {foreach ($list as $key => $row) {?>
                    <tr>
   					  	<td><?php echo $offset + $key +1;?></td>
   					  	<td><?php echo htmlspecialchars($row['comment']) . '(' . $row['item'] . ')';?></td>
   					  	<td><a href="<?php echo URL('ta', 'id=' . $row['item'], 'index.php');?>" target="_blank"><?php echo URL('ta', 'id=' . $row['item'] , 'index.php');?></a></td>
   					  	<td><?php echo date('Y-m-d H:i:s', $row['add_time']);?></td>
						<td><a class="cancel-rec" href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableUser.resume','uid='.$row['item'], 'admin.php');?>','确认要解除屏蔽该用户吗?')" >取消屏蔽</a></td>
					</tr>
					<?php }} else {?>
					<tr><td colspan="5" align="center">没有搜索到相关数据</td></tr>
					<?php }?>
					</tbody>
				</table>
            </div>
        </div>       
    </div>
</div>
</body>
</html>
