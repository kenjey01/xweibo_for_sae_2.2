<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活动列表 - 活动管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>js/datepick/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/datepick/jquery.datepick.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
(function($){
$(function() {
	bindSelectAll('#selectAll','#recordList > tr > td > input[type=checkbox]');
});

function delSelectedConfirm() {
	var v = getSelectedValues('#recordList > tr > td > input[type=checkbox]');
	if (!v) {
		alert('最少选中其中一项');
		return;
	}
	var url = '<?php echo URL('mgr/weibo/disableWeibo.resume', 'id=', 'admin.php');?>' + v;
	delConfirm(url, '确认要恢复所有选中的关键字吗?');
}

$(function() {
	$('#start,#end').datepick({
		dateFormat: 'yy-mm-dd',
		showAnim: 'fadeIn'
	});
	<?php if (in_array(V('r:disabled', 'all'), array(1,0,'all')) ) {?>
	$('#disabled').val('<?php echo V('r:disabled', 'all');?>');
	<?php }?>
	$('a[name="show"]').each(function(){ 
		$(this).click(function(){
			$(this).parent().prev('div').toggleClass('td-inside-pos');
			if($(this).html()=="展开") $(this).html("隐藏");
			else $(this).html("展开");
		})
	});
	
	$('.td-hover').each(function(){
		var obj = $(this);
		var del = obj.children('.func-para').find('a');
		obj.hover(function(){
			del.removeClass('hidden');			   
		},function(){
			del.addClass('hidden');			
		});
	});
	
});
})(jQuery);


</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>活动管理</p></div>
    <div class="main-cont">
        <h3 class="title">活动管理</h3>
		<div class="set-area">
			<div class="search-area">
				<form method="get" action="" id="searchForm">
                	<div class="item">
                    	<label><strong>搜索活动</strong></label>
                        <input name="keyword" class="ipt-txt w200" type="text" value="<?php echo F('escape', V('r:keyword'));?>" />
                        <select name="state" class="select form-el-w5">
                            <option value="">全部</option>
                            <?php foreach ($states as $k=>$v) {?>
                                <option value="<?php echo $k?>" <?php if ($k == V('r:state')) { ?>selected<?php }?>><?php echo $v?></option>
                            <?php }?>
                        </select>
                        <input type="hidden" name="m" value="mgr/events.getList" />
                        <a href="javascript:$('#searchForm').submit();" class="btn-general"><span>搜索</span></a>
                    </div>
				</form>
			</div>

			<table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
				<colgroup>
					<col />
					<col class="w100" />
					<col class="w150" />
					<col class="w80" />
					<col class="w80" />
					<col class="w150" />
				</colgroup>
				<thead class="tb-tit-bg">
					<tr>
						<th><div class="th-gap">活动名称</div></th>
						<th><div class="th-gap">创建人</div></th>
						<th><div class="th-gap">有效时间</div></th>
						<th><div class="th-gap">参与人数</div></th>
						<th><div class="th-gap">活动状态</div></th>
						<th><div class="th-gap">操作</div></th>
					</tr>
				</thead>
				<tfoot class="tb-tit-bg">
					<tr>
						<td colspan="6">
							<div class="pre-next">
							<?php if (isset($list) && is_array($list) && !empty($list)) { ?>
							<?php echo $pager;?>
							<?php }?>	
							</div>
						</td>
					</tr>
				</tfoot>
				<tbody id="recordList">
				<?php if (isset($list) && is_array($list) && !empty($list)) {foreach ($list as $key => $row) {?>
					<tr>
						<td><a href="<?php echo URL('event.details','eid=' . $row['id'], 'index.php');?>" target="_blank"><?php echo htmlspecialchars($row['title']);?></a></td>
						<td><a href="<?php echo URL('ta','id=' . $row['sina_uid'], 'index.php');?>" target="_blank"><?php echo htmlspecialchars($row['nickname']);?></a></td>
						<td><?php echo date('Y-m-d H:i', $row['end_time']);?></td>
						<td><a href="<?php echo URL('event.member','eid='.$row['id'], 'index.php');?>" target="_blank"><?php echo $row['join_num'] * 1;?></a></td>
						<td><?php echo isset($row['state_num'])? $states[$row['state_num']]: 0?></td>
						<td>
							<?php if ($row['state'] == '2') {?>
								<a>已关闭</a>
							<?php } else {?>
							<?php if ($row['state'] == '3') {?>
							<a  class="icon-unban" href="javascript:delConfirm('<?php echo URL('mgr/events.setState', 'id='.$row['id'] . '&state=1');?>','确认要解封该活动吗?');">解封</a>
							<?php } else {?>
								<a class="icon-ban" href="javascript:delConfirm('<?php echo URL('mgr/events.setState', 'id='.$row['id'] . '&state=3');?>','确认要封禁该活动吗?')">封禁</a>
							<?php }?>
							<?php if ($row['state'] == '4') {?>
								<a class="icon-unrecommend" href="javascript:delConfirm('<?php echo URL('mgr/events.setState', 'id='.$row['id'] . '&state=1');?>','确认要取消推荐吗?');">取消推荐</a>
							<?php } else {?>
								<a  class="icon-recommend"href="javascript:delConfirm('<?php echo URL('mgr/events.setState', 'id='.$row['id'] . '&state=4');?>','确认要推荐该活动吗?');">推荐</a>
							<?php }?>
							<?php }?>
					</tr>
				<?php }} else {?>
					<tr><td colspan="6"><p class="no-data">搜索不到任何数据</p></td></tr>
				<?php }?>
				</tbody>
			</table>
            
        </div>       
    </div>
</body>
</html>
