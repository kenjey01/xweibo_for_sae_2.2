<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>功能插件 - 组件 - 组件扩展</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body class="main-body">
	<div class="path"><span class="path-icon"></span>当前位置：组件扩展<span> &gt; </span>组件<span> &gt; </span>功能插件</div>
    <div  class="main-cont">
        <h3 class="title">功能插件</h3>
		<div class="set-area">
        	<table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
            	<colgroup>
						<col class="w70"/>
                        <col class="w150" />
    					<col class="w80" />
    					<col />
    					<col class="w170" />
    			</colgroup>
                <thead class="tb-tit-bg">
  					<tr>
    					<th><div class="th-gap">编号</div></th>
    					<th><div class="th-gap">插件名称</div></th>
                        <th><div class="th-gap">状态</div></th>
                        <th><div class="th-gap">简介</div></th>
    					<th><div class="th-gap">操作</div></th>
  					</tr>
                </thead>
                <tbody>
<?php
	$row = 1;
	foreach ($plugins as $p) {
?>
                	<tr>
    					<td><?php echo $row;?></td>
    					<td><?php echo F('escape', $p['title']);?></td>
                        <td><?php if($p['in_use']):?>已<?php else:?>未<?php endif;?>开启</td>
                        <td><?php echo F('escape', $p['desc']);?></td>
    					<td>
                        	<?php if (!$p['in_use']):?>
								<a class="icon-plug-on" href="<?php echo URL('mgr/plugins.setStatus', array('id' => $p['plugin_id'], 'inuse' => 1));?>">开启插件</a>
							<?php else:?>
								<a class="icon-plug-off" href="<?php echo URL('mgr/plugins.setStatus', array('id' => $p['plugin_id'], 'inuse' => 0));?>">关闭插件</a>
							<?php endif;?>
							
							<?php if ( !in_array($p['plugin_id'], array(5,6)) ) { // 数据备份 和 用户反馈意见 不需要设置  ?>
                            <a class="icon-set" href="<?php echo URL('mgr/plugins.config', array('id' => $p['plugin_id']));?>">设置</a>
                            <?php } ?>
                            
							</td>
  					</tr>
<?php
	$row++;
	}
?>
                </tbody>
			</table>
    	</div>
    </div>
</body>
</html>
