<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个性化域名-系统设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">
	$(function(){
		var bLock = 1,
			Box = Xwb.ui.MsgBox,
			Req = Xwb.request;
		$('#BackupBnt').click(function(){
			if(bLock == 0) return false;
			bLock = 0;
			Box.confirm('提示','确认要备份吗？',function(id){
				if(id == 'ok'){
					$('#BackupBnt span').html('备份中...');
					Req.postReq(Req.mkUrl('mgr/backup','backupData'),{},function(e){
						if(e.isOk()){
							location.reload();
						} else {
							Box.alert('提示',e.getMsg());
							$('#BackupBnt span').html('备份');
						}
						bLock =1;
					});
				} else {
					bLock =1;
				}
			});
			return false;
		});
		$('a[name="restore"]').click(function(){
			if(bLock == 0) return false;
			bLock = 0;
			var sthis = $(this);
			Box.confirm('提示','确认还原 '+$(this).attr('rel')+' 的备份吗？',function(id){
				if(id == "ok"){
					Req.postReq(Req.mkUrl('mgr/backup','restore'),{name:sthis.attr('rel')},function(e){
						if(e.isOk()){
							top.location.href = Req.mkUrl('mgr/admin','logout');
						} else {
							Box.alert('提示',e.getMsg());
						}
						bLock =1;
					});
				} else {
					bLock =1;
				}
			});
			return false;
		});
		$('#selectAll').click(function(){
			$('#dataTable input[type="checkbox"]').attr('checked',this.checked);
		});
		$('#removeAll').click(function(){
			var flags = [],input = $('#dataTable input[type="checkbox"]:checked');
			if( input.length == 0 ) { Box.alert('提示','请选择要删除的项'); return false;}
			input.each(function(){
				flags.push(this.value);
			});
			if(bLock == 0) return false;
			bLock = 0;
			Box.confirm('提示','确认要执行批量删除操作吗',function(id){
				if(id == "ok"){
					Req.postReq(Req.mkUrl('mgr/backup','remove'),{flags:flags.join(',')},function(e){
						if(e.isOk()){
							location.reload();
						} else {
							Box.alert('提示',e.getMsg());
						}
						bLock =1;
					});
				} else {
					bLock =1;
				}
			});
			return false;
		});
	});
</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>数据库备份还原</p></div>
    <div class="main-cont">
    	<h3 class="title">备份</h3>
    	<div class="set-area">
			<div class="form-s1">
				<ul>
					<li>1.数据备份会备份你的xweibo所有的数据库数据，你可以在通过数据恢复还原备份的数据</li>
					<li>2.备份的数据不包括模板文件以及用户上传的附件等</li>
					<li>3.如果你想要备份附件，请通过ftp下载</li>
					<li>4.数据库备份默认放在var/backup目录下</li>
				</ul>
                
                <div class="btn-area"><a class="btn-general highlight" href="#" id="BackupBnt"><span>备份</span></a></div>
            </div>
		</div>
		<h3 class="title">还原</h3>
		<div class="set-area">
			<p class="tips">本功能在恢复备份数据的同时，将全部覆盖原有数据，且在还原期间会导致xweibo不能正常访问。</p>
		</div>
		
		<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" id="dataTable">
            		<colgroup>
						<col class="w50">
						<col>
                        <col class="w150"/>
    					<col class="w150">
    					<col class="w100">
    				</colgroup>
                    <thead class="tb-tit-bg">
  						<tr>
    						<th></th>
    						<th><div class="th-gap">文件名</div></th>
    						<th><div class="th-gap">时间</div></th>
    						<th><div class="th-gap">大小</div></th>
                            <th><div class="th-gap"></div></th>
  						</tr>
                	</thead>
                	<tfoot class="td-foot-bg">
                    	<tr>
                    		<td colspan="5">
                            	<span class="check-all"><input type="checkbox" id="selectAll" value="" class="ipt-checkbox">全选</span>
                                <a  href="#" id="removeAll" class="btn-general highlight"><span>批量删除</span></a>
                            </td>
                   		</tr>
                    </tfoot>
                    <tbody>
					<?php if (isset($records) && is_array($records) && !empty($records)) {
						$count = count($records);
						for ($i=$count-1; $i>=0; $i--) {
							$row = $records[$i];
						?>
						<?php $row = explode('|', $row);?>
  						<tr>
    						<td><input type="checkbox" value="<?php echo $row[0];?>"/></td>
    						<td><?php echo $row[0];?></td>
    						<td><?php echo $row[2];?></td>
                            <td><?php echo round($row[1]/1024/1024,2);?> M</td>
    						<td><a class="icon-recall" name = "restore" rel="<?php echo $row[0];?>" href="#">还原</a></td>
                        </tr>
					<?php }} else {?>
						<tr><td colspan="5"><p class="no-data">你还没有进行过备份操作</p></td></tr>        
					<?php }?>         
                    </tbody>
                </table>
		
	</div>
</body>
</html>
