<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 组件设置 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js" type="text/javascript"></script>
<script>
var itemgroup_id = '<?php echo USER_CATEGORY_RECOMMEND_ID;?>';
$(function() {
	
<?php 
$htmls = array();
foreach($list as $key => $g) {
	if ($g['group_id'] == 4)
	{
		continue;
	}
	array_push($htmls, '{val:'. $g['group_id'] . ', text:\'' . F('escape', $g['group_name']) . '\'}');
}
	echo 'var optHtmls = [', join(',', $htmls) ,'];', "\r\n";
?>
	var editId = '';

	var box = new ui.cateBox({
		onViewReady: function() {
			this.setOptions(optHtmls);
		},
		complete: function(mode, result) {

			var data = {
				op: mode
			};

			data['item_id'] = this.select();
			data['item_name'] = this.content();

			if (editId)
			{
				data['id'] = editId;
			}

			$.ajax({
				url: '<?php echo URL("mgr/components.itemgroup");?>',
				data: data,
				type: 'post',
				dataType: 'json',
				cache: false,
				success: function(ret) {
					if (ret.errno == '11013')
					{
						alert('添加失败，已存在该类别');
					} else {
						window.location.reload();
					}

				}
			});
		}
	});


	$('#panel').click(function(e) {
		var $target = $(e.target);
		var rel = $target.attr('rel');

		if (rel)
		{

			switch (rel)
			{
			case 'add':
				editId = '';
				box.show();
				box.reset();
			break;

			case 'edit':
			case 'del':
				var $row = $target.closest('TR');
				var vals = $row.attr('rel').split(',');
				var id = vals[0];

				if (rel == 'edit')
				{
					editId = id;
					box.edit(vals[2], vals[1]);
					box.show();
				} else {
					Xwb.ui.MsgBox.confirm('提示','确定要删除这个类别吗？',function(id){
						if(id=='ok'){
							$.ajax({
								url: '<?php echo URL("mgr/components.itemgroup");?>',
								data: {id: id, op:'del'},
								type: 'post',
								dataType: 'json',
								cache: false,
								success: function(ret) {
									if (ret.errno == 0)
									{
										$row.remove();
									}
								}
							});
						}
					});

				}

			break;
			
			}


			e.preventDefault();
		}
	});

});
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：<span>组件列表</span> &gt; <span>组件设置</span> &gt; <span>分类用户推荐</span></div>
    <div class="set-wrap">
        
        <div class="login-guide" id="panel">
            <h4 class="main-title"><a href="#" class="btn-add" rel="e:add"><span rel="add">添加新类别</span></a>设置</h4>
			<div class="set-area-int">
        		<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table">
					<colgroup>
						<col class="guide-list" />
    					<col />
    					<col class="operate-w2" />
    				</colgroup>
                    <thead class="td-title-bg">
					<tr>
   					  	<th><div class="td-inside">类别名称</div></th>
   					  	<th><div class="td-inside">类别使用的用户列表</div></th>
   					  	<th><div class="td-inside">操作</div></th>
				  	</tr>
              		</thead>
                	<tbody>
<?php 
	if (!empty($groups)):

	function getUserListName($list, $item_id) {

		foreach ($list as $g) {
			if ($g['group_id'] == $item_id) {
				return $g['group_name'];
			}
		}

		return false;
	}
?>

	<?php foreach($groups as $r):?>
                    <tr rel="<?php echo $r['id'],',', $r['item_id'], ',', F('escape', $r['item_name']);?>">
   					  	<td><?php echo F('escape', $r['item_name']);?></td>
   					  	<td><?php echo F('escape', getUserListName($list, $r['item_id']));?></td>
						<td>
							
                        		<a class="change-icon" title="编辑" href="#" rel="e:edit">编辑</a>
                        		<a class="del-icon" title="删除" href="#" rel="e:del">删除</a>
							
                        </td>
					</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="3"><p class="no-data">还没有记录哦，<a href="#" rel="add">请点击添加</a></p></td>
	</tr>
<?php endif;?>
					</tbody>
				</table>
    		</div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
