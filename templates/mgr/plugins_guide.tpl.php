<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>功能插件 - 组件 - 登录后引导关注</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js" type="text/javascript"></script>
<script>
	function openPop(url,title,component_id) {
		window.popWin=Xwb.use('MgrDlg',{
			modeUrl:url,
			valcfg:{
				form:'AUTO',
				trigger: '#submitBtn'
			},
			dlgcfg:{
				onViewReady:function(View){
					var self=this;
					$(View).find('#pop_cancel').click(function(){
						self.close();
					});
					this.jq().attr('class','win-pop win-fixed win-sort');
					Recom.call(this);
				},
				destroyOnClose:true,
				actionMgr:false,
				title:title
			},
			ajaxcfg:{
				type:'post'
			},
			success:function( r ){
				if( r.errno === 0 ) {
					location.reload();
				} else {
					Xwb.ui.MsgBox.error('提示',r.err);
				}
			},
			afterDisplay : function(){
				var modeObj =  Xwb.util.dequery(this.modeUrl);
				if(modeObj.group_id){
					this.dlg.jq('#groupID').val(modeObj.group_id);
				}
				if(popWin.title){
					popWin.dlg.jq('input[name="item_name"]').val(popWin.title);
				}
				autoHeight(this);
			}
		});
	}
		//自适应高度
	function autoHeight(sthis){
		if(parseInt(sthis.dlg.jq('.form-box').height())> 384 ){
				sthis.dlg.jq('.form-box').height(384)
		} 
	}
	//推荐用户分组
	function Recom(){
		var Util = Xwb.util,
			Box = Xwb.ui.MsgBox,
			self=this,
			Req=Xwb.request,
			flag = true;
		var mgr = new Xwb.ax.ActionMgr();
		mgr.bind(this.jq('#addTable'));
		mgr.reg('addUser',function(e){
				var trObj = $(e.src).parent().parent('tr'),nickname = trObj.find('#nickname'),remark=trObj.find('#remark');
				if(nickname.val()=='' ) return;
				nickname.unbind('focus');
				nickname.focus(function(){
					if( !flag ){
						trObj.find(".tips-error").cssDisplay(false);
						flag = true;
					}
				})
				Req.postReq(Req.mkUrl('mgr/user_recommend','addReUser')+"&json=1",{ group_id:self.jq('#groupID').val(),nickname:nickname.val(),remark:remark.val()},
					function(r){
						if(r.isOk()){
							trObj.before(['<tr rel="u:'+r.getData().uid+'">',
											'<td><span class="user-pic"><img src="'+r.getData().profile_img+'"></span></td>',
											'<td><p class="text">'+nickname.val()+'</p></td>',
											'<td><p class="text">'+remark.val()+'</p></td>',
											'<td>',
											'	<a class="icon-edit" rel="e:Uedit" href="javascript:;">编辑</a>',
											'	<a class="icon-del" rel="e:Udel" href="javascript:;">删除</a>',
											'</td>',
											'</tr>'].join(''));
											nickname.val(''); 
											remark.val('');
											autoHeight(window.popWin);
						} else {
							trObj.find(".tips-error").cssDisplay(true).html(r.getError());
							flag = false;
						}
					});
		})
		.reg('submit',function(e){
			var trObj = $(e.src).parent().parent('tr') ,remark=trObj.find('#remark');
			Req.postReq(Req.mkUrl('mgr/user_recommend','setUserRemark')+"&json=1",{group_id:self.jq('#groupID').val(),uid:e.get('u'),remark:remark.val()},
				function(r){
					if(r.isOk()){
						trObj.find('td:eq(2)').html('<p class="text">'+ remark.val() +'</p>');
						$(e.src).next('a').replaceWith('<a href="javascript:;" class="icon-del" rel="e:Udel">删除</a>');
						$(e.src).replaceWith('<a href="javascript:;" class="icon-edit" rel="e:Uedit">编辑</a>');
					} else {
						Box.error(r.gerError());
					}
				});
		})
		.reg('Uedit',function(e){
			var trObj = $(e.src).parent().parent('tr');
			trObj.find('p:eq(1)').replaceWith('<input value="'+trObj.find('p:eq(1)').html()+'" id="remark" type="text"  class="input-txt w130"/>');
			$(e.src).next('a').replaceWith('<a href="javascript:;" class="icon-del" rel="e:cal">取消</a>');
			$(e.src).replaceWith('<a href="javascript:;" class="icon-confirm" rel="e:submit">确定</a>');
		})
		.reg('cal',function(e){
			var trObj = $(e.src).parent().parent('tr'),nickname = trObj.find('#nickname'),remark=trObj.find('#remark');
			trObj.find('td:eq(2)').html('<p class="text">'+ remark.val() +'</p>');
			$(e.src).prev('a').replaceWith('<a href="javascript:;" class="icon-edit" rel="e:Uedit">编辑</a>');
			$(e.src).replaceWith('<a href="javascript:;" class="icon-del" rel="e:Udel">删除</a>');
		})
		.reg('Udel',function(e){
			Req.postReq(Req.mkUrl('mgr/user_recommend','delUserById')+"&json=1",{group_id:self.jq('#groupID').val(),uid:e.get('u')},
				function(r){
					if(r.isOk()){
						$(e.src).parent().parent('tr').remove();
					} else {
						Box.error(r.gerError());
					}
				});
		});
		//改变类别刷新浮层
		self.jq('#groupID').change(function(){
			if( this.value!="-1" || this.value!="") {
				var urlObj= Util.dequery(popWin.modeUrl);
				urlObj.group_id = this.value;
				for(var v in urlObj){
					if(urlObj[v] === 'undefined')
					delete urlObj[v];
				}
				popWin.modeUrl =  Xwb.request.basePath +'admin.php?' +  Util.queryString(urlObj);
				popWin.title = self.jq('input[name="item_name"]').val();
				popWin.reload();
			}
		});
		//显示分组
		self.jq('#showArea').click(function(){
			self.jq('#addArea').cssDisplay(true);
			$(this).cssDisplay(false);	
		});
		self.jq('#calGroup').click(function(){
			self.jq('#addArea,#newListNameErr').cssDisplay(false);
			$('#showArea').cssDisplay(true);	
		});
		self.jq('#Groupname').focus(function(){
			if(! self.jq('#newListNameErr').hasClass('hidden'))
				self.jq('#newListNameErr').cssDisplay(false);
		})
		//添加分组
		self.jq('#addGroup').click(function(){
			var flag =  true,name = self.jq('#Groupname').val();
			self.jq('#groupID option ').each(function(){
				if( name == this.innerHTML) flag = false;
			});
			if( flag && name !="" ){
				Req.postReq(Req.mkUrl('mgr/user_recommend','addReSort')+"&json=1",{name:name},function(r){
					if(r.isOk()){
						var urlObj= Util.dequery(popWin.modeUrl);
						urlObj.group_id = r.getData().group_id;
						for(var v in urlObj){
							if(urlObj[v] === 'undefined')
							delete urlObj[v];
						}
						popWin.modeUrl =  Xwb.request.basePath +'admin.php?' +  Util.queryString(urlObj);
						popWin.reload();
					} else {
						//错误处理
					}
				})
			}
			if( !flag ){
				self.jq('#newListNameErr').cssDisplay(1);
			}
		});
	}
	$(function(){
			var Util = Xwb.util,
			Box = Xwb.ui.MsgBox,
			self=this,
			Req=Xwb.request,
			lock = 0;
		$('#matic').click(function(){
			$('#userList').cssDisplay(this.checked);
			Req.postReq('<?php echo URL('mgr/plugins.save', array('id'=> $id));?>', { auto_follow:this.checked?1:0, id:$('#_id').val(), autoFollowId:3 },function(r){
				if(! r.isOk()){
					Box.error('提示',r.getMsg());
				}
			})
		});
		
		Xwb.use('base',{
			view:$('#addTable')[0],
			actionMgr : true ,
			onactiontrig :function(e){
				var flag = true;
				switch(e.get('e')){
					case 'Udel' :
						var trObj = $(e.src).parent().parent('tr');
						Req.postReq(Req.mkUrl('mgr/user_recommend','delUserById')+"&json=1",{group_id:3,uid:e.get('u')},
							function(r){
								if(r.isOk()){
									trObj.parent().find('tr').length - 2 < 4 ? trObj.parent().find('tr:last').cssDisplay(true) : 1;
									trObj.remove();
								} else {
									Xwb.ui.MsgBox.error(r.gerError());
								}
							});
						break;
					case 'addUser' :
								var trObj = $(e.src).parent().parent('tr'),nickname = trObj.find('#nickname');
								if(nickname.val()=='') return;
								nickname.unbind('focus');
								nickname.focus(function(){
									if( !flag ){
										trObj.find(".tips-error").cssDisplay(false);
										flag = true;
									}
								});
								Req.postReq(Req.mkUrl('mgr/user_recommend','addReUser')+"&json=1",{ group_id:3,nickname:nickname.val(),remark:'1'},
									function(r){
										if(r.isOk()){
											trObj.before(['<tr rel="u:'+r.getData().uid+'">',
															'<td><span class="user-pic"><img src="'+r.getData().profile_img+'"></span></td>',
															'<td><p class="text">'+nickname.val()+'</p></td>',
															'<td>',
															'	<a class="icon-del" rel="e:Udel" href="javascript:;">删除</a>',
															'</td>',
															'</tr>'].join(''));
															nickname.val(''); 
													trObj.parent().find('tr').length - 1 == 4 ? trObj.cssDisplay(false) : 1;
										} else {
											trObj.find(".tips-error").cssDisplay(true).html(r.getError());
											flag = false;
										}
									});
						break;
				}
			}
		}).display(true);	
	});
	
	function delItem(itemID){
		Xwb.ui.MsgBox.confirm('提示','确认要删除该项吗？',function(id){
			if(id=='ok'){
				Xwb.request.postReq(Xwb.request.mkUrl('mgr/plugins','itemgroup','op=del'),{id:itemID},function(r){
					if(r.isOk()){
						location.reload();
					} else {
						Xwb.ui.MsgBox.alert('提示',r.getError());
					}
				})
			}
		})
	}
</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：首页<span>&gt;</span>首次登录关注</p></div>
    <div class="main-cont">
    	<h3 class="title">自动关注设置</h3>
        <div class="login-guide" id="panel">
			<form name="formSave" method="post" id="formSave">
			<div class="set-area">
                <div class="automatic">
                <p class="tips-desc">
                <label for="matic">
                    <input id="matic" class="ipt-radio" name="auto_follow" id="auto_follow" type="checkbox" value="1"<?php echo $auto ? ' checked':'';?> />首次登录自动关注以下用户：<span class="stress">（请慎用：可能会引起不好的体验）</span>
                </label>
                </p>
                <input type="hidden" name="autoFollowId" value="3" />
                <div class="form-row <?php if (!$auto) {?>hidden<?php }?>" id="userList">
                    <div class="form-cont-single">
                        <table class="add-table" id="addTable" cellpadding="0">
                            <tr>
                                <th class="pic">头像</th>
                                <th>昵称</th>
                                <th class="operate">操作</th>
                            </tr>
                            <?php if (isset($autoFollowUsers) && is_array($autoFollowUsers)) { foreach ($autoFollowUsers as $row) {?>
                            <tr rel="u:<?php echo $row['uid'];?>">
                                <td><span class="user-pic"><img src="<?php echo F('profile_image_url', $row['uid'], 'comment')?>"></span></td>
                                <td><p class="text"><?php echo $row['nickname'];?></p></td>
                                <td>
                                    <a rel="e:Udel" class="icon-del" href="javascript:;">删除</a>
                                </td>
                            </tr>
                            <?php }}?>
                            
                            <tr <?php if (!isset($autoFollowUsers) || count($autoFollowUsers) >=3) {?>class="hidden"<?php }?>>
                                <td>&nbsp;</td>
                                <td><input type="text"  class="input-txt w130" name="nickname" id="nickname"/> <span class="tips-error hidden">该用户不存在</span> </td>
                                <td><a href="javascript:;" class="icon-add" rel="e:addUser">添加</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            </div>
            <h3 class="title"><a href="javascript:openPop('<?php echo URL('mgr/plugins.pluginGuideView',array('json'=>'1'));?>','添加')" class="btn-general" rel="add"><span  rel="add">添加新类别</span></a>登录后引导关注</h3>
			<div class="set-area">
        		<table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
					<colgroup>
                        <col class="w140" />
    					<col />
    					<col class="w120" />
    				</colgroup>
                    <thead class="tb-tit-bg">
					<tr>
   					  	<th><div class="th-gap">类别名称</div></th>
   					  	<th><div class="th-gap">数据来源</div></th>
   					  	<th><div class="th-gap">操作</div></th>
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
						<td><a class="icon-edit" title="编辑" href="javascript:openPop('<?php echo URL('mgr/plugins.pluginGuideView', array('item_id'=>$r['id']));?>','编辑')" rel="edit">编辑</a><a class="icon-del" title="删除" href="javascript:delItem(<?php echo $r['id'];?>,this)" rel="del">删除</a></td>
					</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="3"><p class="no-data">还没有记录哦，<a href="javascript:openPop('<?php echo URL('mgr/plugins.pluginGuideView');?>','添加')" rel="add" >请点击添加</a></p></td>
	</tr>
<?php endif;?>
					</tbody>
				</table>
    		</div>
			<input type="hidden" name="id" id="_id" value="<?php echo $id;?>"/>
            </form>
        </div>
    </div>
</body>
</html>
