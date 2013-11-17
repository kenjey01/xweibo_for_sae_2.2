<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>名人分类 - 名人堂管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">
function openPop(url,title) {
	window.openpop=Xwb.use('MgrDlg',{
		modeUrl:url,
		formMode:true,
		valcfg:{
			form:'AUTO',
			trigger:'#pop_ok'
		},
		dlgcfg:{
			cs:'win-famer win-fixed',
			onViewReady:function(View){
				var self=this;
				$(View).find('#pop_cancel').click(function(){
					self.close();
				});
				var pid = $(View).find('input[name="old_c_id1"]').val();
				if(pid == "0" || pid == '') pid = $(View).find('select[name="c_id1"]').val();
				ajax_load_add(pid);
			},
			destroyOnClose:true,
			title:title
		}
	})
};


$(function() {

	$('.icon-del').click(function() {
		var sthis=$(this);
		$.ajax({
			url:"<?php echo URL('mgr/celeb_mgr.ajaxCatHasContent'); ?>&"+sthis.attr('rel'),
			dataType:'json',
			success:function(e){
				if( ! e.rst  ){
					Xwb.ui.MsgBox.confirm('提示','确定删除吗？',function(id){
						if(id=='ok'){
							window.location.href='<?php echo URL('mgr/celeb_mgr.delStarCat')?>&'+sthis.attr('rel');
						}
					})
				} else {
					Xwb.ui.MsgBox.alert('提示','该类别下有内容，请先清空类别下的内容!!');
				}
			}
		})
		return false;
	});
});

function update()
{
	Xwb.ui.MsgBox.confirm('提示','确认修改',function(id){
		if(id=='ok'){
			$('#sortfrm').submit();
		}
	});
}
function ajax_load(id)
{
	$('#cid_2_span').load("<?php echo URL('mgr/celeb_mgr.ajaxGetCatList', 'all=1&parent_id='); ?>" + id);
}

function ajax_load_add(id)
    {
    	$('#add_cid_2_span').load("<?php echo URL('mgr/celeb_mgr.ajaxGetCatList', 'all=0'); ?>&parent_id=" + id + "&id=" + 2,'',function(){
    		if( window.openpop.dlg.jq('input[name="old_c_id2"]').val() )
    			$('#add_cid_2_span >select').val(window.openpop.dlg.jq('input[name="old_c_id2"]').val());
    	});
    }
</script>
</head>
<body id="star-catlist" class="main-body">
	<div class="path"><p>当前位置：用户管理<span>&gt;</span>名人分类<?php echo $parent_id > 0 ? '<span>&gt;</span><a href="' . URL('mgr/celeb_mgr.starCatList') . '">一级分类列表</a><span>&gt;</span>二级分类列表' : '<span>&gt;</span>一级分类列表'; ?></p></div>
    <div class="main-cont">
        <h3 class="title"><a href="<?php echo URL('mgr/celeb_mgr.starList', array('c_id1'=>$parent_id)); ?>" class="btn-general"><span>名人管理</span></a><a class="btn-general" href="javascript:openPop('<?php echo URL('mgr/celeb_mgr.addStar', array('pid' =>$parent_id)); ?>','添加名人');"><span>添加名人</span></a><a class="btn-general" href="javascript:openPop('<?php echo URL('mgr/celeb_mgr.addStarCat', 'parent_id=' . $parent_id); ?>','添加分类名称');"><span><?php echo $parent_id > 0 ? '添加二级分类' : '添加一级分类'; ?></span></a><?php echo $parent_id > 0 ? '二级分类列表' : '一级分类列表'; ?></h3>
		<div class="set-area">
				<form id="sortfrm" method="post" action="<?php echo URL('mgr/celeb_mgr.updateCatSort'); ?>">
				<input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
            	<table  class="table table-s1" cellpadding="0" cellspacing="0" width="100%" border="0">
            		<colgroup>
                        <col class="w50" />
                        <col class="" />
                        <col class="w70" />
    					<col class="w80" />
    					<?php if($parent_id){?>
    					<col class="" />
    					<col class="" />
    					<?php }?>
    					<col class="w50" />
                        <col class="w150" <?php if ( empty($parent_id) ){echo ' style="width:230px;"'; } ?> />
    				</colgroup>
                    <thead class="tb-tit-bg">
  						<tr>
                            <th><div class="th-gap">编号</div></th>
                            <th><div class="th-gap">分类名称</div></th>
                            <th><div class="th-gap">排序值</div></th>
                            <th><div class="th-gap">分类级别</div></th>
                            <?php if($parent_id){?>
                            <th><div class="th-gap">颜色</div></th>
                            <th><div class="th-gap">名人堂首页推荐</div></th>
                            <?php }?>
                            <th><div class="th-gap">启用</div></th>
                            <th><div class="th-gap">操作</div></th>
  						</tr>
                	</thead>
                	<tfoot class="td-foot-bg">
                    	<tr>
                    		<td colspan="<?php echo $parent_id ? '8' : '6'; ?>">
                                <div class="pre-next">
                                    <?php echo $pager; ?>
                                </div>
                                <!--<a href="" class="btn-add"><span>批量修改</span></a>-->
                                <a href="#" class="btn-general" onclick="javascript:update();"><span>批量修改</span></a>
                            </td>
                   		</tr>
                    </tfoot>
                    <tbody id="recordList">
                    	<?php if (empty($list)) {?>
                    	<tr>
                    		<td colspan="<?php echo $parent_id ? '8' : '6'; ?>">
                            	<p class="no-data">没有数据，请<a href="javascript:openPop('<?php echo URL('mgr/celeb_mgr.addStarCat', 'parent_id=' . $parent_id); ?>','添加分类名称');">添加新分类</a></p>
                            </td>
                   		</tr>
                   		
						<?php } else { foreach($list as $value): ?>
                        <tr>
                            <td>
                                <input type="hidden" name="data[<?php echo $value['id']; ?>][id]" value="<?php echo $value['id']; ?>" />
                                <?php echo ++$num; ?>
                            </td>
                            <td>
                                <input type="text" class="ipt-txt w180" name="data[<?php echo $value['id']; ?>][name]" value="<?php echo htmlspecialchars($value['name']); ?>" />
                            </td>
                            <td>
                                <input type="text" class="ipt-txt w30" name="data[<?php echo $value['id']; ?>][sort]" value="<?php echo (int)$value['sort']; ?>" />
                            </td>
                            <td>
                                <?php echo $parent_cat_name ? '二级分类' : '一级分类'; ?>
                            </td>
                            <?php 
                                if($parent_id){  // 二级分类
                                    $colorList 		= array('red'=>'红色', 'blue'=>'蓝色', 'orange'=>'橙色', 'yellow'=>'黄色', 'green'=>'绿色', 'purple'=>'紫色');
                                    $colorOptionHtm = '<option value="">默认</option>';
                                    foreach ($colorList as $colorKey => $colorName)
                                    {
                                        $colorSelected	 = ($colorKey==$value['color']) ? 'Selected' : ''; 
                                        $colorOptionHtm .= "<option value='$colorKey' $colorSelected >$colorName</option>";
                                    }
                            ?>
                                <td>
                                    <select name="data[<?php echo $value['id']; ?>][color]" ><?php echo $colorOptionHtm; ?></select>
                                </td>
                                <td>
                                    <input type="checkbox" class="w30" name="data[<?php echo $value['id']; ?>][recommended]" value="1" <?php echo $value['recommended'] ? 'checked' : ''; ?> />
                                </td>
                            <?php }?>
                            <td>
                                <input type="checkbox" class="w30" name="data[<?php echo $value['id']; ?>][status]" value="1" <?php echo $value['status'] ? 'checked' : ''; ?> />
                            </td>
                            
                            <td>
                                
                                    <?php if ($parent_id == '0'): ?>
                                    <a class="icon-sort" href="<?php echo URL('mgr/celeb_mgr.starCatList', 'pid=' . $value['id']); ?>">管理子类</a>
                                    <a href="<?php echo URL('mgr/celeb_mgr.starList', array('c_id1'=>$value['id'])); ?>" class="icon-operate">名人管理</a>
                                    <?php else : ?>
                                    <a href="<?php echo URL('mgr/celeb_mgr.starList', array('c_id1'=>$parent_id, 'c_id2'=>$value['id'])); ?>" class="icon-operate">名人管理</a>
                                    <?php endif; ?>
                                    <!-- <a class="edit" href="javascript:openPop('<?php echo URL('mgr/celeb_mgr.addStarCat', 'id=' . $value['id'] . '&parent_id=' . $value['parent_id']); ?>');">编辑</a>  -->
                                    <a class="icon-del" href="javascript:;" rel="<?php  echo  'id=' . $value['id'] . '&parent_id=' . $value['parent_id']; ?>">删除</a>
                               
                            </td>
                        </tr>
						<?php endforeach; } ?>
                    </tbody>
                </table>
                </form>
        </div> 
    </div>
<div class="win-pop win-fixed win-famer hidden" id="pop_window"></div>
<div id="pop_mask" class="mask hidden"></div>
</body>
</html>
