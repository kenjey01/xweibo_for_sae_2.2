<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微博成员管理 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：运营管理<span> &gt; <a href="/admin.php?m=mgr/page_manager">页面设置</a> &gt; </span>自定义微博列表</p></div>
    <div class="main-cont">
        <h3 class="title"><a class="btn-general" href="javascript:add('user');"><span>添加新成员</span></a><?php echo $listName; ?></h3>
		<div class="set-area">
			<?php if(!empty($userlist)):?>
            <table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
                <colgroup>
                    <col class="w70"/>
                    <col class="w70" />
                    <col class="w120" />
                    <col />
                    <col class="w90" />
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap"></div></th>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">昵称</div></th>
                        <th><div class="th-gap">微博地址</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg">
                    <tr><td colspan="5">
                    	<div class="pre-next">
                        <?php if($prev_cursor){?><a href="<?php echo URL('mgr/site_list.memberList', array('listId'=>$listId, 'cursor'=>$prev_cursor));?>" class="btn-general"><span>上一页</span></a><?php }?>
                        <?php if($next_cursor){?>&nbsp;&nbsp;<a href="<?php echo URL('mgr/site_list.memberList', array('listId'=>$listId, 'cursor'=>$next_cursor));?>" class="btn-general"><span>下一页</span></a><?php } echo "  总记录数  $total"?>
                        </div>
                        <input name="" class="ipt-checkbox" id="selectAll" type="checkbox" value="" />全选
                        <a class="del-all" href="javascript:delSelectId('<?php echo URL('mgr/site_list.delMember', array('listId'=>$listId) );?>');">将所选用户从列表中删除</a>
                    </td></tr>
                </tfoot>
                <tbody class="order-main" id="recordList">
                    <?php $i=1;foreach($userlist as $value):?>
                        <tr>
                            <td><div class="default"><input name="uids" type="checkbox" value="<?php echo $value['id'];?>" /></div></td>
                            <td><?php echo $i++;?></td>
                            <td rel="name"><?php echo $value['screen_name'];?></td>
                            <td><a href="<?php echo $value['http_url'];?>" target="_blank"><?php echo $value['http_url'];?></a></td>
                            <td><a class="icon-del" title="删除" href="javascript:delConfirm('<?php echo URL('mgr/site_list.delMember','listId='. $listId .'&uids=' . $value['id']);?>')">删除</a></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php elseif($listId):?>
            <table class="table" cellpadding="0">
                <colgroup>
                    <col class="w50"/>
                    <col class="w70" />
                    <col class="w120" />
                    <col />
                    <col class="w120" />
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap"></div></th>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">昵称</div></th>
                        <th><div class="th-gap">微博地址</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5"><p class="no-data">没有数据，请<a href="javascript:add('user');">添加新成员</a></p></td>
                    </tr>
                </tbody>
            </table>
            <?php endif;?>
        </div>
    </div>
<script type="text/javascript">

var HtmlMode=['<form id="addUserForm" action="<?php echo URL('mgr/site_list.addMember');?>" method="post"  name="add-newlink">',
            		'<div class="form-box">',
            		'	<div class="form-row">',
            		'		<label for="link-text"  class="form-field">新成员昵称</label>',
            		'		<div class="form-cont">',
            		'			<input name="nickname" class="ipt-txt" type="text" value="" warntip="#nameTip" vrel="_f|sz=max:20,m:超过10个字,ww|ne=m:不能为空|uni=m:该名字已存在"/><span class="tips-error hidden" id="nameTip"></span>',
            		'		</div>',
            		'	</div>',
                    '	<div class="btn-area">',
					'		<input name="listId" type="hidden" value="<?php echo $listId;?>"/>',
                	'    	<a href="#" id="pop_submit" class="btn-general highlight"><span>确定</span></a>',
                	'    	<a href="#" id="pop_cancel" class="btn-general"><span>取消</span></a>',
                    '	</div>',
                    '</div>',
					'</form>'].join('');
	function add(o) {
	    Xwb.use('MgrDlg',{
			modeHtml:HtmlMode,
			formMode:true,
			valcfg:{
				form:'#addUserForm',
				trigger: '#pop_submit',
				validators : {
		            uni : function(elem, v, data, next){
							// 检查list name是否已存在
							var pass 	 = true;
							var listName = $('input[name=nickname]').val();
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
				title:'添加新成员'
			}
		})
	}

	function delSelectId(url) {
		var $checkbox = $('#recordList > tr > td > div > input[type=checkbox]:checked');
		var ids;
		for (var i=0; i<$checkbox.length; i++) {
			if(ids)
				ids += ','+$checkbox.eq(i).val();
			else
				ids = $checkbox.eq(i).val();
		}
		//alert(url+'&uids='+ids);
		if(ids)
			delConfirm(url+'&uids='+ids, '您确定要删除这些数据吗？');
		else
			window.location.href="#";
	}

	$(function() {
		bindSelectAll('#selectAll','#recordList > tr > td > div > input[type=checkbox]');
	});
	
</script>

</body>
</html>
