<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>话题推荐管理 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
function openPop(url,title) {
	
		Xwb.use('MgrDlg',{
		modeUrl:url,
		formMode:true,
		valcfg:{
			form:'AUTO',
			trigger:'#pop_ok'
		},
		dlgcfg:{
			cs:'win-topic win-fixed',
			onViewReady:function(View){
				var self=this;
				$(View).find('#pop_cancel').click(function(){
					self.close();
				})
			},
			title:title,
			destroyOnClose:true
			
		}
	})
	
};
$(function() {
			bindSelectAll('#selectAll','#recordList > tr > td > div > input[type=checkbox]');
			});
function delSelectedConfirm() {
	var v = getSelectedValues('#recordList > tr > td > div > input[type=checkbox]');
	if (!v) {
		alert('最少选中其中一项');
		return;
	}
	var url = '<?php echo URL('mgr/weibo/todayTopic.delete', 'id=', 'admin.php');?>' + v;
	delConfirm(url, '确认要恢复所有选中的关键字吗?');
}
<?php
if ($category['sort'] == '1') {
	// 允许排序
	echo 'var sort_allow = true;';
}
?>

</script>
</head>
<body  class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span><a href="<?php echo URL('mgr/weibo/todayTopic.category'); ?>">话题</a><span>&gt;</span><?php echo $category['topic_name']?>管理</p></div>
    <div class="main-cont">
        <h3 class="title">
			<a class="btn-general" href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.edit', 'topic_id=' . V('g:category'));?>','添加新话题');"><span>添加新话题</span></a>
<?php if ($category['sort']): ?>
			<a class="change-order" href="#" id="modifyBtn"></a>
			<a class="save-order hidden" href="#" id="saveBtn"></a>
<?php endif;?>
			<?php echo $category['topic_name']?>
		</h3>
		<div class="set-area" id="userList">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" id="tblZoom">
                <colgroup>
                    <col class="w50" />
                    <col class="w70" />
                    <col />
                    <col class="h-150" />
                    <col class="w140" />
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap"></div></th>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">话题内容</div></th>
                        <th><div class="th-gap"><?php if (V('g:category') == '1') {?>添加<?php } else {?>生效<?php }?>时间</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg">
                    <tr>
                        <td colspan="5">
                            <div class="pre-next">
                                <?php echo isset($pager)?$pager:'';?>
                            </div>
                            <input class="ipt-checkbox" name="slectALL" id="selectAll" type="checkbox" value="" />全选
                            <a class="del-all" href="javascript:delSelectedConfirm()">将所选话题从列表中删除</a>
                        </td>
                    </tr>
                </tfoot>
                <tbody class="order-main" id="recordList">
                <?php if (!empty($list) && is_array($list)) { foreach($list as $key => $row) {?>
                    <tr rel="<?php echo $offset + $row['id'];?>">
                        <td>
                            <span class="range-icon"></span>
                            <div class="default"><input name="1" type="checkbox" value="<?php echo $row['id'];?>" /></div>
                        </td>
                        <td><?php echo $offset + $key +1;?></td>
                        <td><?php echo htmlspecialchars($row['topic']);?></td>
                        <td><?php echo date('Y-m-d H:i:s', $row[V('g:category') == '1' ?'date_time':'ext1']);?></td>
                        <td>
                            <a class="icon-edit" title="编辑" href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.edit', 'id=' . $row['id']);?>','编辑新话题')">编辑</a>
                            <a class="icon-del" title="删除" href="javascript:delConfirm('<?php echo URL('mgr/weibo/todayTopic.delete', 'id=' . $row['id']);?>')">删除</a>
                        </td>
                    </tr>
                <?php  }} else {?>
                    <tr><td colspan="5"><p class="no-data">尚没有数据，请<a href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.edit', 'topic_id=' . V('g:category'));?>','添加新话题');">添加新话题</a></p></td></tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
<div class="win-pop win-fixed win-topic hidden" id="pop_window"></div>
<div id="pop_mask" class="mask hidden"></div>
<script type="text/javascript">

<?php if ($category['sort']): ?>
var zoom = new OrderRowZoom($('#tblZoom')[0], {
        url:'<?php echo URL('mgr/weibo/todayTopic.saveOrder', array('lid' => $category['topic_id']));?>',
        modifyBtn : '#modifyBtn',
        saveBtn   : '#saveBtn',
        paramName : 'ids'
    });
<?php endif;?>
</script>

</body>
</html>
