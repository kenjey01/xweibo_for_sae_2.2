<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>名人列表 - 名人堂管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">

function openPop(url,title) {
	window.openpop=Xwb.use('MgrDlg',{
		modeUrl:url,
		formMode:true,
		valcfg:{
			form:'AUTO',
			trigger:'#pop_ok'
		},
		dlgcfg:{
			onViewReady:function(View){
				var self=this;
				$(View).find('#pop_cancel').click(function(){
					self.close();
				});
				var pid = $(View).find('input[name="old_c_id1"]').val();
				if(pid == "0" || pid == '') pid = $(View).find('select[name="c_id1"]').val();
				ajax_load_add(pid);
			},
			destroyOnClose:true,
			title:title
		}
	})
};

function show_alert(msg, url)
{
	delConfirm(url,msg);
}

function ajax_load(id)
{
	$('#cid_2_span').load("<?php echo URL('mgr/celeb_mgr.ajaxGetCatList', 'all=1&parent_id='); ?>" + id);
}

function ajax_load_add(id)
    {
    	$('#add_cid_2_span').load("<?php echo URL('mgr/celeb_mgr.ajaxGetCatList', 'all=0'); ?>&parent_id=" + id + "&id=" + 2,'',function(){
    		if( window.openpop.dlg.jq('input[name="old_c_id2"]').val() )
    			$('#add_cid_2_span >select').val(window.openpop.dlg.jq('input[name="old_c_id2"]').val());
    	});
    }


</script>
</head>
<body id="star-userlist" class="main-body">
	<div class="path"><p>当前位置：用户管理<span>&gt;</span><a href="<?php echo URL('mgr/celeb_mgr.starCatList'); ?>">名人管理</a><span>&gt;</span>名人列表</p></div>
    <div  class="main-cont">
    	<h3 class="title"><a class="btn-general" href="javascript:openPop('<?php echo URL('mgr/celeb_mgr.addStar', array('pid'=>V('g:c_id1'),'cid'=>V('g:c_id2'))); ?>','添加名人');"><span>添加名人</span></a>名人列表</h3>
		<div class="set-area">
        	<div class="search-area">
                <form action="<?php echo URL('mgr/celeb_mgr.starList');?>" id="searchUser" method="post">
                    <div class="item">
                        <label><strong>搜索包含以下昵称的名人</strong></label>
                        <input name="nick" class="ipt-txt w200" type="text" value="<?php echo $search_arr['nick']; ?>"/>
                        <span><select name="c_id1" class="input-box" onchange="javascript:ajax_load(this.value);"><option value="0">所有顶级分类</option><?php foreach ($topCat as $cat_id => $cat_name): echo ('<option value="' . $cat_id . '"' . ($cat_id == $search_arr['cid_1'] ? ' selected="selected"' : '') . '>' . $cat_name . '</option>'); endforeach; ?></select></span>
                        <span id="cid_2_span"><select name="c_id2" class="select"><option value="0">所有二级分类</option><?php foreach ($secCat as $cat_id => $cat_name): echo ('<option value="' . $cat_id . '"' . ($cat_id == $search_arr['cid_2'] ? ' selected="selected"' : '') . '>' . $cat_name . '</option>'); endforeach; ?></select></span>
                        <a href="javascript:$('#searchUser').submit();" class="btn-general"><span>搜索</span></a>
                        <!--<span class="tips-error hidden" id="nickTip"></span>-->
                        <input type="hidden" name="char_index" value="" id="charIndexInput" disabled="disabled" />
                    </div>
                </form>
            </div>
			<div class="search-area">
				<p class="link-index">
					<strong>按字母检索</strong>
					<?php for($i = 1; $i <= 26; $i++): 
						$charUrl = ($i==$search_arr['char_index']) ? '<strong class="selected" >'.chr(64 + $i).'</strong>' 
									: '<a href="#" onclick="charIndexSearch('.$i.')" >'.chr(64 + $i).'</a>';
						echo ($charUrl); 
					endfor; ?>
						<?php if (0===$search_arr['char_index']) { echo '<strong  class="selected" >其它</strong>'; } else {echo '<a href="javascript:void(0);" onclick="charIndexSearch(-1)">其它</a>'; }?>
				</p>
			</div>
            <table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
                <colgroup>
                    <col class="w70" />
                    <col class="w140" />
                    <col class="w150" />
                    <col />
                    <col class="w210" />
                </colgroup>
                <thead class="tb-tit-bg">
                <tr>
                    <th><div class="th-gap">编号</div></th>
                    <th><div class="th-gap">昵称</div></th>
                    <th><div class="th-gap">添加时间</div></th>
                    <th><div class="th-gap">所属分类</div></th>
                    <th><div class="th-gap">操作</div></th>
                </tr>
                </thead>
                <tfoot class="tb-tit-bg">
                <tr>
                    <td colspan="5">
                        <div class="pre-next">
                            <?php echo $pager;?>
                        </div>
                    </td>
                </tr>
                </tfoot>
                <tbody>
                <?php if(isset($list) && is_array($list) && !empty($list)):?>
                 <?php foreach($list as $value):?>
				 <?php if(!F('user_action_check',array(3),$value['sina_uid'])) :?>
                    <tr>
                        <td>
                            <?php echo ++$num;?>
                        </td>
                        <td>
                            <a href="<?php echo URL('ta', 'id='.$value["sina_uid"], 'index.php'); ?>"  target="_blank" ><?php echo F('escape', $value['nick']); ?></a>
                        </td>
                        <td>
                            <?php echo date('Y-m-d H:i', $value['add_time']); ?>
                        </td>
                        <td>
                            <?php echo $value['cat_name_1'] . ' - ' . $value['cat_name_2']; ?>
                        </td>
                        <td>
                                <a class="icon-edit" href="javascript:openPop('<?php echo URL('mgr/celeb_mgr.addStar', 'c_id1=' . $value['c_id1'] . '&c_id2=' . $value['c_id2']) . '&sina_uid=' . $value['sina_uid']; ?>','编辑名人信息');">编辑</a>
                                <a class="icon-del" href="javascript:delConfirm('<?php echo URL('mgr/celeb_mgr.delStar', 'c_id1=' . $value['c_id1'] . '&c_id2=' . $value['c_id2'] . '&sina_uid=' . $value['sina_uid']); ?>','确认要删除吗？')">删除</a>
                        </td>
                    </tr>
					<?php endif;?>
                 <?php endforeach;?>
                <?php else:?>
                    <tr><td colspan="5"><p class="no-data">没有搜索到任何记录</p></td></tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
<div class="win-pop win-fixed edit-famer hidden" id="pop_window"></div>
<div id="pop_mask" class="mask hidden"></div>

<script type='text/javascript'>
	function charIndexSearch(index) {
		$('#charIndexInput').val(index).removeAttr('disabled');
		$('#searchUser').submit();
	}
</script>
</body>
</html>
