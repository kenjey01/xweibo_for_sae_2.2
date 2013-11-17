<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户组  - 用户 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
</head>
<body  class="main-body">
	<div class="path"><p>当前位置：用户管理<span>&gt;</span><a href="<?php echo URL('mgr/user_recommend.getReSort'); ?>">用户组管理</a><span>&gt;</span><?php echo $group_name;?>管理</p></div>
    <div class="main-cont">
        <h3 class="title" id="title_list"><a class="btn-general" href="javascript:add('user');"><span>添加新成员</span></a><a class="btn-general" href="" id="modifyBtn"><span>修改排序</span></a><a class="btn-general hidden" href="" id="saveBtn"><span>保存排序</span></a><?php echo $group_name;?></h3>
		<div class="set-area">
			<?php if($userlist):?>
            <table class="table" id="tblZoom" cellpadding="0" >
                <colgroup>
                    <col class="w50"/>
                    <col class="w70" />
                    <col class="w180" />
                    <col />
                    <col class="w140" />
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap"></div></th>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">昵称</div></th>
                        <th><div class="th-gap">备注</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg">
                    <tr>
                        <td colspan="5">
                            <input name="slectALL" id="selectAll" class="ipt-checkbox" type="checkbox" value="" />全选
                            <a class="del-all" href="javascript:delSelectId('<?php echo URL('mgr/user_recommend.delAllUserById','group_id=' . $group_id );?>');">将所选用户从列表中删除</a></td>
                    </tr>
                </tfoot>
                <tbody class="order-main" id="recordList">
                    <?php $i=1;foreach($userlist as $value):?>
                        <tr rel="<?php echo $value['uid'];?>">
                            <td><span class="icon-range"></span><div class="default"><input name="uids" type="checkbox" value="<?php echo $value['uid'];?>" /></div></td>
                            <td><?php echo $i++;?></td>
                            <td><a href="<?php echo $value['http_url'];?>" target="_blank"><?php echo F('escape', $value['nickname']); ?></a></td>
                            <td><?php echo F('escape', $value['remark']); ?></td>
                            <td>
                                
                                <a class="icon-edit" title="编辑" href="javascript:edit('<?php echo $value['uid']?>','<?php echo $value['group_id']?>','<?php echo $value['nickname']?>','<?php echo $value['remark']?>')">编辑</a>
                                <a class="icon-del" title="删除" href="javascript:delConfirm('<?php echo URL('mgr/user_recommend.delUserById','group_id=' . $value['group_id'] . '&uid=' . $value['uid']);?>');">删除</a>
                                
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php elseif($group_id):?>
            <table  class="table" cellpadding="0" >
                <colgroup>
                    <col class="w50"/>
                    <col class="w70" />
                    <col class="w180" />
                    <col class="w180" />
                    <col class="w140" />
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap"></div></th>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">昵称</div></th>
                        <th><div class="th-gap">备注</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot  class="tb-tit-bg"></tfoot>
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
	var editHtmlMode=['<form id="mdyUsrForm" action="<?php echo URL('mgr/user_recommend.setUserRemark');?>" method="post"  name="">',
            	    '	<div class="form-box">',
            	    '		<div class="form-row">',
            	    ' 			<label class="form-field">成员昵称</label>',
					'			<div class="form-cont">',
                    '     			<span class="text" id="username"></span>',
					'			</div>',
            		'		</div>',
            		'		<div class="form-row">',
            		'			<label for="remark" class="form-field">成员备注</label>',
            		'			<div class="form-cont">',
            		'				<input name="remark" id="remark" class="ipt-txt" type="text" value="" vrel="_f|ne|sz=max:20,m:多于10个汉字,ww" warntip="#mdyTip" /><span class="tips-error hidden" id="mdyTip"></span>',
					'			<p class="form-tips">限制10个字</p>',
            		'			</div>',
            		'		</div>',
                    '		<div class="btn-area">',
                    '			<input name="group_id" type="hidden" id="user_group_id" value=""/>',
					'			<input name="uid" type="hidden" id="user_uid" value=""/>',
                    '			<a href="#" class="btn-general highlight" id="pop_submit"><span>确定</span></a>',
                    '			<a href="#" class="btn-general" id="pop_cancel"><span>取消</span></a>',
                    '		</div>',
                    '	</div>',
                	'</form>'].join('');
    var addHtmlMode=['<form id="addReUsrForm" action="<?php echo URL('mgr/user_recommend.addReUser');?>" method="post"  name="add-newlink">',
            		'	<div class="form-box">',
            		'		<div class="form-row">',
            		'			<label for="nickname"  class="form-field">成员昵称</label>',
            		'			<div class="form-cont">',
            		'				<input name="nickname" id="nickname" class="ipt-txt" type="text" value="" vrel="_f|ne|sz=max:20,m:多于10个汉字,ww" warntip="#nickTip" /><span class="tips-error hidden" id="nickTip"></span>',
            		'			</div>',
            		'		</div>',
            		'		<div class="form-row">',
            		'			<label for="remark" class="form-field">成员备注</label>',
            		'			<div class="form-cont">',
            		'				<input id="remark" name="remark" class="ipt-txt" type="text" value="" vrel="_f|ne|sz=max:20,m:多于10个汉字,ww" warntip="#remarkTip" /><span class="tips-error hidden" id="remarkTip"></span>',
					'			<p class="form-tips">限制10个字</p>',
            		'			</div>',
            		'		</div>',
                    '		<div class="btn-area">',
                    '			<input name="group_id" type="hidden" value="<?php echo $group_id;?>"/>',
                    '			<a href="#" class="btn-general highlight" id="pop_submit"><span>确定</span></a>',
                    '			<a href="#" class="btn-general" id="pop_cancel"><span>取消</span></a>',
                    '		</div>',
                    '	</div>',
                	'</form>'].join('');
    function add(){
      Xwb.use('MgrDlg',{
		modeHtml:addHtmlMode,
		formMode:true,
		valcfg:{
			form:'#addReUsrForm',
			trigger: '#pop_submit'
		},
		dlgcfg:{
			cs:'win-user win-fixed',
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

	function edit(id, group_id, name, text) {
			Xwb.use('MgrDlg',{
				modeHtml:editHtmlMode,
				formMode:true,
				valcfg:{
					form:'#mdyUsrForm',
					trigger: '#pop_submit'
				},
				dlgcfg:{
					cs:'win-user win-fixed',
					onViewReady:function(View){
						var self=this;
						$(View).find('#pop_cancel').click(function(){
							self.close();
						});
						$(View).find('#user_uid').val(id);
						$(View).find('#user_group_id').val(group_id);
						$(View).find('#username').html(name);
						$(View).find('#remark').val(text);
					},
					destroyOnClose:true,
					actionMgr:false,
					title:'修改备注'
				}
			})
	}

	$(function() {
		bindSelectAll('#selectAll','#recordList > tr > td > div > input[type=checkbox]');
	});

	function delSelectId(url) {
		var $checkbox = $('#recordList > tr > td > div > input[type=checkbox]:checked');
		var ids;
		for (var i=0; i<$checkbox.length; i++) {
			if(ids)
				ids += ','+$checkbox.eq(i).val();
			else
				ids = $checkbox.eq(i).val();
		}
		//alertrl+'&uids='+ids);
		if(ids)
			delConfirm(url+'&uids='+ids, '您确定要删除这些数据吗？');
		else
			window.location.href="#";
	}
	
    var zoom = new OrderRowZoom($('#tblZoom')[0], {
		param:{group_id:<?php echo $group_id;?>},
        url:'<?php echo URL('mgr/user_recommend.userSortById');?>',
        modifyBtn : '#modifyBtn',
        saveBtn   : '#saveBtn',
        paramName : 'uids'
    });
</script>
</body>
</html>
