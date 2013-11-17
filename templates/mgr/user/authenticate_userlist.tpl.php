<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>认证用户列表 - 认证管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">
var HtmlMode=['<form action="<?php echo URL('mgr/user_verify.authentication');?>" method="post"  name="add-newlink" id="form1">',
            	'	<div class="form-box">',
				'		<div class="form-row">',
            	'			<label for="nick" class="form-field">成员昵称</label>',
            	'			<div class="form-cont">',
            	'				<input name="nick" id="nick" class="ipt-txt" type="text" value="" vrel="_f|sz=max:20,m:多于10个汉字,ww:true|ne=m:不能为空" warntip="#errTip"/><span id="errTip" class="tips-error hidden"></span>',
            	'			</div>',
            	'		</div>',
				'		<div class="form-row">',
            	'			<label for="reason" class="form-field">认证理由</label>',
            	'			<div class="form-cont">',
            	'				<input name="reason" id="reason" class="ipt-txt" type="text" value="" vrel="_f|sz=max:40,m:多于20个汉字,ww:true|ne=m:不能为空" warntip="#reasonTip"/><span id="reasonTip" class="tips-error hidden"></span>',
            	'			</div>',
            	'		</div>',
                '   	<div class="btn-area">',
                '			<a href="#" class="btn-general highlight" id="pop_submit"><span>确定</span></a>',
                '			<a href="#" class="btn-general" id="pop_cancel"><span>取消</span></a>',
                '    	</div>',
				'	</div>',
                '</form>'].join('');
                
	function add_user(){
	    Xwb.use('MgrDlg',{
			modeHtml:HtmlMode,
			formMode:true,
			valcfg:{
				form:'#form1',
				trigger: '#pop_submit'
			},
			dlgcfg:{
				cs:'win-certification win-fixed',
				onViewReady:function(View){
					var self=this;
					$(View).find('#pop_cancel').click(function(){
						self.close();
					});
				},
				destroyOnClose:true,
				actionMgr:false,
				title:'添加新用户'
			}
		})
	}
	
	function edit_user(nickname, reason, sina_uid) {
		var EditHtml = ['<form action="<?php echo URL('mgr/user_verify.updateVerifyReason');?>" method="post" name="edit_reason" id="edit_frm">',
            	'	<div class="form-box">',
            	'		<input type="hidden" name="sina_uid" value="', sina_uid,
            	'" />',
            	'		<div class="form-row">',
            	'			<label class="form-field">成员昵称</label>',
				'			<div class="form-cont">',
				'     			<span class="text">',
								 nickname,
				'				</span>',
				'			</div>',
            	'		</div>',
            	'		<div class="form-row">',
            	'			<label for="reason" class="form-field">认证理由</label>',
            	'			<div class="form-cont">',
            	'				<input name="reason" id="reason" class="ipt-txt" type="text" value="', reason,
            	'" vrel="_f|sz=max:40,m:多于20个汉字,ww:true|ne=m:不能为空" warntip="#reasonTip"/><span id="reasonTip" class="tips-error hidden"></span>',
            	'			</div>',
            	'		</div>',
                '   	<div class="btn-area">',
                '			<a href="#" class="btn-general highlight" id="pop_submit"><span>确定</span></a>',
                '			<a href="#" class="btn-general" id="pop_cancel"><span>取消</span></a>',
                '    	</div>',
                '    </div>',
                '</form>'].join('');
        Xwb.use('MgrDlg',{
			modeHtml:EditHtml,
			formMode:true,
			valcfg:{
				form:'#edit_frm',
				trigger: '#pop_submit'
			},
			dlgcfg:{
				cs:'win-certification win-fixed',
				onViewReady:function(View){
					var self=this;
					$(View).find('#pop_cancel').click(function(){
						self.close();
					});
				},
				destroyOnClose:true,
				actionMgr:false,
				title:'编辑认证理由'
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
			delConfirm(url+'&ids='+ids, '您确定要处理这些数据吗？');
		else
			window.href="#";
	}
	$(function(){
		$('#selectAll').click(function(){
			var $checkbox = $('#recordList > tr > td > input[type=checkbox]'),flag=this.checked;
			$checkbox.each(function(){
				this.checked=flag;
			})
		})
	})
</script>
</head>
<body  class="main-body">
	<div class="path"><p>当前位置：用户管理<span>&gt;</span>认证管理</p></div>
    <div class="main-cont">
        <h3 class="title"><a class="btn-general" href="javascript:add_user();"><span>添加认证用户</span></a><a class="btn-general" href="<?php echo URL('mgr/user_verify.webAuthenWay'); ?>"><span>认证设置</span></a>认证用户列表</h3>
		<div class="set-area">
            <table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
                <colgroup>
                    <col class="w50" />
                    <col class="w50" />
                    <col class="w140" />
                    <col />
                    <col class="w150" />
                    <col class="w150" />
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap"></div></th>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">昵称</div></th>
                        <th><div class="th-gap">认证理由</div></th>
                        <th><div class="th-gap">认证时间</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg">
                    <tr>
                        <td colspan="6">
                            <div class="pre-next">
                                <?php echo $pager;?>
                            </div>
                            <input name="slectALL" id="selectAll" class="ipt-checkbox" type="checkbox" value="" />全选
                            <a class="del-all" href="javascript:delSelectId('<?php echo URL('mgr/user_verify.delAuthen');?>');">取消所选用户的认证</a>
                        </td>
                    </tr>
                </tfoot>
                <tbody id="recordList">
					<?php if (isset($list) && !empty($list) ) {?>
                    <?php foreach($list as $value):?>
					<?php if(!F('user_action_check',array(3),$value['sina_uid'])) :?>
                        <tr>
                            <td><input name="1" type="checkbox" value="<?php echo $value['sina_uid'];?>" /></td>
                            <td><?php echo ++$num;?></td>
                            <td><a href="<?php echo URL('ta', 'id='.$value['sina_uid'], 'index.php');?>" target="_blank"><?php echo F('escape', $value['nick']); ?></a></td>
                            <td><?php echo F('escape', $value['reason']); ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $value['add_time']);?></td>
                            <td><a class="icon-edit" href="javascript:void(0);" onclick="javascript:edit_user('<?php echo F('escape', $value['nick'], ENT_QUOTES); ?>', '<?php echo F('escape', $value['reason'], ENT_QUOTES); ?>', '<?php echo $value['sina_uid']; ?>')">编辑</a> <a class="icon-identify-n" href="javascript:delConfirm('<?php echo URL('mgr/user_verify.authentication', 'id=' . $value['sina_uid'] . '&v=0');?>','确认取消该用户的认证？')">取消认证</a></td>
                        </tr>
					<?php endif;?>
                    <?php endforeach;?>
					<?php } else {?>
						<tr><td colspan="6"><p class="no-data">没有通过认证的用户</p></td></tr>
					<?php }?>
                </tbody>
            </table>
        </div> 
    </div>
 
</body>
</html>
