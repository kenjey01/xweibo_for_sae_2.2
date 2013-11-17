<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>功能插件 - 组件 - 组件扩展</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
	$(function(){
		var html=['<form id="form1" name="form1" method="post">',
							'<div class="form-box">',
								'<div class="form-row">',
									'<label for="text" class="form-field">信息内容</label>',
									'<div class="form-cont">',
										'<input type="text" value="" class="ipt-txt" id="text" name="input_text" vrel="_f|ne|sz=max:40,m:不能超过20个字,ww" warntip="#textErr"><span id="textErr" class="tips-error hidden"></span>',
									'</div>',
								'</div>',
								'<div class="form-row">',
									'<label for="link" class="form-field">链接</label>',
									'<div class="form-cont">',
									'<input type="text" value="" class="ipt-txt" id="link" name="input_link" vrel="_f|ne|sz=max:255,m:不能超过255字符" warntip="#linkErr"><span id="linkErr" class="tips-error hidden"></span>',
									'</div>',
								'</div>',
								'<div class="btn-area">',
									'<a class="btn-general  highlight" id="input_ok" href="#"><span>确定</span></a>',
									'<a class="btn-general" id="input_cancle" href="#"><span>取消</span></a>',
								'</div>',
							'</div>',
						'</form>'].join('');
		window.box=Xwb.use('MgrDlg',{
			setTitle:function(title){
				this.dlg.jq('#xwb_title').html(title);
				return this;
			},
		    set: function(text, link) {
				$('input[name=input_text]', this.dlg.jq()).val(text || '');
				$('input[name=input_link]', this.dlg.jq()).val(link || '');
				return this;
			 },
		   show:function(){
		   	 this.dlg.jq('#textErr').cssDisplay(false);
		   	 this.dlg.jq('#linkErr').cssDisplay(false);
			 this.dlg.display(true);
		   },
		   hide:function(){
			this.dlg.display(false);
		   },
		   onOk:function(fn){
				this.selfChk=function(data){
					fn(data.input_text,data.input_link);
				}
		   },
		   modeHtml:html,
		   dlgcfg:{
			    cs:'win-link win-fixed',
				title:'推广信息',
				onViewReady:function(view){
					var self=this;
					$(view).find('#input_cancle').click(function(){
						self.close();
					})
				}
		   },
		   valcfg:{
		        form:'#form1',
				trigger:'#input_ok'
		   }
		});
		box.dlg.close();
	})
</script>
<script>
$(function() {

	var errNodes = {
		'text': box.dlg.jq().find('#textErr'),
		'link': box.dlg.jq().find('#linkErr')
	};

	var mode = 'add';
	var link_id = '';
	var target;

	var $text =box.dlg.jq().find('#text'),
		$link = box.dlg.jq().find('#link');


	box.onOk(function(title, link) {

		var data = {
			title: title,
			link: link,
			op: mode,
			link_id: link_id
		}

		$.ajax({
			url: "<?php echo URL('mgr/plugins.save', array('id' => 3));?>", 
			data: data,
			type: 'post',
			dataType: 'json',
			success: function(ret) {
				if (mode == 'add')
				{
					if (ret.errno == 0)
					{ 
						window.location.reload(); 
					} else { //失败
						Xwb.ui.MsgBox.alert('发生错误，添加失败');
					}
				} else {
					if (ret.errno == 0)
					{
						window.location.reload(); 
					} else {
						Xwb.ui.MsgBox.alert('发生错误，修改失败');
					}
				}
				target = null;
			}
		});
	});

	$('#mainContent').click(function(e) {
		var $target = $(e.target);
		var rel = $target.attr('rel');

		if (!rel)
		{
			return;
		} else {
			var tmp = rel.split(':');
			var op = tmp[0];
			var v = tmp[1] || '';
		}

		target = e.target;

		switch (op)
		{
		case 
			'add':
			mode = 'add';
			link_id = '';
			$.each(errNodes, function(i, o) {
				o.addClass('hidden');
			});
			box.setTitle('添加新的推广信息').set('', 'http://').show();
			break;

		case 'mod':
			mode = 'mod';
			link_id = v;
			var $tr = $target.closest('TR');
			var $td = $tr.find('TD');

			box.setTitle('编辑新的推广信息')
			.set($td.eq(0).text(), $td.eq(1).text())
			.show();

			break;

		case 'del':
			var $tr = $target.closest('TR');
			Xwb.ui.MsgBox.confirm('提示','确定要删除这条信息吗？',function(id){
				if(id=="ok"){
					$.ajax({
						url: "<?php echo URL('mgr/plugins.save', array('id' => 3));?>",
						data: {
							link_id: v,
							op: 'del'
						},
						type: 'post',
						dataType: 'json',
						success: function(ret) {
							if (ret.rst)
							{
								$tr.remove();
							} else {
								alert('删除失败');
							}
						}
					});
				}
			})
			target = null;
			break;
		
		}
	});

});
</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>个人资料推广</p></div>
    <div class="main-cont" id="mainContent">
        <h3 class="title"><a class="btn-general" rel="add" href="javascript:;"><span rel="add">添加推广信息</span></a>推广信息列表</h3>
        <div class="set-area">
            <table class="table" border="0" cellpadding="0" cellspacing="0" width="100%">
                <colgroup>
                    <col class="w180" />
                    <col />
                    <col class="w140"/>
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap">推广信息内容</div></th>
                        <th><div class="th-gap">链接</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg"></tfoot>
                <tbody>
<?php 
if (empty($list)) {
?>
                <tr id="no_exists">
                    <td class="extend-tacit" colspan="3"><p class="no-data">还没有记录哦，请<a href="#" rel="add">点击添加</a></p></td>
                 </tr>
<?php
} else {
    foreach ($list as $row) {
?>
                <tr>
                    <td><?php echo F('escape', $row['title']);?></td>
                    <td><a href="<?php echo F('escape', $row['link']);?>" target="_blank"><?php echo F('escape', $row['link']);?></a></td>
                    <td><a href="javascript:;" title="编辑" class="icon-edit" rel="mod:<?php echo $row['link_id'];?>">编辑</a><a rel="del:<?php echo $row['link_id'];?>" href="javascript:;" title="删除" class="icon-del">删除</a></td>
                </tr>
<?php
    }
} 
?>
                </tbody>
            </table>
            <!--
            <div class="btn-area">
            	<a class="btn-general" href="<?php echo URL('mgr/plugins');?>"><span>返回组件列表</span></a>
            </div>
            -->
        </div>
    </div>
<div id="pop_mask" class="mask hidden"></div>
</body>
</html>
