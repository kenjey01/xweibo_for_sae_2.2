<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>内容输出单元列表 - 组件设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：<span>组件扩展</span> &gt; <span>网站整合</span> &gt; <span>内容输出单元列表</span></div>
    <div class="set-wrap">
	<h4 class="main-title"><a class="btn-add" href="<?php echo URL('mgr/content_unit.show');?>"><span>添加新的单元</span></a>内容输出单元列表</h4>
		<div class="set-area-int">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
				<colgroup>
						<col class="operate-12" />
                        
    					<col />
    					<col class="operate-w13" />
                        <col class="operate-w16" />
    					<col class="operate-w11" />
    					
    				</colgroup>
            	<thead class="td-title-bg">
  					<tr>
    					<th class="serial-number"><div class="td-inside">编号</div></th>
    					<th><div class="td-inside">输出单元标题</div></td>
                        <th class="skincategory-name"><div class="td-inside">输出单元类型</div></th>
                        <th class="time-info"><div class="td-inside">最后更新日期</div></th>
    					<th class="operate-export"><div class="td-inside">操作</div></th>
  					</tr>
                </thead>
                <tfoot></tfoot>
                <tbody>
					<?php 
					$row = 1;
					foreach ($list as $item):					
					?>
                	<tr>
						<td><?php echo $row; $row++?></td>
						<td><?php echo F('escape', $item['unit_name']);?></td>
						<td><?php echo $unitType[(int)$item['type']]; ?></td>
						<td><?php echo date('Y-m-d H:i:s', $item['add_time']);?></td>
						<td><a class="delete" href="javascript:delConfirm('<?php echo URL('mgr/content_unit.del', 'id='.$item['id']);?>');">删除</a><a href="<?php echo URL('mgr/content_unit.set', 'id='.$item['id'].'&type='.$item['type']);?>" class="page-set">设置</a></td>
  					</tr>
					<?php endforeach;?>
                </tbody>
			</table>
    	</div>
    </div>
</div>
</body>
</html>
