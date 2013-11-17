<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告位列表 - 广告管理 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body>
<div class="main-body">
	<div class="path"><p>当前位置：界面管理<span>&gt;</span>广告</p></div>
	<div class="main-cont">
		<h3 class="title"> 广告位列表</h3>
		<div class="set-area">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
					<colgroup>
						<col class="w50" />
    					<col/>
    					<col class="w120"/>
						<col class="w120"  />
						<col class="w150" />
    				</colgroup>
                    <thead class="tb-tit-bg">
					<tr>
						<th><div class="th-gap">编号</div></th>
						<th><div class="th-gap">广告位</div></th>
   					  	<th><div class="th-gap">广告投放范围</div></th>
						<th><div class="th-gap">广告位状态</div></th>
   					  	<th><div class="th-gap">操作</div></th>
				  	</tr>
              		</thead>
                    <tfoot class="tb-foot-bg"></tfoot>
                	<tbody>
					<?php if (isset($data) && is_array($data)) {foreach($data as $index => $row) {?>
				  	<tr>
   					  	<td><?php echo $index + 1;?></td>
   					  	<td><?php echo $row['name'];?></td>
   					  	<td><?php echo $row['description'];?></td>
   					  	<td><?php echo $row['using']?'启用中':'已禁用';?></td>
						<td class="mod-td">
									<a href="<?php echo URL('mgr/ad.edit', 'id='. $row['id'] , 'admin.php')?>" class="icon-set">设置</a>
									<a href="javascript:delConfirm('<?php echo URL('mgr/ad.stateChg', 'id='. $row['id'] . '&state='.(int)!(int)$row['using'] , 'admin.php')?>', '确认要改变该状态吗?')" class="icon-forbid"><?php echo $row['using']?'禁用':'启用';?></a>
								
						</td>
					</tr>
					<?php }}?>
					</tbody>
				</table>
            </div>
			
     
   </div>
</div>
</body>
</html>
