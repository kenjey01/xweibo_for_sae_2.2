<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link type="text/css" rel="stylesheet" href="<?php echo W_BASE_URL;?>css/admin/admin.css" media="screen" />
	<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
	<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/admin/admin_lib.js'></script>
	<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/admin-all.js'></script>
	<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/skin_custom.js"></script>
	<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/extra/colorpicker.js"></script>
	<link type="text/css" href="<?php echo W_BASE_URL;?>css/colorpicker/colorpicker.css" rel="stylesheet">
	<link href="<?php echo W_BASE_URL ?>css/default/skin_set.css" rel="stylesheet" type="text/css" />
<script type='text/javascript'>
	var ModeHtml=[' <form id="skin_form" action="<?php echo URL('mgr/skin.editSkin');?>" method="post"  name="add-newlink">',
					'	<div class="form-box">',
	            	'		<div class="form-row"><label class="form-field">皮肤名称：</label><span id="skin_name"></span></div>',
	            	'		<div class="form-row">',
	            	'			<label for="skin-slect-default" class="form-field">所属类别：</label>',
	                '   		<select name="style_id" id="select_id" class="skin-slect-default">',
					'				<?php foreach($sort as $value):?>',
					'					<option value="<?php echo $value['style_id'];?>" ><?php echo $value['style_name'];?></option>',
					'				<?php endforeach;?>',
	                '    		</select>',
	                ' 		</div>',
	                '    	<div class="btn-area">',
					'			<input type="hidden" name="id" id="skin_id" value="" />',
                	'       	<a class="btn-general highlight" href="#" id="submitBtn"><span>确定</span></a>',
                	'       	<a class="btn-general" href="#" id="pop_cancel"><span>取消</span></a>',
	                '   	 </div>',
	            	'	</div>',
                '</form>'].join('');
                
$(function(){
		var switcher1 = new Switcher({
			items: $('#skin-type a'),

			contents: $('#skin-tabs>.tab'),

			trigMode: 'click',

			selectedCS: 'current'
		});
		
		
		var switcher = new Switcher({
			items: $('#skin-menu1 li'),

			contents: $('#skin-main1>div'),

			trigMode: 'click',

			selectedCS: 'current'
		});
		
		
		$('#submit').click(function(){
			$('#default_form').submit();
			});
		$('#submitBtn').click(function(){
			$('#skin_form').submit();
			});		
});
		
/*   function setTab(m,n){
		var tli=document.getElementById("skin-menu"+m).getElementsByTagName("li");
		var mli=document.getElementById("skin-main"+m).getElementsByTagName("div");
		for(i=0;i<tli.length;i++){
			tli[i].className=i==n?"current":"";
			mli[i].style.display=i==n?"block":"none";
		}
	}*/

	function edit(id, style_id, text){
	
	Xwb.use('MgrDlg',{
		modeHtml:ModeHtml,
		formMode:true,
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
				$(View).find('#skin_id').val(id);
				$(View).find('#select_id').val(style_id);
				$(View).find('#skin_name').html(text);
			},
			destroyOnClose:true,
			actionMgr:false,
			title:'修改皮肤所属的类别'
		}
	})
	}
</script>
<style type="text/css">
#skin-main iframe{
	width:100%;
	height:100%;
	border:none
}
</style>
</head>

<body class="main-body">
	<div class="path"><p>当前位置：界面管理<span>&gt;</span>皮肤</p></div>
	<div class="main-cont clear">
		<div class="tab-box">
			<h5 class="tab-nav tab-nav-s1 clear" id='skin-type'>
				<a href="#" class="current"><span>选择皮肤</span></a>
				<a href="#"><span>自定义皮肤</span></a>

			</h5>
			<div class="tab-con-s1" id='skin-tabs'>
				<!-- tab内容 -->
				<div class='tab'>
					<div  class="main-cont">
        <div class="set-area">
        	<div class="search-area">
                <form  action="<?php echo URL('mgr/skin.setSkinDefault');?>" id='default_form' method="post">
                	<div class="item">
                    	<label><strong>设置默认皮肤</strong></label>
                        <select name="skin_default_id"  class="select w150">
						   <?php foreach($list as $value):?>
                               <?php if($value['state'] < 1):?>
                                   <option value="<?php echo $value['skin_id'];?>" <?php if($sysconfig['skin_default'] == $value['skin_id']){echo 'selected=selected';}?>><?php echo $value['name'];?></option>
                               <?php endif;?>
                           <?php endforeach;?>
                       </select>
                        <a class="btn-general" href="#" id='submit'><span>确定</span></a>
                        <span class="desc">(注：未启用以及不兼容的皮肤都不能设为默认皮肤)</span>
                    </div>
                </form>
            </div>
        </div>
        
        <h3 class="title"><a class="btn-general" href='<?php echo URL('mgr/skin.getAllSkinSort');?>'><span>类别管理</span></a>所有可用的皮肤</h3>
		<div class="set-area">
			<div class="skinlist-menu">
				<ul id="skin-menu1" class="skin-menu1">
					<li class="current">全部皮肤</li>
					<?php $i=1;foreach($sort as $value):?>
					<li><?php echo $value['style_name'];$i++;?></li>
					<?php endforeach;?>
				</ul>
			</div>
			<div class="skin-main" id="skin-main1">
                <div>
                	<table class="table skin-t" width="100%" cellpadding="0" cellspacing="0" border="0">
                    	<colgroup>
							<col class="w50" />
    						<col class="w80" />
    						<col class="w70" />
    						<col />
    						<col class="w80" />
                            <col class="w70" />
                            <col class="w110"/>
                            <col class="w120" />
    					</colgroup>
						<thead class="tb-tit-bg">
							<tr>
   					  			<th><div class="th-gap">编号</div></th>
   					  			<th><div class="th-gap">皮肤名称</div></th>
   					  			<th><div class="th-gap">类别</div></th>
   					  			<th><div class="th-gap">说明</div></th>
                        		<th><div class="th-gap">预览图</div></th>
   					  			<th><div class="th-gap">状态</div></th>
   					  			<th><div class="th-gap">存放目录</div></th>
   					  			<th><div class="th-gap">操作</div></th>
				  			</tr>
              			</thead>
                        <tfoot  class="tb-tit-bg"></tfoot>
                		<tbody>
							<?php $i=1;foreach($list as $value):?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><?php echo $value['name'];?></td>
									<td><?php if(isset($value['skin_group'])&&$value['skin_group']){echo $value['skin_group']['style_name'];}else{echo '未分类';}?></td>
									<td><?php echo $value['desc'];?></td>
									<td><img src="<?php echo  W_BASE_URL . 'css/default/' . $value['directory'] . '/' . SKIN_PRE_PIC;?>" /></td>
									<td>
									
									<?php
									if($value['state'] < 1) {echo '已启用';}
									elseif($value['state'] == 1){echo '已禁用';}
									elseif($value['state'] == 2){echo '不兼容';}
									?>
									
									</td>
									<td><?php echo $value['directory'];?></td>
									<td>
									
										<?php if(!$value['state']):?>
											<a class="icon-edit" title="编辑" href="javascript:edit('<?php echo $value['skin_id'];?>','<?php echo $value['style_id'];?>','<?php echo $value['name'];?>')" >编辑</a>
                                            <a class="icon-forbid" href="<?php echo URL('mgr/skin.setSkinState', 'state=1&id=' . $value['skin_id']);?>">禁用</a>
										<?php endif;?>
										<?php if($value['state'] == 1):?>
											<a  class="icon-edit"  title="编辑" href="javascript:edit('<?php echo $value['skin_id'];?>','<?php echo $value['style_id'];?>','<?php echo $value['name'];?>')" >编辑</a>
                                            <a class="icon-using" href="<?php echo URL('mgr/skin.setSkinState', 'state=0&id=' . $value['skin_id']);?>">启用</a>
										<?php endif;?>
										<?php if($value['state'] == 2):?>
											无法操作
										<?php endif;?>
										
									</td>
								</tr>
							<?php endforeach;?>

						</tbody>
					</table>
                </div>
				<?php if($sort):?>
				<?php foreach($sort as $value):?>
                <div class="hidden">
                	<table class="table skin-t" cellpadding="0" cellspacing="0" width="100%" border="0">
                    	<colgroup>
							<col class="w50" />
    						<col class="w80" />
    						<col class="w70" />
    						<col />
    						<col class="w80" />
                            <col class="w70" />
                            <col class="w110" />
                            <col class="w120" />
    					</colgroup>
						<thead class="tb-tit-bg">
							<tr>
   					  			<th><div class="th-gap">编号</div></th>
   					  			<th><div class="th-gap">皮肤名称</div></th>
   					  			<th><div class="th-gap">类别</div></th>
   					  			<th><div class="th-gap">说明</div></th>
                        		<th><div class="th-gap">预览图</div></th>
   					  			<th><div class="th-gap">状态</div></th>
   					  			<th><div class="th-gap">存放目录</div></th>
   					  			<th><div class="th-gap">操作</div></th>
				  			</tr>
              			</thead>
                        <tfoot class="tb-tit-bg"></tfoot>
                		<tbody>
						<?php if(isset($skin_sort_list[$value['style_id']])):?>
							<?php $i=1;foreach($skin_sort_list[$value['style_id']] as $value):?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><?php echo $value['name'];?></td>
									<td><?php if($value['skin_group']){echo $value['skin_group']['style_name'];}else{echo '未分类';}?></td>
									<td><?php echo $value['desc'];?></td>
									<td><img src="<?php echo W_BASE_URL . 'css/default/' . $value['directory'] . '/' . SKIN_PRE_PIC;?>" width="51" height="38" /></td>
									
									<td>
									
									<?php
									if($value['state'] < 1) {echo '已启用';}
									elseif($value['state'] == 1){echo '已禁用';}
									elseif($value['state'] == 2){echo '不兼容';}
									?>
									
									</td>
									<td><?php echo $value['directory'];?></td>
									<td>
									
										<?php if(!$value['state']):?>
											<a  class="icon-edit"  title="编辑" href="javascript:edit('<?php echo $value['skin_id'];?>','<?php echo $value['style_id'];?>','<?php echo $value['name'];?>')" >编辑</a>
                                            <a class="icon-forbid" href="<?php echo URL('mgr/skin.setSkinState', 'state=1&id=' . $value['skin_id']);?>" class="using">禁用</a>
										<?php endif;?>
										<?php if($value['state'] == 1):?>
											<a  class="icon-edit"  title="编辑" href="javascript:edit('<?php echo $value['skin_id'];?>','<?php echo $value['style_id'];?>','<?php echo $value['name'];?>')" >编辑</a>
                                            <a class="icon-using" href="<?php echo URL('mgr/skin.setSkinState', 'state=0&id=' . $value['skin_id']);?>">启用</a>
										<?php endif;?>
										<?php if($value['state'] == 2):?>
											无法操作
										<?php endif;?>
										
									</td>
								</tr>
							<?php endforeach;?>
						  <?php else:?>
								<tr>
                                	<td colspan="8"><p class="no-data">尚没有任何记录</p></td>
                                </tr>
						  <?php endif;?>
						</tbody>
					</table>
                </div>
				<?php endforeach;?>
				<?php endif;?>
             </div>
            
    	</div>
    </div>
<div id="edit_class"></div>
				</div>
				
				
				<div class='tab hidden' >
					<div class="main-cont">
        <div class="skin-set" id="skinSet">
        	<div id="colorSelector" style="display:none;"><div style="background-color: #0000ff"></div></div>
			<div id="csArea" class="cp-parent">
				<div class="cp-oper"><span class="txt" id="cltitle">主链接色</span><span class="c-view" id="cRealColor"><span style="background:#0082cb;"></span></span><label>#<input value="" class="input-txt" id="colorshow" /></label></div>
				<a href="#" class="btn-close" rel="e:closeCls"></a>
			</div>
            <div class="skin-set-in">
		<?php
				$colorAlpha=array('#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb');
				$eachPage=10;
				$margeEach=-300;
				
				
				$colorPage=array();
				$i=0;
				foreach($colorConf as $color){
					$colorPage[$i/$eachPage][]=$color;
					$i++;
				}
				$index=1;
				$pageCount=count($colorPage);
				
				if(isset($customSkin)){
					if(isset($customSkin['colorid'])){
						$nowPage=(int)$customSkin['colorid']/$eachPage+1;
					}
					else{
						$nowPage=1;
					}
				}
				else{
					$nowPage=1;
				}
				//var_dump($nowPage);
				$margeStart=0;
				$margeStart+=($nowPage-1)*$margeEach;
		?>
                <div class="skin-custom">
                    <div class="skin-setbg">
                        <div class="upload-pic">
							<img rel='<?php if(isset($customSkin['bg'])) echo 'u:1'?>' src="<?php if(isset($customSkin['bg'])) echo $customSkin['bg']; else echo W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/upload_pic.png'?>" alt="" id="previewImg"/>
							<a href="#" class="icon-close-btn <?php if(!isset($customSkin['bg'])) echo 'hidden';?>"></a>
						</div>
                        <div class="oper-area">
                        	<div class="frm-row">
                                <form id="xwb_back_form" target="" action="<?php echo URL('mgr/setting.skinBGUpload');?>" enctype="multipart/form-data" method="post" >
                                    <input type="file" value="浏览" id="xwb_back_file" name="skinbg"/>
                                </form>
                            </div>
                            <h5>设置背景图</h5>
                            <div class="setbg-way">
				<label for="bg-repeat" rel="e:bgLevel"><input type="checkbox" <?php if(isset($customSkin['tiled'])&&$customSkin['tiled']=='1') echo 'checked=checked'?> id="bg-repeat" />背景平铺</label>
                            </div>
                            <div class="setbg-way">
                                <label for="bg-fixed"  rel="e:bgStrong"><input type="checkbox" <?php if(isset($customSkin['fixed'])&&$customSkin['fixed']=='1') echo 'checked=checked'?> id="bg-fixed" />背景固定</label>
                            </div> 
                            <div class="btn-align-bg" id="align">
                        <a href="#" class="<?php if(isset($customSkin['align'])&&$customSkin['align']=='1') echo 'cur'?>" rel="e:bgPlace,w:1">居左</a>
			<a href="#" class="<?php if(isset($customSkin['align'])&&$customSkin['align']=='2') echo 'cur'?>" rel="e:bgPlace,w:2">居中</a>
			<a href="#" class="<?php if(isset($customSkin['align'])&&$customSkin['align']=='3') echo 'cur'?>" rel="e:bgPlace,w:3">居右</a>    </div>
                        </div>
                    </div>	
                    <div class="skin-setcolor"  id="skin_setcolorArea">
                        <div class="preview-box">
                            <div class="pb-main">
                                <div class="pb-post-box">
                                    <div class="pb-post-btn"></div>
                                </div>
                                <div class="pb-list">
                                    <div class="pb-user-pic"></div>
                                    <div class="pb-con">
                                        <div class="c1"></div>	
                                        <div class="c2"></div>	
                                    </div>
                                </div>
                                <div class="pb-list">
                                    <div class="pb-user-pic"></div>
                                    <div class="pb-con">
                                        <div class="c1"></div>	
                                        <div class="c2"></div>	
                                    </div>
                                </div> 
                            </div>
                            <div class="pb-aside">
                                <div class="pb-user-con">
                                    <div class="pb-user-pic"></div>
                                    <div class="pb-user-info">
                                        <p class="ui1"></p>
                                        <p class="ui2"></p>
                                    </div>
                                </div>
                                <div class="pb-block">
                                    <div></div>
                                    <p></p>
                                </div>
                                <div class="pb-more"></div>
                                <div class="pb-block">
                                    <div></div>
                                    <p></p>
                                </div> 
                                <div class="pb-more"></div>
                            </div>
                        </div>
                        <div class="color-scheme">
                            <p>你还可以选择配色方案，丰富背景和字体颜色</p>
                            <div class="color-draw">
								<div class="color-area" id="color-area">
									<?php
									if(isset($customSkin)&&isset($customSkin['colors'])){
										$autoColor=TRUE;
										$printColor=explode(',',$customSkin['colors']);
									}
									if(isset($autoColor)&&$autoColor&&count($printColor)==5):
									?>
									<a href="#" rel="e:cls,t:0" key="<?php echo $printColor[0]?>" class="cur" title="主链接色"><span style="background:#<?php echo $printColor[0]?>;"></span></a>
									<a href="#" rel="e:cls,t:1" key="<?php echo $printColor[1]?>" title="辅链接色"><span style="background:#<?php echo $printColor[1]?>;"></span></a>
									<a href="#" rel="e:cls,t:2" key="<?php echo $printColor[2]?>" title="主背景色"><span style="background:#<?php echo $printColor[2]?>;"></span></a>
									
									<a href="#" rel="e:cls,t:3" key="<?php echo $printColor[3]?>" title="标题字体色"><span style="background:#<?php echo $printColor[3]?>;"></span></a>
									<a href="#" rel="e:cls,t:4" key="<?php echo $printColor[4]?>" title="主文字色"><span style="background:#<?php echo $printColor[4]?>;"></span></a>
									<?php
									else:
									?>
									<a href="#" rel="e:cls,t:0" key="0082cb" class="cur" title="主链接色"><span style="background:#0082cb;"></span></a>
									<a href="#" rel="e:cls,t:1" key="44b1da" title="辅链接色"><span style="background:#44b1da;"></span></a>
									<a href="#" rel="e:cls,t:2" key="8dd7f5" title="主背景色"><span style="background:#8dd7f5;"></span></a>
									
									<a href="#" rel="e:cls,t:3" key="444" title="标题字体色"><span style="background:#444;"></span></a>
									<a href="#" rel="e:cls,t:4" key="000" title="主文字色"><span style="background:#000;"></span></a>
									<?php
									endif;
									?>
								</div>
                                <div class="pages">
                                    <!--<a href="#" class="arrow-l-s1 arrow-l-s1-disabled" id="skin_backPrev"></a>
                                    <span  id="skin_page">1/1</span>
                                    <a href="#" class="arrow-r-s1 arrow-r-s1-disabled" id="skin_backNext"></a>-->
                                </div>
                            </div>
                            <div class="scheme-select" id="skin_backLists">
                                <ul id="scheme-select" style="margin-left:0px">
					<?php
					foreach($colorPage as $k=>$page):
					?>
					<li>
						
						<?php
						
						foreach($page as $color):
						?>
						<div  rel="e:clbs,t:<?php echo $index;?>,w:<?php echo implode('-',$color);?>" class="c-box <?php if(isset($customSkin)&&isset($customSkin['colorid'])&&(int)$customSkin['colorid']==$index) echo 'cur'?>">
						
						<?php
						foreach($color as $i=>$c):
						?>
							<span class="c-bg" style="background:<?php /*if($i==3) {echo $colorAlpha[$c];} else{*/echo $c;/*}*/ ?>;"></span>
						<?php
						endforeach;
						?>
							
						</div> 
						
						<?php
						$index++;
						endforeach;
						?>
					</li>
					<?php
					endforeach;
					?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="btn-area skin-btn-area">
            <a href="" class="btn-general highlight" rel="e:prv"><span>预览</span></a>
            <a href="#" class="btn-general" rel="e:save"><span>保存</span></a>
        </p>
    </div>
				</div>
					<!--<iframe width="100%" height="100%" frameborder="0" src='<?php echo URL('mgr/skin.getAllSkin')?>'></iframe>
			
				
				
					<iframe class='hidden' width="100%" height="100%" frameborder="0" src='<?php echo URL('mgr/skin.customSkin')?>'></iframe>-->
				
			</div>
		</div>
		
		
	</div>
</body>
</html>
