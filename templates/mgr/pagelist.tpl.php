<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>页面设置 - 页面管理 - 界面管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：界面管理<span>&gt;</span>页面设置</p></div>
    <div class="main-cont">
        <h3 class="title">内置页面列表</h3>
		<div class="set-area">
		
        	<table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
            	<colgroup>
						<col class="w50"/>
                        <col class="w140" />
    					<col class="w60" />
    					<col />
    					<col class="w120" />
    			</colgroup>
                <thead class="tb-tit-bg">
  					<tr>
    					<th><div class="th-gap">编号</div></th>
    					<th><div class="th-gap">页面名称</div></th>
                        <th><div class="th-gap">类别</div></th>
                        <th><div class="th-gap">说明</div></th>
    					<th><div class="th-gap">操作</div></th>
  					</tr>
                </thead>
				<tfoot class="tb-tit-bg"></tfoot>
                <tbody>
<?php if (!empty($pages)):?>
	<?php
		$has_not_set = $natives = $customs = array();
		foreach ($pages as $p) {
			if(/*$p['page_id'] == 3 || */!$p['native']){
					$customs[] = $p;
			} else {
				if (in_array($p['page_id'], array(6,35))) {
					$has_not_set[] = $p;
				} else {
					$natives[] = $p;
				}
			}
		}
		$natives = array_merge($natives, $has_not_set);
		foreach($natives as $k => $p):
	?>
                	<tr>
    					<td><?php echo $k+1;?></td>
    					<td><?php echo F('escape', $p['page_name']);?></td>
                        <td><?php echo $p['native']?'内置':'自定义';?></td>
                        <td><?php echo F('escape', $p['desc']);?></td>
    					<td>
							<?php if (!in_array($p['page_id'], array(3,6,35,7,8))) {?>
							<a href="<?php echo URL('mgr/page_manager.setting', array('id'=>$p['page_id']));?>" class="icon-set">设置</a>
							<?php } elseif ($p['page_id'] == 7) { // 在线直播?>
							<a href="<?php echo URL('mgr/wb_live.set');?>" class="icon-set">设置</a>
							<?php } elseif ($p['page_id'] == 8) { // 在线访谈?>
							<a href="<?php echo URL('mgr/micro_interview.set');?>" class="icon-set">设置</a>
							<?php } else {echo '没有设置'; } ?>
    						<?php if(empty($p['native'])) {?><a href="javascript:delConfirm('<?php echo URL('mgr/page_manager.delPage', array('id'=>$p['page_id']));?>')" class="icon-del">删除</a> <?php }?>
    					</td>
  					</tr>
	<?php endforeach;?>
<?php endif;?>
                </tbody>
			</table>
    	</div>

		<h3 class="title"><a rel="e:addpage" class="btn-general"><span>创建新页面</span></a>自定义页面列表</h3>

		<div class="set-area">
			<table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
            	<colgroup>
						<col class="w50"/>
                        <col class="w150" />
    					<col class="w70" />
    					<col />
    					<col class="w120" />
    			</colgroup>
                <thead class="tb-tit-bg">
  					<tr>
    					<th><div class="th-gap">编号</div></th>
    					<th><div class="th-gap">页面名称</div></th>
                        <th><div class="th-gap">类别</div></th>
                        <th><div class="th-gap">说明</div></th>
    					<th><div class="th-gap">操作</div></th>
  					</tr>
                </thead>
				<tfoot class="tb-tit-bg"></tfoot>
                <tbody>
<?php if (!empty($pages)):?>
	<?php
		foreach($customs as $k=>$p):
	?>
                	<tr>
    					<td><?php echo $k+1;?></td>
    					<td><?php echo F('escape', $p['page_name']);?></td>
                        <td><?php echo $p['native']?'内置':'自定义';?></td>
                        <td><?php echo F('escape', $p['desc']);?></td>
    					<td>
							<?php if (!in_array($p['page_id'], array(6,35,7,8))) {?>
							<a href="<?php echo URL('mgr/page_manager.setting', array('id'=>$p['page_id']));?>" class="icon-set">设置</a>
							<?php }?>
    						<?php if(empty($p['native'])) {?><a href="javascript:delConfirm('<?php echo URL('mgr/page_manager.delPage', array('id'=>$p['page_id']));?>')" class="icon-del">删除</a> <?php }?>
    					</td>
  					</tr>
	<?php endforeach;?>
<?php endif;?>
                </tbody>
			</table>

            <p class="suggest-tips">*温馨提示：<br />Xweibo当中只有部分页面支持设置，如果某个页面设置之后，它的子页面会自动应用这些设置。 譬如，“我的微博”、“我的粉丝”属于“我的首页”的子页面，也会应用“我的首页”的设置。</p>
    	</div>

</div>
<script type="text/javascript">
Xwb.use("action").reg("addpage",function(e){
		Xwb.use('MgrDlg',{
		dlgcfg:{
			cs:'win-page win-fixed',
			title:'添加新的页面',
			destroyOnClose:true,
			onViewReady:function(view){
				var self=this;
				$(view).find('#pop_cancel').click(function(){
					self.close();
				})
			}
			}
		,valcfg:{
			form:'#addForm',
			trigger:'#submitBtn'
		}
		,modeUrl:"<?php echo URL('mgr/page_manager.createPageView');?>"
		,formMode:true
		});
		},{na:true});
</script>
</body>
</html>
