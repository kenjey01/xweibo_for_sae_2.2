<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>封禁用户 - 用户管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>用户<span> &gt; </span>封禁用户</div>
    <div class="set-wrap">
        <h4 class="main-title">封禁用户列表</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请输入昵称搜索已封禁的用户，然后选择相应的解封操作。<a href="<?php echo URL('mgr/users.searchAllBanUser');?>">封禁指定用户</a></p>
            	<div class="serch-user">
					<form action="<?php echo URL('mgr/users.getBanUser');?>" method="post">
            			<span><strong>搜索包含以下昵称的用户</strong></span>
                		<span><input name="keyword" class="input-txt box-address-width" type="text" /></span>
                		<span class="serch-btn"><input name="submit" type="submit" value="搜索" /></span>
                    </form>
           		</div>
            </div>
			<div class="user-list">
			  
				<table border="0" cellpadding="0" cellspacing="0" class="table">
					<colgroup>
						<col class="serial-number"/>
                        <col class="user-name" />
    					<col />
    					<col class="t-time"/>
    					<col class="operate-w5"/>
    				</colgroup>
                    <thead class="td-title-bg">
					<tr>
						<th><div class="td-inside">编号</div></th>
   					  	<th><div class="td-inside">用户昵称</div></th>
   					  	<th><div class="td-inside">微博地址</div></th>
   					  	<th><div class="td-inside">封禁时间</div></th>
   					  	<th><div class="td-inside">操作</div></th>
				  	</tr>
              		</thead>
              		<tfoot class="tfoot-bg">
					<tr>
						<td colspan="5">
					
                        	<div class="pre-next">
								<?php echo $pager;?>
                        	</div>
						
                        </td>
					</tr>
              		</tfoot>
                	<tbody>
					<?php if($list):?>
					  <?php foreach($list as $value):?>
						<tr>
							<td><?php echo ++$num;?></td>
							<td><?php echo $value['nick'];?></td>
							<td><a href="<?php echo URL('ta', 'id='.$value['sina_uid'], 'index.php');?>" target="_blank">
									<?php echo W_BASE_HTTP . URL('ta', 'id='.$value['sina_uid'], 'index.php');?>
								</a>
							
							</td>
							<td><?php echo date('Y-m-d H:i:s', $value['ban_time']);?></td>
							<td><a href="<?php echo URL('ta', 'id='.$value['sina_uid'], 'index.php');?>" class="view-weibo" target="_blank">查看微博</a><a href="<?php echo URL('mgr/users.ban', 'id=' . $value['sina_uid'] . '&ban=0&p=ban');?>" class="unban">解封</a></td>
						</tr>
					  <?php endforeach;?>
					<?php else:?>
						<tr><td colspan="5"><p class="no-data">没有搜索到相关结果</p></td></tr>
					<?php endif;?>
					</tbody>
				</table>
            </div>
        </div>       
    </div>
</div>
</body>
</html>
