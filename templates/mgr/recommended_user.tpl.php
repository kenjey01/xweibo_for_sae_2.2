<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户组  - 用户 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">

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
		//alert(url+'&uids='+ids);
		if(ids)
			delConfirm(url+'&uids='+ids, '您确定要删除这些数据吗？');
		else
			window.location.href="#";
	}
</script>

</head>
<body class="main-body">
	<div class="path"><p>当前位置：用户管理<span>&gt;</span>用户组管理</p></div>
    <div class="main-cont">
        <h3 class="title"><a class="btn-general" href="javascript:add('list');"><span>添加用户组</span></a>用户组列表</h3>
		<div class="set-area">
            <table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
                <colgroup>
                    <col class="w70" />
                    <col />
                    <col class="w100" />
                    <col class="w150" />
                </colgroup>
                <thead class="tb-tit-bg">
                <tr>
                    <th><div class="th-gap">编号</div></th>
                    <th><div class="th-gap">名称</div></th>
                    <th><div class="th-gap">类型</div></th>
                    <!--<td>组件应用情况</td>-->
                    <th><div class="th-gap">操作</div></th>
                </tr>
                </thead>
                <tfoot class="tb-tit-bg"></tfoot>
                <tbody>
                <?php $i=1;foreach($list as $value):?>
                    <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $value['group_name'];?></td>
                        <td><?php if($value['native']){echo "内置";}else{echo "自定义";}?></td>
                        <td>
                            
                                <a class="icon-member" href="<?php echo URL('mgr/user_recommend.getUserById','group_id=' . $value['group_id']);?>">查看成员</a>
                                <?php if(!$value['native']) {
                                    echo '<a class="icon-del" href="javascript:delConfirm(\'' . URL('mgr/user_recommend.delReSortById','id=' . $value['group_id']) . '\');"> 删除</a>';
                                }?>
                            
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div> 
    </div>
<script type="text/javascript">
var HtmlMode=['<form action="<?php echo URL('mgr/user_recommend.addReSort');?>" method="post"  name="changes-newlink" id="form1">',
				'	<div class="form-box">',
				'		<div class="form-row">',
            	'			<label for="name" class="form-field">用户组名称</label>',
            	'			<div class="form-cont">',
            	'				<input id="name" name="name" class="ipt-txt" type="text" warntip="#nameTip" vrel="_f|ne|sz=max:16,m:多于8个汉字,ww" value=""/><span class="tips-error hidden" id="nameTip"></span>',
            	'			</div>',
            	'		</div>',
                '    	<div class="btn-area">',
                '    		<a class="btn-general  highlight" id="pop_submit" href="#"><span>确定</span></a>',
                '    		<a class="btn-general" id="pop_cancel" href="#"><span>取消</span></a>',
                '    	</div>',
            	'	</div>',
                '</form>'].join('');
  function add(){
    Xwb.use('MgrDlg',{
		modeHtml:HtmlMode,
		formMode:true,
		valcfg:{
			form:'#form1',
			trigger: '#pop_submit'
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
			title:'添加新用户组'
		}
	})
  }
</script>
</body>
</html>
