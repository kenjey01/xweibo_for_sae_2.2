<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>意见反馈 - 其它 - 运营管理</title>
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
			var tdMar = $(this).parent().prev('div');
			if(tdMar.height() == 60){
				tdMar.css({'height':'','overflow':''});
			} else {
				tdMar.css({'overflow':'hidden','height':'60px'});
			}
			if($(this).html()=="更多&gt;&gt;") $(this).html("收起&gt;&gt");
			else $(this).html("更多&gt;&gt");
		})
	});	
});
})(jQuery);


</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>意见反馈</p></div>
    <div class="main-cont">
        <h3 class="title">意见反馈</h3>
		<div class="set-area">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
				<colgroup>
					<col class="w70" />
					<col />
					<col class="w140" />
					<col class="w170" />
					<col class="w100" />
				</colgroup>
				<thead class="tb-tit-bg">
					<tr>
						<th><div class="th-gap">编号</div></th>
						<th><div class="th-gap">反馈内容</div></th>
						<th><div class="th-gap">时间</div></th>
						<th><div class="th-gap">联系方式</div></th>
						<th><div class="th-gap">操作</div></th>
					</tr>
				</thead>
				<tfoot class="tb-tit-bg">
					<tr>
						<td colspan="5">
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
						<td><?php echo $offset + $key+1;?></td>
						<td class="td-hover">
							<div class="td-mar td-unfold">
								<?php 
								echo htmlspecialchars($row['content']);  
								?>
							</div>
							<p class="fold-cotrol"><a href="#this"  name="show" class="hidden">更多&gt;&gt;</a></p>
						</td>
						<td><?php echo date('Y-m-d H:i', $row['addtime']);?></td>
						<td><div class="td-nowrap">
							<?php if (!empty($row['nickname']) && $row['uid'] > 0) {echo htmlspecialchars($row['nickname']);} else echo '游客'?>
							<?php if (!empty($row['mail']))echo '<br />E-mail:'.htmlspecialchars($row['mail']);?>
							<?php if (!empty($row['qq']))echo '<br />QQ:'.htmlspecialchars($row['qq']);?>
							<?php if (!empty($row['tel']))echo '<br />电话:' . htmlspecialchars($row['tel']);?></div>
						</td>
						<td>
							<a class="icon-del" href="javascript:delConfirm('<?php echo URL('mgr/feedback.del', 'id=' . $row['id'], 'admin.php');?>','确认要删除该信息吗');">删除</a></td>
					</tr>
				<?php }} else {?>
					<tr><td colspan="5"><p class="no-data">搜索不到任何数据</p></td></tr>
				<?php }?>
				</tbody>
			</table>
            
        </div>       
    </div>
    <script type="text/javascript">
    	$('.td-hover').each(function(){
			var obj = $(this);
			var del = obj.children('.fold-cotrol').find('a'),tdMar = obj.find('.td-mar');
			if(tdMar.height() > 60) {
				tdMar.css({'overflow':'hidden','height':'60px'});
				obj.hover(function(){
					del.removeClass('hidden');			   
				},function(){
					del.addClass('hidden');			
				});
			}
		});
    </script>
</body>
</html>
