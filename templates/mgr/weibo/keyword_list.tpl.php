<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关键字过滤 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
$(function() {
			bindSelectAll('#selectAll','#recordList > tr > td input[type=checkbox]');
			});

function delSelectedConfirm() {
	var v = getSelectedValues('#recordList > tr > td input[type=checkbox]');
	if (!v) {
		alert('最少选中其中一项');
		return;
	}
	var url = '<?php echo URL('mgr/weibo/keyword.del', 'id=' , 'admin.php');?>' + v;
	delConfirm(url, '确认要恢复所有选中的微博吗?');
}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>微博<span> &gt; </span>关键字过滤</div>
    <div class="set-wrap">
        <h4 class="main-title">关键字列表</h4>
		<div class="set-area-int">
			<div class="user-list-box1">
				<p class="serch-tips">请查找已添加的关键字，然后选择相应的操作。您可以直接<a href="<?php echo URL('mgr/weibo/keyword.add','', 'admin.php');?>">添加关键字</a>。</p>
				<form method="post" action="<?php echo URL('mgr/weibo/keyword.keywordList');?>">
            	<div class="serch-user">
            		<span><strong>搜索过滤关键字：</strong></span>
                	<input name="keyword" class="input-txt box-address-width" type="text" value="<?php echo htmlspecialchars(V('r:keyword'));?>" />
                	<span class="serch-btn"><input type="submit" value="搜索" /></span>
           		</div>
				</form>
			</div>
			<div class="user-list">
            	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
            		<colgroup>
						<col class="checkbox-tab"/>
                        <col class="serial-number" />
    					<col />
    					<col class="t-time"/>
    					<col class="keyword-w1"/>
                        <col class="operate-w7"/>
    				</colgroup>
                    <thead class="td-title-bg">
  						<tr>
    						<th><div class="td-inside"></div></th>
                            <th><div class="td-inside">编号</div></th>
    						<th><div class="td-inside">关键字</div></th>
                    		<th><div class="td-inside">添加时间</div></th>
                    		<th><div class="td-inside">操作者</div></th>
    						<th><div class="td-inside">操作</div></th>
  						</tr>
                	</thead>
                	<tfoot class="tfoot-bg">
                    	<tr>
                    		<td colspan="6">
							
                                <div class="pre-next">
								<?php if (isset($list) && is_array($list) && !empty($list)) {?>
								<?php echo $pager;?>
								<?php }?>
                        		</div>
                                <input class="select-all" name="slectALL" id="selectAll" type="checkbox" value="" />全选
                                <a href="javascript:delSelectedConfirm()">删除所选关键字</a>
								
                            </td>
                   		</tr>
                    </tfoot>
                    <tbody id="recordList">
					<?php if (isset($list) && is_array($list) && !empty($list)) {foreach ($list as $key => $row) {?>
  						<tr>
    						<td><input name="1" type="checkbox" value="<?php echo $row['kw_id'];?>" /></td>
    						<td><?php echo $offset + $key + 1;?></td>
                            <td><?php echo htmlspecialchars($row['item']);?></td>
    						<td><?php echo date('Y-m-d H:i:s', $row['add_time']);?></td>
                            <td><?php echo $row['admin_name'];?></td>
    						<td><a class="del-icon" title="删除" href="javascript:delConfirm('<?php echo URL('mgr/weibo/keyword.del','id=' . $row['kw_id'], 'admin.php');?>','确认要删除该关键字吗?')">删除</a></td>
                        </tr>
					<?php }} else {?>
						<tr><td colspan=6><p class="no-data">尚没有添加任何关键字</p></td></tr>
					<?php }?>
                    </tbody>
                </table>
            </div>
        </div>       
    </div>
</div>
</body>
</html>
