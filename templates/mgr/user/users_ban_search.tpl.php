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
        <h4 class="main-title">封禁指定用户</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请输入昵称搜索用户，然后选择相应的封禁操作。注意：封禁后此用户将无法登录使用微博功能。<a href="<?php echo URL('mgr/users.getBanUser');?>">查看封禁用户列表</a></p>
            	<div class="serch-user">
            		<form action="<?php echo URL('mgr/users.searchAllBanUser');?>" method="post">
            			<span><strong>搜索包含以下昵称的用户</strong></span>
                		<span><input name="keyword" class="input-txt box-address-width" type="text"  value="<?php echo F('escape', strval(V('r:keyword')));?>" /></span>
                		<span class="serch-btn"><input name="" type="submit" value="搜索" /></span>
                    </form>
           		</div>
                
					<?php if(!V('r:keyword', false)):?>

					<?php elseif(isset($list) && is_array($list) && !empty($list)):?>
						<ul class="serch-results">
						<?php $i=1;foreach($list as $value):?>
							<?php if($i==1):$i++;?><li class="result-line-no"><?php else:?><li class="result-line"><?php endif;?>
								<div class="results-l">
									<p class="results-name"><?php echo $value['screen_name'];?></p>
									<p><span><?php echo $value['location'];?></span>粉丝数：<?php echo $value['followers_count'];?>人</span></p>
								</div>
								<div class="results-r">
									<?php if($value['is_ban']):?>
										<span>已封禁</span>
										<a href="<?php echo URL('mgr/users.ban', 'id=' . $value['id'] . '&ban=0&p=ban');?>" class="unban">解除封禁</a>
									<?php else:?>
										<a href="<?php echo URL('mgr/users.ban', 'id=' . $value['id'] . '&ban=1&p=ban');?>" class="ban">确认封禁</a>
									<?php endif;?>
								</div>
							</li>
						<?php endforeach;?>
						</ul>
					 <?php else:?>
					 <div class="serch-results-no">没有搜索到相关结果</div>
				 <?php endif;?>                
            </div>
        </div>
        <!--<h4 class="main-title">封禁用户列表</h4>
		<div class="set-area-int">
			<div class="user-list">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
					<thead class="td-title-bg">
					<tr>
						<td class="serial-number">编号</td>
   					  	<td class="user-name">用户昵称</td>
   					  	<td>微博地址</td>
   					  	<td class="time-info">封禁时间</td>
   					  	<td class="prohibit-opration">操作</td>
				  	</tr>
              		</thead>
              		<tfoot class="tfoot-bg">
					<tr>
						<td colspan="5">
                        <div class="pre-next">
                        	<form name="form" id="form"><div>
                            	<a class="pre" href="">上一页</a><a class="next" href="">下一页</a></div>
						    	<select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
						      		<option>1/2</option>
                              		<option>2/2</option>
					        	</select>
				        	</form>
                        </div>
                        </td>
					</tr>
              		</tfoot>
                	<tbody>
                    <tr>
   					  	<td>1</td>
   					  	<td>james</td>
   					  	<td><a href="">http://weibo.com</a></td>
   					  	<td>2010-10-10 18：30</td>
						<td><a href="" class="view-weibo">查看微博</a><a href="" class="unban">解封</a></td>
					</tr>
                    <tr>
   					  	<td>2</td>
   					  	<td>james</td>
   					  	<td><a href="">http://weibo.com</a></td>
   					  	<td>2010-10-10 18：30</td>
						<td><a href="" class="view-weibo">查看微博</a><a href="" class="unban">解封</a></td>
					</tr>
                    <tr>
   					  	<td>3</td>
   					  	<td>james</td>
   					  	<td><a href="">http://weibo.com</a></td>
   					  	<td>2010-10-10 18：30</td>
						<td><a href="" class="view-weibo">查看微博</a><a href="" class="unban">解封</a></td>
					</tr>
                    <tr>
   					  	<td>4</td>
   					  	<td>james</td>
   					  	<td><a href="">http://weibo.com</a></td>
   					  	<td>2010-10-10 18：30</td>
						<td><a href="" class="view-weibo">查看微博</a><a href="" class="unban">解封</a></td>
					</tr>
                    <tr>
   					  	<td>5</td>
   					  	<td>james</td>
   					  	<td><a href="">http://weibo.com</a></td>
   					  	<td>2010-10-10 18：30</td>
						<td><a href="" class="view-weibo">查看微博</a><a href="" class="unban">解封</a></td>
					</tr>
					</tbody>
				</table>
            </div>
        </div>-->
    </div>
</div>
</body>
</html>
