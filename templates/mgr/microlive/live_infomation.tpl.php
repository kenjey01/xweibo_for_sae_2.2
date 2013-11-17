<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线直播列表 - 组件扩展</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/microlive.js"></script>
</head>
<body class="main-body">
<div class="path"><p>当前位置：扩展工具<span>&gt;</span><a href="<?php echo URL('mgr/wb_live');?>">在线直播列表</a><span>&gt;</span>在线直播基本信息</p></div>
    <div class="main-cont">
		<div class="set-area">
        	<div class="form">
                <div class="form-row">
                    <form id="fileForm" action="<?php echo URL('mgr/wb_live.upload');?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="thumb" value="0" />
                        <span class="tips-error hidden" id="bannerTip"></span>
                        <label for="banner" class="form-field">头图设置</label>
                        <div class="form-cont">
                            <input type="file" class="btn-file" value="上传banner" name="pic" onchange="MicroAdmin.upload(this)" id="pic"/>
                            <p class="form-tips">建议图片尺寸800*126px</p>
                            <div class="banner-edit"><img src="<?php echo isset($live['banner_img']) ? $live['banner_img'] : $default_banner_img; ?>" title="banner" id="preview" /></div>
                        </div>
                    </form>
                </div>
                <form target="" action="<?php echo URL('mgr/wb_live.saveLiveBase');?>" method="post" id="submitForm">
                <input type="hidden" name="banner_img" id="bannerImg" />
                <div class="form-row">
                    <label for="intro" class="form-field">关于在线直播</label>
                    <textarea  id="intro" name="desc" vrel="ne=m:请输入在线直播相关信息。" class="input-area area-s1"  warntip="#introTip" ><?php echo isset($live['desc']) ? $live['desc'] : '在线直播是依托于微博基础，通过汇集微博上来自各方面的实时信息，全方位展现大型活动进程的直播平台。　在在线直播中，普通网友也能通过参与现场播报，与明星嘉宾一同成为活动的主角。同时依托微博快捷的传播机制和庞大的用户基础，在线直播已成为活动信息最快速的传播平台。';?></textarea>
                	<span id="introTip" class="tips-error hidden">请输入通知内容</span>
                </div>
                
                <div class="form-row">
                    <label for="compere" class="form-field">官方主持人</label>
                    <div class="form-cont table-cont">
                    	<table class="add-table" cellpadding="0">
                        	<tr>
                            	<th class="pic">头像</th>
                                <th>昵称</th>
                                <th class="operate">操作</th>
                            </tr>
							<?php if ($userlist):?>
							<?php foreach($userlist as $item):?>
							<tr>
                            	<td><span class="user-pic"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></span></td>
                                <td onclick="MicroAdmin.edit(this)"><p title="点击编辑" class="text"><?php echo $item['screen_name'];?></p><input value="<?php echo $item['screen_name'];?>" type="text" class="input-txt w130 hidden" id="_holder" vrel="_f|ne=m:须指定首个主持人|username" warntip="#masterTip"><input type="hidden" name="master[]" id="master" value="<?php echo $item['id'];?>" /><span class="tips-error hidden" id="masterTip"></span></td></td>
                                <td><a class="icon-edit" href="#" onclick="MicroAdmin.edit(this);return false;">编辑</a><a onclick="MicroAdmin.del(this);return false;" href="#" class="icon-del">删除</a></td>
                            </tr>
							<?php endforeach;?>
							<?php endif;?>
                            <tr id="addCol">
                                <td><span class="user-pic"><img src="<?php echo W_BASE_URL;?>img/user_img_default.png" alt="" /></span></td>
                                <td><input type="text"  class="input-txt w130" warntip="#masterRequire" vrel="userrequire=m:须添加至少一个主持人" onblur="MicroAdmin.add(this, 'master');return false;" /><span class="tips-error hidden" id="masterRequire"></span></td>
                                <td><a href="javascript:;" class="icon-add" onclick="MicroAdmin.add(this, 'master');return false;">添加</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="form-row">
                    <label for="contact" class="form-field">联系我们</label>
                    <textarea  id="contact" name=contact class="input-area area-s1" vrel="ne=m:请填写联系信息。"  warntip="#contactTip" ><?php echo isset($live['contact']) ? $live['contact'] : '';?></textarea>
                    <span id="contactTip" class="tips-error hidden">请输入通知内容</span>
                </div>
                <div class="btn-area" ><a href="#" id="submitBtn" class="btn-general highlight"><span>确认</span></a></div>
                
                <input type="hidden" name="pic" id="picImg" vrel="pic=f:pic,c:头像" warntip="#bannerTip" value="<?php echo isset($live['banner_img']) ? $live['banner_img'] : $default_banner_img;?>"/>
                
                </form>
            </div>
    	</div>
    </div>
<script> 
    gReqUserUrl = '<?php echo URL('mgr/wb_live.getUserShow');?>';
    gUsrImgUrl  = '<?php echo W_BASE_URL;?>img/user_img_default.png';
    
    var validator = Xwb.use('Validator', {
        form:'#submitForm',
        trigger:'#submitBtn',
        validators :{
            // 对于新增的主持人，检测规则为:如果元素为空，忽略；如果不为空，必须存在用户
            username : function(elem, v, data, next){
                var self = this;
                // t:1为必须主持
                if(v){
                    MicroAdmin.checkInput(elem, function(b){
                        self.report(b, data);
                        next();
                    });
                }else {
                    // 可选新增主持
                    var b = !v || ( $(elem).closest('tr').find('input[type=hidden]').val() != '' );
                    self.report(b, data);
                    next();
                }
            },
            // 用于检测至少要输入一个用户
            userrequire : function(elem, v, data, next){
                var pass = false;
                var tbl = $(elem).closest('table');
                var holders = tbl.find('#_holder');
                if(!holders.length){
                    this.report(false, data);
                }else {
                    holders.each(function(){
                        if($(this).val()){
                            pass = true;
                            return false;
                        }
                    });
                    this.report(pass, data);
                }
                next();
            },
            pic : function(elem, v, data, next){
                if(!v){
                    data.m = '请上传'+data.c+'图片。';
                }
                this.report(v, data);
                next();
            }
        }
    });
    
    MicroAdmin.validator = validator;
    
</script>
</body>
</html>
