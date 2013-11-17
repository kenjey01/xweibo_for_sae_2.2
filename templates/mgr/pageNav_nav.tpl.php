<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>界面管理 - 模板管理 - 导航</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：界面管理<span>&gt;</span>导航</p></div>
	<div class="main-cont">
        <h3 class="title">导航设置</h3>
        <div class="set-area">
            <p class="tips-desc">温馨提示：你可以在<a href="<?php echo URL('mgr/page_manager'); ?>">页面设置</a>中创建一个新页面，然后通过添加导航选择这个页面，就可以创建一个新的导航了。</p>
            <form method="post" id="form1" action="<?php echo URL('mgr/page_nav.updateNav');?>">
                <table class="table table-s1" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <colgroup>
                        <col class="w90" />
                        <col class="w130" />
                        <col class="w150"/>
                        <col/>
                        <col class="w50"/>
                        <!--<col class="operate-w12"/>-->
                        <col class="w120" />
                    </colgroup>
                    <thead class="tb-tit-bg">
                        <tr>
                            <th><div class="th-gap">排序</div></th>
                            <th><div class="th-gap">名称</div></th>
                            <th><div class="th-gap">页面</div></th>
                            <th><div class="th-gap">URL</div></th>
                            <th><div class="th-gap">显示</div></th>
                            <!--<th><div class="th-gap">新窗口打开</div></th>-->
                            <th><div class="th-gap">操作</div></th>
                        </tr>
                    </thead>
                    <tfoot class="tb-tit-bg"></tfoot>
                    <tbody>
                        
                    <?php 
                        function getSelectHtml($id, $pageId, &$pageList)
                        {
                            $pageSelect = "<select name='data[$id][page_id]' onchange='changeUrl(this.value, $id)'  vrel='isSave' class='select'><option value='0'>请选择</option>";
                            foreach ($pageList as $aPage)
                            {
                                $selected = ($pageId==$aPage['page_id']) ? 'selected' : '';
                                $pageSelect .= "<option value='{$aPage['page_id']}' $selected >{$aPage['page_name']}</option>";
                            }
                            
                            $selected = ($pageId==='-1') ? 'selected' : '';
                            $pageSelect .= "<optgroup label='--------------------------'><option value='-1' $selected >导航链接</option></optgroup></select>";
                            
                            return $pageSelect;
                        }

                        function aNavHtml($data, &$pageList, $isSon=FALSE)
                        {
                            $tpl = '<tr>
                                <td><input type="text" name="data[#id#][sort_num]" value="#sort_num#" #isSon# class="ipt-txt w50"  vrel="isSave"/></td>
                                <td><input type="text" name="data[#id#][name]" value="#name#" #isSon# class="ipt-txt" vrel="isSave"  flag="maxlen"/></td>
                                <td>#pageIdSelect#</td>
                                <td id="url_#id#">#url#</td>
                                <td><input type="checkbox" name="data[#id#][in_use]" value="1" #inUseChecked#   vrel="pid:#parent_id#,id:#id#,isSave"/></td>
                                
                                <td>#editLink##delLink#</td>
                            </tr>';
                            
                            $url 		= '';
                            $editLink 	= '';
                            $pageName	= '内置页面';
                            if ($data['page_id'] && isset($pageList[$data['page_id']])) 
                            {
                                $pageId	  = $pageList[$data['page_id']]['native'] ? FALSE : array('page_id'=>$data['page_id']);
                                $pageName = $pageList[$data['page_id']]['page_name'];
                                $url 	  = URL($pageList[$data['page_id']]['url'], $pageId, 'index.php');

                                if (!in_array($data['page_id'], array(3,6,35,7,8))) {
                                    $editLink = '<a href="'. URL('mgr/page_manager.setting', array('id'=>$data['page_id'])) .'" class="icon-set">设置</a>';
                                } elseif ($data['page_id'] == 7) {
                                    $editLink = '<a href="'. URL('mgr/wb_live.set') .'" class="icon-set">设置</a>';
	
								} elseif ($data['page_id'] == 8) {
                                    $editLink = '<a href="'. URL('mgr/micro_interview.set') .'" class="icon-set">设置</a>';
	
								} else {
									$editLink = '';	

								}
                            }
                            
                            $urlInputHtm 				= (0 > $data['page_id']) ? "<input type='text' name='data[{$data['id']}][url]' value='{$data['url']}' class='ipt-txt' vrel='isSave'/>" : '';
                            $replace['#id#'] 			= $data['id'];
                            $replace['#parent_id#'] 	= intval($data['parent_id']);
                            $replace['#sort_num#'] 		= $data['sort_num'];
                            $replace['#name#'] 			= $data['name'];
                            $replace['#pageIdSelect#'] 	= $data['isNative'] ? $pageName : getSelectHtml($data['id'], $data['page_id'], $pageList);
                            $replace['#url#'] 			= ($data['page_id']>0)  ? $url : $urlInputHtm;
                            $replace['#inUseChecked#'] 	= $data['in_use']   ? 'checked="checked"' : '';
                            //$replace['#isBlankChecked#']= $data['is_blank'] ? 'checked="checked"' : '';
                            $replace['#isSon#']			= $isSon ? 'style="margin-left:10px; background:#ffc;"' : '';
                            $replace['#editLink#']		= $editLink;
                            $replace['#delLink#']		= '<a href="javascript:delConfirm(\''.URL('mgr/page_nav.delNav', array('id'=>$data['id'])).'\')" class="icon-del">删除</a>';
                            if($data['isNative'] /*|| ($data['in_use'] && $data['page_id'] > 0)*/){
                                $replace['#delLink#'] = '';
                            }
                            
                            //echo nl2br(var_export($data, true));
                            
                            return str_replace(array_keys($replace), array_values($replace), $tpl);
                        }
                        
                        
                        $pidList = array();
                        foreach ($navList as $id => $aNav)
                        {
                            if (!isset($aNav['data'])) {
                                continue;
                            }
                            array_push($pidList, $aNav['data']['id']);
                            echo aNavHtml($aNav['data'], $pageList);
                            
                            // echo the son if has
                            if (isset($aNav['son']))
                            {
                                foreach ($aNav['son'] as $aSon)
                                {
                                    echo aNavHtml($aSon['data'], $pageList, TRUE);
                                }
                            }
                            
                            // 增加二级导航
                            //if ( 1!=PAGE_TYPE_CURRENT || isset($aNav['son'])) {
                                echo '<tr class="add-rows"><td colspan="6"><a href="javascript:;" rel="e:addnewlink,pid:'.$id.'" class="btn-general"><span>添加二级导航</span></a></td></tr>';
                            //}
                        }
                        
                        // 增加主导栏链接
                        //if (2 == PAGE_TYPE_CURRENT){
                            echo '<tr class="add-main-rows"><td colspan="6"><a href="javascript:;" rel="e:addnewlink,pid:0" class="btn-general "><span>添加主导航</span></a></td></tr>';	
                        //}
                    
                    ?>
                        
                    </tbody>
                    
                </table s>
                <p class="btn-area"><a href="#this" onclick = "disabledConfrom();$('#form1').submit();" class="btn-general highlight"><span>提交</span></a></p>
            </form>
        </div>
    </div>


<script type="text/javascript">
	function changeUrl(pageId, navId)
	{
		if (pageId < 0) {
			return $('#url_'+navId).html("<input type='text' name='data["+ navId +"][url]' value='' class='ipt-txt' vrel='isSave'/>");
		}
		
		var urlObj = {
	        <?php 
	        	foreach ($pageList as $key => $aPage)
	        	{
	        		$pageId	= $aPage['native'] ? FALSE : array('page_id'=>$key);
	        		$url 	= URL($aPage['url'], $pageId, 'index.php');
	        		echo "url_$key:'$url',";
	        	}
	        ?>
	        url_0:''
		};

		var url = eval('urlObj.url_'+pageId);
		$('#url_'+navId).html(url);
	}

	
	var adminAction=Xwb.use('action');
	
	adminAction.reg('addnewlink',function(e) {
		
		var _modehtml=[
				'<form name="add-newlink" id="sub" method="post">',
           		'<div class="form-box">',
           		'	<div class="form-row">',
           		'		<label class="form-field">导航名称</label>',
           		'		<div class="form-cont">',
				'			<input type="text" class="ipt-txt" name="data[name]"  vrel="_f|ne|sz=max:12,m:最多6个汉字,ww" warntip="#warntip"/>',
               	'			<span id="warntip" class="tips-error hidden"></span>',
           		'		</div>',
           		'	</div>',
           		'	<div class="form-row">',
           		'		<label class="form-field">链接页面</label>',
           		'		<div class="form-cont">',
				'			<select name="data[page_id]" class="w160" id="pageID">',
				<?php
				foreach ($pageList as $aPage)
				{
					echo "'<option value=\"{$aPage['page_id']}\" >{$aPage['page_name']}</option>',";
				}
				echo "'<optgroup label=\"--------------------------\"><option value=\"-1\" >导航链接</option></optgroup>',";
				?>
				'			</select>',
				'			<input  type="text" class="ipt-txt hidden" disabled = "disabled" id="Url" name="data[url]" vrel="_f|ne" warntip="#urltip" value="http://" />',
               	'			<span id="urltip" class="tips-error hidden"></span>',
           		'		</div>',
           		'	</div>',
           		'	<div class="form-row">',
           		'		<label class="form-field">&nbsp;</label>',
           		'		<div class="form-cont">',
				'			<label><input class="ipt-checkbox" type="checkbox" name="data[in_use]" checked="checked" value="1" /> &nbsp;立即显示在前台</label>',
           		'		</div>',
           		'	</div>',
                '	<div class="btn-area">',
				'		<input type="hidden" value="'+ e.get("pid") +'" id="parent_id" name="data[parent_id]" />',
                '       <a class="btn-general highlight" href="#" id="subok"><span>确定</span></a>',
                '       <a class="btn-general" href="#" rel="e:cal" id="pop_cancel"><span>取消</span></a>',
                '	</div>',
				'</div>',
            '</form>'].join('');
      var show = function(){
  	   		Xwb.use('MgrDlg',{
			dlgcfg:{
				cs:'win-nav win-fixed',
				title:'新导航名',
				destroyOnClose:true,
				onViewReady:function(){
					var self =this;
					this.jq('#pageID').change(function(){
						if($(this).val() == '-1'){
							self.jq('#Url').removeAttr('disabled').removeClass('hidden');
						} else {
							self.jq('#Url').attr('disabled','disabled').addClass('hidden');
						}
					})
				}
				}
			,valcfg:{
				form:'#sub',
				trigger:"#subok"
			}
			,url:"<?php echo URL('mgr/page_nav.doCreateNav'); ?>"
			,modeHtml:_modehtml
			,formMode:true
			});
      }
	  if( window.onbeforeunload  && Xwb && Xwb.gModified === false) {
	  	   Xwb.ui.MsgBox.confirm('提示','当前页面未保存,继续操作？',function(id){
	  	   		if(id=='ok'){
	  	   			Xwb.gModified=true;
	  	   			show();
	  	   		}
	  	   })
		} else {
			show();
		}
	},{na:true});
	
	$('[vrel]').each(function(){
		$(this).bind('change',function(){
			Xwb.gModified=false;
			var JQthis=$(this);
			if(JQthis.attr('type') ==='checkbox' && JQthis.attr('vrel').charAt(0) === 'p'){
				if( this.checked === false && JQthis.attr('vrel').substr(0,5)==='pid:0'){
					var selstr="input[vrel^='pid:"+ JQthis.attr('vrel').split(',')[1].split(':')[1]+"']";
					$(selstr).each(function(){
						this.checked=JQthis.get(0).checked;
					})
				} else {
					if(JQthis.get(0).checked){
						$("input[vrel^='pid:0,id:"+ JQthis.attr('vrel').split(',')[0].split(':')[1]+"']").attr('checked',true);
					}
				}
				var pidMax=<?php echo (2==PAGE_TYPE_CURRENT) ? 10 : 5; ?>;
				var thisPid=JQthis.attr('vrel').split(',')[0].split(':')[1];
				var plen=$("input[vrel^='pid:"+ thisPid +"']:checked").length;
				if(plen> (thisPid == 0 ? 10: pidMax)){
						Xwb.ui.MsgBox.alert('提示','温馨提示，导航太多可能会引起页面错位！');
						JQthis.attr("checked",'');
				}
			}
		});
	});

	$('input[flag="maxlen"]').each(function(){
		$(this).keydown(function(e){
			if(e.keyCode == 8) return ;
			if(Xwb.util.byteLen(this.value) >= 12) return false;
			else return true;
		})
		.keyup(function(){
			if(Xwb.util.byteLen(this.value) > 12){
				var t="";
				for(var i=0;i<this.value.length;i++){
					t+=this.value.charAt(i);
					if(Xwb.util.byteLen(t) > 12 ) {
						t=t.substring(0,t.length-1);
						break;
					}
				}
				
				this.value=t;
			}
		})
	})
	
	function disabledConfrom() {
		if(typeof window.onbeforeunload === 'function' && Xwb && Xwb.gModified === false){
			Xwb.gModified=true;
		}
	}
</script>
</body>
</html>
