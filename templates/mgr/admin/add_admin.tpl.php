<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加管理员用户 - 帐号管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">
var HtmlDemo=[ '<form id="pwdForm" action="<?php echo URL('mgr/admin.add');?>" method="post">',
            	'	<div class="form-box">',
            	'		<div class="form-row">',
            	'			<label for="add-initial-password" class="form-field">密码</label>',
            	'			<div class="form-cont">',
            	'				<input name="pwd" class="ipt-txt" vrel="_f|ne|sz=min:6,max:16,m:长度为6-16位|pw" type="password" value="" warntip="#nameTip" /><span class="tips-error hidden" id="nameTip"></span>',
				'       		<p class="form-tips">6-16位的数字或者字母</p>',
            	'			</div>',
            	'		</div>',
            	'		<div class="form-row">',
            	'			<label for="permission" class="form-field">管理权限</label>',
            	'			<div class="form-cont">',
				'				<select id="permission" name="group_id" class="w160" vrel="_f|ne"  warntip="#groupTip">',
				'					<option value="" selected="">选择权限</option>',
				'					<option value="3">运营维护</option>',
				'					<option value="2">管理员</option>',
				'					<option value="1">超级管理员</option>',
				'				</select>',
            	'				<span class="tips-error hidden" id="groupTip">请选择一个权限</span>',
            	'			</div>',
            	'		</div>',
            	'		<div class="form-row">',
            	'			<label  class="form-field">说明</label>',
            	'			<div class="form-cont">',
				'       		<p class="form-tips">运营维护权限只拥有关键字过滤、内容审核屏蔽、用户管理功能。</p>',
				'       		<p class="form-tips">管理员权限可以拥有除系统设置以外的所有权限。</p>',
				'       		<p class="form-tips">超级管理员权限拥有所有权限。</p>',
            	'			</div>',
            	'		</div>',
                '    	<div class="btn-area">',
				'			<input name="uid" type="hidden" id="uid" value=""/>',
				'			<a href="#" class="btn-general highlight" id="pop_ok"><span>确定</span></a>',
				'			<a href="#" class="btn-general" id="pop_cancel"><span>取消</span></a>',
                '    	</div>',
                '    </div>',
              '</form>'].join('');

	function add(id,nickName) {
		Xwb.use('MgrDlg',{
			modeHtml:HtmlDemo,
			formMode:true,
			valcfg:{
				form:'#pwdForm',
				trigger:'#pop_ok',
				validators : {
				 'pw': function(elem, v, data, next){
						    var reg = /^[a-zA-Z-0-9\.\-_\?]+$/;
						    if(v){
						    	if(!data.m && data.m !== 0)
						        	data.m = '非法字符';
						    	this.report(reg.test(v), data);
						    } else this.report(true, data);
						    next();
				 }
				}
			},
			dlgcfg:{
				cs:'win-admin win-fixed',
				onViewReady:function(View){
					var self=this;
					$(View).find('#pop_cancel').click(function(){
						self.close();
					})
				},
				destroyOnClose:true,
				title:'添加管理员',
				nickName:nickName
			},
			afterDisplay:function(){
					this.dlg.jq("#uid").val(id);
			}
		})
	}
</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>添加管理员</p></div>
    <div class="main-cont">
        <h3 class="title">添加管理员</h3>
		<div class="set-area">
        	<p class="tips-desc">请输入昵称搜索用户，然后选择相应的添加操作。</p>
        	<div class="search-area">
                <form action="" method="post" id="SearchFrom">
                    <div class="item">
                        <label><strong>搜索包含以下昵称的用户</strong></label>
                        <input name="keyword" class="ipt-txt w200" type="text" />
                        <a href="javascript:$('#SearchFrom').submit();" class="btn-general"><span>搜索</span></a>
                    </div>
                </form>
            </div>
        
            <?php if($this->_isPost() && !V('r:keyword', false)):?>
                <div class="search-results-no">请输入昵称</div>
            <?php elseif(!V('r:keyword', false)):?>

            <?php elseif(isset($list)):?>
              <ul class="search-results">
                <?php $i=1;foreach($list as $value):?>
                <?php if($i==1):$i++;?><li class="first"><?php else:?><li class="result-line"><?php endif;?>
                    <div class="results-l">
                        <p class="results-name"><?php echo htmlspecialchars($value['nickname']);?></p>
                        <p><span><?php echo $value['userinfo']['location'];?></span><span>粉丝数：<?php echo $value['userinfo']['followers_count'];?>人</span></p>
                    </div>
                    <div class="results-r">
                        <a href="javascript:add('<?php echo $value['sina_uid'];?>','<?php echo htmlspecialchars($value['nickname']);?>')" >添加管理员权限</a>
                    </div>
                </li>
                <?php endforeach;?>
              </ul>
            <?php else:?>
                 <div class="search-results-no">该用户不存在或者未开通本站微博</div>
            <?php endif;?>
            
    	</div>
    </div>

</body>
</html>
