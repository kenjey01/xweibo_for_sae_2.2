<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新建话题微博单元 - 新建内容输出单元 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mod/wbshow.js"></script>
</head>
<script>
function changTabStyle(id) {
	if (!id) {
		return false;
	}
	var array_style = new Array('base_style_area', 'ext_style_area');
	var k;
	$('#'+id).css('display', '');
	$('#li_'+id).removeClass('current');
	$('#li_'+id).addClass('current');
	for (k in array_style) {
		if (id == array_style[k]) {
			continue;
		}
		$('#'+array_style[k]).css('display', 'none');
		$('#li_'+array_style[k]).removeClass('current');
	}
}
$(function(){
	$('#submitBtn').click(function(){
		$('#styleForm').submit();
		});
	});
</script>
<body class="main-body">
	<div class="path"><p>当前位置：扩展工具<span>&gt;</span><a href="<?php echo URL('mgr/content_unit'); ?>">站外调用</a><span>&gt;</span><?php if (isset($id)):?>设置内容输出单元<?php else:?>新建内容输出单元<?php endif;?><span>&gt;</span><?php if (!isset($id)): echo $unitType . '单元'; else:?><?php echo isset($row['unit_name']) ? F('escape', $row['unit_name']) : ''; ?><?php endif;?></p></div>
    <div class="main-cont">
		<h3 class="title"><?php if (isset($id) && !empty($id)): echo $unitType; ?>单元: <?php echo isset($row['unit_name']) ? F('escape', $row['unit_name']) : ''; ?><?php else: ?>新建<?php echo $unitType; ?>单元<?php endif;?></h3>
		<div class="set-area">
			<div class="panel">
            	<div class="panel-l">
				<form id="styleForm" action="<?php echo URL('mgr/content_unit.save');?>" method="post">
                    <div class="panel-set">
            			<div class="skinlist-menu">
							<ul class="skin-menu1">
                            	<li id="li_base_style_area" class="current"><a href="javascript:void(0)" onclick="changTabStyle('base_style_area')">基础设置</a></li>
								<li id="li_ext_style_area"><a href="javascript:void(0)" onclick="changTabStyle('ext_style_area')">样式设置</a></li>
							</ul>
						</div>
                        <div class="style-con">
                        	<div id="base_style_area" class="exp-style">
                            	<div class="con-wrap">
                                	<h4>输出单元名称：</h4>
    								<input name="unit_name" class="ipt-txt w150" type="text" value="<?php echo isset($row['unit_name']) ? F('escape', $row['unit_name']) : '';?>" />
    							</div>
    							<?php if ($type == 5): ?>
    							<div class="con-wrap">
                                	<h4>群组微博标题：</h4>
    								<input name="title" class="ipt-txt w150" type="text" value="<?php echo isset($row['title']) ? F('escape', $row['title']) : ''; ?>" /></p>
                                </div>
                                <?php endif; ?>
                                <div class="con-wrap">
                                	<h4>设置尺寸：</h4>
									<span class="con-edge">宽<input name="width"  class="ipt-txt w50 input-disabled" type="text" vrel="_f|dimention" value="<?php echo isset($row['width']) && $row['width'] > 0 ? $row['width'] : 350;?>" id="iptAutoWidth" <?php if (isset($row['width']) && $row['width'] > 0):?><?php else:?>disabled="disabled" <?php endif;?> />px</span>
									<span class="con-edge">高<input name="height" id="viewHeight" class="ipt-txt w50" vrel="_f|dimention" type="text" value="<?php echo isset($row['height']) ? $row['height'] : 550;?>" />px</span>
                                	<p>宽度:190-1024px，高度:75-800px</p>
									<span class="con-edge"><label><input id="chkAutoWidth" name="adaptive" class="ipt-checkbox" type="checkbox" value="1" <?php if (isset($row['width']) && $row['width'] > 0):?><?php else:?>checked="checked"<?php endif;?> />宽度自动适应</label></span><?php if ($type == 3): ?><br /><span class="con-edge"><label><input id="show_publish" name="show_publish" class="ipt-checkbox" type="checkbox" value="1" <?php if (!isset($row['show_publish']) || !empty($row['show_publish'])): ?>checked="checked"<?php endif; ?> />显示发布框</label></span><span class="con-edge"><label><input id="auto_scroll" name="auto_scroll" class="ipt-checkbox" type="checkbox" value="1" <?php if (!isset($row['auto_scroll']) || !empty($row['auto_scroll'])): ?>checked="checked"<?php endif; ?> />话题自动滚动</label></span><?php endif; ?>
                                </div>
                                <div class="con-wrap reset-bg">
    								<?php if ($type == 1):?>
                                	<h4>设置微博秀用户(昵称)：</h4>
    								<input name="target" class="ipt-txt w150" type="text" value="<?php echo isset($row['target']) ? F('escape', $row['target']) : '';?>" />
    								<?php elseif ($type == 3):?>
                                	<h4>设置话题：</h4>
    								<input name="target" class="ipt-txt w150" type="text" value="<?php echo isset($row['target']) ? F('escape', $row['target']) : '';?>" />
    								<?php else:?>
                                	<a href="<?php echo URL('mgr/admin.index#4,1', '', 'admin.php'); ?>" class="fr-info" target="_blank">创建管理用户列表</a><h4>选择用户列表：</h4>
    								<select name="target">
										<option value='0'  disabled='disabled'>请选择用户列表</option>
    								<?php foreach ($re_list as $item):?>
    									<option value="<?php echo $item['group_id'];?>" <?php if (isset($row['target']) && ($row['target'] == $item['group_id'])):?>selected="selected"<?php endif;?>><?php echo $item['group_name'];?></option>
    								<?php endforeach;?>
    								</select>
    								<?php endif;?>
                                </div>
                        	</div>
                        	<div id="ext_style_area" class="exp-style" style="display:none">
                        		<div class="con-wrap">
                            		<h4>模块设置</h4>
                                	<span class="con-edge">
									<input name="show_title" id="mod1" class="ipt-checkbox" type="checkbox" <?php if (isset($row['show_title']) && empty($row['show_title'])):?><?php else:?>checked="checked"<?php endif;?> value="1" />
                                        <label for="mod1">显示标题栏</label>
                                    </span>
                                	<span class="con-edge">
                                    	<input name="show_border" id="mod2" class="ipt-checkbox" type="checkbox" <?php if (isset($row['show_border']) && empty($row['show_border'])):?><?php else:?>checked="checked"<?php endif;?> value="1" />
                                    	<label for="mod2">显示边框</label>
                                    </span><br />
                                	<span class="con-edge">
                                    	<input name="show_logo" id="mod3" class="ipt-checkbox" type="checkbox" <?php if (isset($row['show_logo']) && empty($row['show_logo'])):?><?php else:?>checked="checked"<?php endif;?> value="1" />
                                    	<label for="mod3">显示LOGO栏</label>
                                    </span>
                            	</div>
                            	<div class="con-wrap reset-bg">
                            		<h4>外观方案</h4>
                                	<div class="color-slt" id="skinPanel">
										<?php for ($i=1; $i<=10; $i++) {?>
                                    	<a href="" <?php if ((isset($row['skin']) && $row['skin']== $i) || (!isset($row['skin']) && $i === 1)) {?>class="on"<?php }?>><span class="color<?php printf('%02d', $i);?>"><em></em></span></a>
                                    	<?php }?>
                                	</div>
                            	</div>
                        	</div>
                        </div>
						<input type="hidden" id="skinType" name="skin" value="<?php echo isset($row['skin']) ? $row['skin'] : 1;?>" />
						<input type="hidden" name="type" value="<?php echo $type;?>" />
						<input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0;?>" />
                	</div>
                    <div class="exp-code">
                        <p class="get-code">设置完成,获得嵌入代码:</p>
						<textarea name="" id="output" class="input-area code-area" cols="" rows=""><?php echo $iframe_code;?></textarea>
                    </div>
                    <div class="btn-area">
                    	<a href="#" class="btn-general highlight" id='submitBtn'><span>保存设置</span></a>
                    	<a href="#" class="btn-general" id="getCode"><span>获取代码</span></a>
                    </div>
                    </form>
                </div>
                <div class="panel-r">
				<h3>效果预览：</h3>
				<iframe class="exp-main" id="export" name="export" width="<?php echo isset($row['width']) && $row['width'] > 0 ? $row['width'] : '100%';?>" height="<?php echo isset($row['height']) ? $row['height'] : 550;?>" frameborder="0" src="<?php echo $iframe_url;?>"  scrolling="no"></iframe>
                </div>
            </div>
        </div>
    

<!-- 已创建的列表 -->

        <h3 class="title"><a class="btn-add" href="<?php echo URL('mgr/content_unit.show');?>"><!--<span>添加新的单元</span>--></a>
        <?php
        switch($type){
            case '2':
                echo '用户列表单元';
                break;
            case '3':
                echo '互动话题单元';
                break;
            case '4':
                echo '一键关注单元';
                break;
            case '5':
                echo '群组微博单元';
                break;
                
            case '1':
            default:
                echo '微博秀单元';
                break;
                
        }
        ?>
        列表
        
        </h3>
        <div class="set-area">
            <table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
                <colgroup>
                        <col class="w70" />
                        
                        <col />
                        <!--<col class="operate-w13" />-->
                        <col class="w150" />
                        <col class="w120" />
                        
                    </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">输出单元标题</div></td>
                        <!--<th class="skincategory-name"><div class="th-gap">输出单元类型</div></th>-->
                        <th><div class="th-gap">最后更新日期</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg"></tfoot>
                <tbody>
                    <?php 
                    $row = 1;
                    foreach ($list as $item):					
                    ?>
                    <tr>
                        <td><?php echo $row; $row++?></td>
                        <td><?php echo F('escape', $item['unit_name']);?></td>
                        
                        <td><?php echo date('Y-m-d H:i:s', $item['add_time']);?></td>
                        <td><a class="icon-del" href="javascript:delConfirm('<?php echo URL('mgr/content_unit.del', 'id='.$item['id'].'&type='.$item['type']);?>');">删除</a><a href="<?php echo URL('mgr/content_unit.set', 'id='.$item['id'].'&type='.$item['type']);?>" class="icon-set">设置</a></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>










<!-- 已创建的列表 -->
<script> gPreviewUrl = '<?php echo $preview_url;?>';</script>
</body>
</html>
