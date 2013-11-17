<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微博管理 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>js/datepick/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/datepick/jquery.datepick.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
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
		'dateFormat':'yy-mm-dd',
		'dayNames':['日','一','二','三','四','五','六'],
		'dayNamesMin':['日','一','二','三','四','五','六'],
		'dayNamesShort':['日','一','二','三','四','五','六'],
		'monthNames':['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
		'monthNamesShort':['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
		'prevText':'上一月',
		'nextText':'下一月',
		'currentText':'今天',
		'closeText':'关闭',
		'clearText':'清空'
	});
	<?php if (in_array(V('r:disabled', 'all'), array(1,0,'all')) ) {?>
	$('#disabled').val('<?php echo V('r:disabled', 'all');?>');
	<?php }?>

	$('#disable_batch').click(function(){
		var v = getSelectedValues('#recordList > tr > td > input[type=checkbox]');
		if (!v) {
			alert('最少选中其中一项');
			return;
		}
		var url = '<?php echo URL('mgr/weibo/disableWeibo.disableBatch', 'id=', 'admin.php');?>' + v;
		delConfirm(url, '确认要执行该操作吗？');
	});
})
</script>
<?php $isBatch = (V('r:disabled')!='1') && (isset($list) && is_array($list) && !empty($list)); ?>

</head>
<body class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>本站微博</p></div>
    <div class="main-cont">
    	<div class="tab-box">
            <h5 class="tab-nav tab-nav-s1 clear">
                <a class="current" href="<?php echo URL('mgr/weibo/weiboCopy.weiboList');?>"><span>本站微博</span></a>
                <a href="<?php echo URL('mgr/weibo/disableComment.search');?>"><span>指定微博搜索</span></a>
                <a href="<?php echo URL('mgr/weibo/disableWeibo.weiboList');?>"><span>已屏蔽微博</span></a>
                <a href="<?php echo URL('mgr/weibo/disableComment.commentList');?>"><span>已屏蔽评论</span></a>
            </h5>
            <div class="tab-con-s1">
                <div class="set-area" >
                    <div class="search-area">
                        <form method="get" action="admin.php" id="searchForm">
                            <div class="item">
                                <label for="disabled"><strong>搜索范围</strong></label>
                                <select name="disabled" id="disabled" class="select w100">
                                    <option value="all">全部微博</option>
                                    <option value="0">没被屏蔽的</option>
                                    <option value="1">已被屏蔽的</option>
                                </select>
                                <label for="start"><strong>时间</strong></label>
                                <input type="text" name="start" id="start" readonly="readonly" value="<?php echo V('r:start','')?>" class="ipt-txt w70" />&nbsp;&nbsp;--&nbsp;&nbsp;<input type="text" name="end" id="end"  readonly="readonly" class="ipt-txt w70" value="<?php echo V('r:end','')?>"/>
                                <label><strong>关键字</strong></label>
                                <input name="keyword" class="ipt-txt w120" type="text" value="<?php echo V('r:keyword');?>" />
                                <input name="m" type="hidden" value="<?php echo 'mgr/weibo/weiboCopy.weiboList';?>" />
                                <a href="javascript:$('#searchForm').submit();" class="btn-general"><span>搜索</span></a>
                            </div>
                        </form>
                    </div>
        
                    <div class="user-list">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                            <colgroup>
                            	<?php if ($isBatch) {echo '<col class="w50" />'; } ?>
                                <col />
                                <col class="w90" />
                                <col class="w70" />
                                <col class="w70" />
                                <col class="w150" />
                                <col class="w70" />
                                <col class="w140" />
                            </colgroup>
                            <thead class="tb-tit-bg">
                                <tr>
                                	<?php if ($isBatch) {echo '<th><div class="th-gap"></div></th>'; } ?>
                                    <th><div class="th-gap">微博内容</div></th>
                                    <th><div class="th-gap">作者</div></th>
                                    <th><div class="th-gap">转发</div></th>
                                    <th><div class="th-gap">评论</div></th>
                                    <th><div class="th-gap">发布时间</div></th>
                                    <th><div class="th-gap">状态</div></th>
                                    <th><div class="th-gap">操作</div></th>
                                </tr>
                            </thead>
                            <tfoot class="td-foot-bg">
                                <tr>
                                    <td colspan="<?php echo $isBatch ? '8' : '7'; ?>">
                                        <div class="pre-next">
                                        <?php if (isset($list) && is_array($list) && !empty($list)) { echo $pager; }?>	
                                        </div>
                                         <?php if ($isBatch) { ?><span class="check-all"><input class="ipt-checkbox" type="checkbox" value="" id="selectAll">全选</span>
                                         <a class="btn-general highlight" href="" id="disable_batch"><span>屏蔽</span></a><?php } ?>
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody id="recordList">
                            <?php if (isset($list) && is_array($list) && !empty($list)) {foreach ($list as $key => $row) {?>
                            <?php if(!F('user_action_check',array(3),$row['uid'])){?>
                                <tr>
                                	<?php if ($isBatch) { ?><td><?php if ($row['disabled']!='1' ){?><input name="id[]" type="checkbox" value="<?php echo $row['id']; ?>"><?php } ?></td><?php } ?>
                                    <td><a href="<?php echo URL('show','id='.$row['id'], 'index.php');?>" target="_blank"><?php echo htmlspecialchars($row['weibo'])?></a></td>
                                    <td><a href="<?php echo URL('ta', 'id='. $row['uid'], 'index.php');?>" target="_blank"><?php echo htmlspecialchars($row['nickname']);?></a></td>
                                    <td><?php echo htmlspecialchars($row['rt']);?></td>
                                    <td><a href="<?php echo URL('mgr/weibo/disableComment.search',array('url'=>URL('show', array('id' => $row['id']), 'index.php')));?>"><?php echo htmlspecialchars($row['comments']);?></a></td>
                                    <td><?php echo date('Y-m-d H:i:s', $row['addtime']);?></td>
                                    <td><?php echo $row['disabled']=='1'?'已屏蔽':'正常';?></td>
                                    <td>
                                        <a href="javascript:delConfirm('<?php echo URL('mgr/weibo/weiboCopy.disabled', 'id=' . $row['id'] . '&value=' . ($row['disabled'] == '1'?0:1), 'admin.php');?>','确认要<?php echo ($row['disabled']=='1'?'恢复':'屏蔽');?>该微博吗');" class="icon-<?php if ($row['disabled']==1) {?>un<?php }?>shield"><?php if ($row['disabled']==1) {?>取消<?php }?>屏蔽</a>
                                        <a href="<?php echo URL('mgr/weibo/disableComment.search',array('url'=>URL('show', array('id' => $row['id']), 'index.php')));?>">屏蔽评论</a>
                                    </td>
                                </tr>
                                <?php }?>
                            <?php }} else {?>
                                <tr><td colspan="<?php echo $isBatch ? '8':'7'; ?>"><p class="no-data">搜索不到任何数据</p></td></tr>
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
