<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微博屏蔽 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
$(function() {
			bindSelectAll('#selectAll','#recordList > tr > td input[type=checkbox]');
			Xwb.use('Validator',{
				form : '#postForm',
				trigger : '#submitBnt'
			});
});

function delSelectedConfirm() {
	var v = getSelectedValues('#recordList > tr > td input[type=checkbox]');
	if (!v) {
		Xwb.ui.MsgBox.alert('提示','至少选择一项');
		return;
	}
	var url = '<?php echo URL('mgr/weibo/disableWeibo.resume', 'id=', 'admin.php');?>' + v;
	delConfirm(url, '确认要恢复所有选中的关键字吗?');
}
</script>
</head>
<body>
<div class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>已屏蔽的微博</p></div>
    <div class="main-cont">
    	<div class="tab-box">
            <h5 class="tab-nav tab-nav-s1 clear">
                <a href="<?php echo URL('mgr/weibo/weiboCopy.weiboList');?>"><span>本站微博</span></a>
                <a href="<?php echo URL('mgr/weibo/disableComment.search');?>"><span>指定微博搜索</span></a>
                <a class="current" href="<?php echo URL('mgr/weibo/disableWeibo.weiboList');?>"><span>已屏蔽微博</span></a>
                <a href="<?php echo URL('mgr/weibo/disableComment.commentList');?>"><span>已屏蔽评论</span></a>
            </h5>
            <div class="tab-con-s1">
				<div class="set-area">
                    <div class="search-area ">
                        <form id="postForm" method="post" action="<?php echo URL('mgr/weibo/disableWeibo.weiboList');?>">
                            <div class="item">
                                <label>搜索包含以下关键字的微博：</label>
                                <input name="keyword" class="ipt-txt w120" type="text" value="<?php echo V('r:keyword');?>" vrel="_f|ne" warnTip="#keyTip"/>
                                <a class="btn-general" href="" id="submitBnt"><span>搜索</span></a>
                                <span class="tips-error hidden" id="keyTip">该项不能为空</span>
                            </div>
                        </form>
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                        <colgroup>
                            <col class="w50">
                            <col class="w50">
                            <col/>
                            <col class="w100">
                            <col class="w140">
                            <col class="w100">
                            <col class="w140">
                        </colgroup>
                        <thead class="tb-tit-bg">
                            <tr>
                                <th><div class="th-gap"></div></th>
                                <th><div class="th-gap">编号</div></th>
                                <th><div class="th-gap">微博内容</div></th>
                                <th><div class="th-gap">作者</div></th>
                                <th><div class="th-gap">屏蔽时间</div></th>
                                <th><div class="th-gap">操作者</div></th>
                                <th><div class="th-gap">操作</div></th>
                            </tr>
                        </thead>
                        <tfoot class="td-foot-bg">
                            <tr>
                                <td colspan="7">
                                
                                    <div class="pre-next">
                                    <?php if (is_array($list) && !empty($list)) { ?>
                                    <?php echo $pager;?>
                                    <?php }?>	
                                    </div>
                                    <span class="check-all"><input id="selectAll" class="ipt-checkbox" type="checkbox" value="">全选</span>
                                    <a href="javascript:delSelectedConfirm()">恢复所选的微博</a>
                                    </td>
                            </tr>
                        </tfoot>
                        <tbody id="recordList">
                        <?php if (is_array($list) && !empty($list)) {foreach ($list as $key => $row) {?>
                            <tr>
                                <td><input name="1" type="checkbox" value="<?php echo $row['kw_id']?>" /></td>
                                <td><?php echo $offset + $key + 1;?></td>
                                <td><?php echo htmlspecialchars($row['comment'])?></td>
                                <td><?php echo htmlspecialchars($row['user']);?></td>
                                <td><?php echo date('Y-m-d H:i:s', $row['add_time']);?></td>
                                <td><?php echo htmlspecialchars($row['admin_name']);?></td>
                                <td><a class="icon-shield" href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableWeibo.resume', 'id=' . $row['kw_id'], 'admin.php');?>','确认要恢复该微博吗');">恢复</a></td>
                            </tr>
                        <?php }} else {?>
                            <tr><td colspan="7"><p class="no-data">搜索不到任何数据</p></td></tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>     
            </div>
        </div>       
    </div>
</div>
</body>
</html>
