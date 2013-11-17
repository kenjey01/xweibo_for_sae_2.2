<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>自定义微博列表 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>

<body class="main-body">
	<div class="path"><p>当前位置：运营管理<span> &gt; <a href="/admin.php?m=mgr/page_manager">页面设置</a> &gt; </span>自定义微博列表</p></div>
    <div class="main-cont">
        <h3 class="title"><a href="javascript:add('add');" class="btn-general"><span>添加自定义微博</span></a>自定义微博列表</h3>
		<div class="set-area">
            <table class="table" cellpadding="0">
                <colgroup>
                    <col class="w50"/>
                    <col class="w70" />
                    <col />
                    <col class="w150"/>
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap"></div></th>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">名称</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <?php $isList = isset($list)&&is_array($list)&&!empty($list); if($isList) { ?>
                <tfoot class="tb-tit-bg">
                    <tr>
                        <td colspan="4">
                            <input class="ipt-checkbox" name="slectALL" id="selectAll" type="checkbox" value="" />全选
                            <a  class="del-all" href="javascript:delSelectId('<?php echo URL('mgr/site_list.delList');?>');">删除所选微博列表</a>
                        </td>
                    </tr>
                </tfoot>
                <?php } ?>
                
                <tbody id="recordList">
                <?php if ($isList) {foreach ($list as $key => $row) {?>
                    <tr>
                        <td><input name="1" type="checkbox" value="<?php echo $row['id'];?>" /></td>
                        <td><?php echo $key + 1;?></td>
                        <td rel="name"><?php echo htmlspecialchars($row['name']);?></td>
                        <td><a class="icon-member" title="微博成员" href="<?php echo URL('mgr/site_list.memberList',array('listId'=>$row['id']));?>">微博成员</a><a class="icon-del" title="删除" href="javascript:delConfirm('<?php echo URL('mgr/site_list.delList',array('listId'=>$row['id']));?>','该列表可能被某些模块使用，删除会影响模块的数据，确定要删除吗？')">删除</a></td>
                    </tr>
                <?php }} else {?>
                    <tr><td colspan=4><p class="no-data">尚没有添加任何自定义微博列表</p></td></tr>
                <?php }?>
                </tbody>
            </table>
            <p class="form-tips">温馨提示：系统目前只支持创建20个微博列表。</p>
        </div>       
    </div>

<script type="text/javascript">
var HtmlMode=['<form id="addForm" action="<?php echo URL('mgr/site_list.addList');?>" method="post"  name="add-newlink">',
            	'	<div class="form-box">',
            	'		<div class="form-row">',
            	'			<label for="link-text" class="form-field">新列表名字</label>',
            	'			<div class="form-cont">',
            	'			<input name="name" class="ipt-txt" type="text" value="" warntip="#nameTip" vrel="_f|sz=max:10,m:长度不要超过8个字|ne=m:不能为空|uni=m:该名字已存在"/><span class="tips-error hidden" id="nameTip"></span>',
            	'		</div>',
            	'	</div>',
                '   <div class="btn-area">',
                '    	<a href="#" id="pop_submit" class="btn-general highlight"><span>确定</span></a>',
                '    	<a href="#" id="pop_cancel" class="btn-general"><span>取消</span></a>',
                '    </div>',
                '    </div>',
                '</form>'].join('');
	function add(o) {
	    Xwb.use('MgrDlg',{
			modeHtml:HtmlMode,
			formMode:true,
			valcfg:{
				form:'#addForm',
				trigger: '#pop_submit',
				validators : {
		            uni : function(elem, v, data, next){
		
		            	// 检查list name是否已存在
		            	var pass 	 = true;
		            	var listName = $('input[name=name]').val();
			       		$('#recordList > tr > td[rel=name]').each(function(){
			              if (listName == $(this).html()) {
			            	  pass = false;
				          };
		          		});
		                this.report(pass, data);
		                next();
		            }
		        }
			},
			dlgcfg:{
				onViewReady:function(View){
					var self=this;
					$(View).find('#pop_cancel').click(function(){
						self.close();
					});
				},
				destroyOnClose:true,
				actionMgr:false,
				title:'添加新微博列表'
			}
		})
	}

	function delSelectId(url) {
		var $checkbox = $('#recordList > tr > td > input[type=checkbox]:checked');
		var ids;
		for (var i=0; i<$checkbox.length; i++) {
			if(ids)
				ids += ','+$checkbox.eq(i).val();
			else
				ids = $checkbox.eq(i).val();
		}
		//alert(url+'&uids='+ids);
		if(ids)
			delConfirm(url+'&listId='+ids, '您确定要删除这些数据吗？');
		else
			window.location.href="#";
	}

	$(function() {
		bindSelectAll('#selectAll','#recordList > tr > td > input[type=checkbox]');
	});
	

</script>
</body>
</html>
