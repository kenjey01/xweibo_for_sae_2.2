<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>审核微博 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick-<?php echo APP::getLang();?>.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick.css" />
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>

<script type="text/javascript">

<!--
function confirmDisable(url, data) {

	Xwb.ui.MsgBox.confirm('提示','确认要屏蔽该微博吗?',function(id){ 
		if(id == "ok"){
			Xwb.request.postReq(url, data,function(e) {
					if (e.isOk()) {
						window.location.reload();
					} else {
						Xwb.ui.MsgBox.alert('提示',e.getMsg());
					}
			});
		}
	});

}

function MM_jumpMenu(targ,selObj,restore){ //v3.0

  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");

  if (restore) selObj.selectedIndex=0;

}
$(function(){
	$('#start,#end').attr('readonly', 'true')
		.datepick({ 
			onSelect: function (dates) { 

				if (this.id == 'start') { 
					$('#end').datepick('option', 'minDate', dates[0] || null); 
				} 
				else { 
					$('#start').datepick('option', 'maxDate', dates[0] || null); 
				} 
			},
			dateFormat :'yyyy-mm-dd'
		});
		
	//全选
	$('#selectAll').click(function(){
		$('#dataList input[name="id[]"]').attr('checked',this.checked);
	});
	var lock = 1;
	
	//审核设置
	$('#setting').click(function(){
		if(lock == 0) return;
		lock = 1;
		Xwb.use('MgrDlg',{
			valcfg:{
				form:'#this_form',
				trigger:'#pop_ok'
			},
			dlgcfg:{
				title:'审核设置',
				destroyOnClose:true,
				isFixed : true,
				onViewReady:function(){
					var self = this;
					lock = 1;
					self.jq().css({'marginLeft':0});
					this.jq('#start,#end').attr('readonly', 'true')
						.datepick({ 
							onSelect: function (dates) { 

								if (this.id == 'start') { 
									self.jq('#end').datepick('option', 'minDate', dates[0] || null); 
								} 
								else { 
									self.jq('#start').datepick('option', 'maxDate', dates[0] || null); 
								} 
							},
							dateFormat :'yyyy-mm-dd'
						});
					this.jq('input[name="data[strategy]"]').click(function(){
						if(this.value == '1') {
							self.jq('#strategy1Div').show();
							selectVal(self.jq('input[name="data[type]"]:checked').val());
						} else {
							self.jq('#strategy1Div').hide();
							self.center();
						}
					});
					function selectVal(value){
						if(value == '0'){
							self.jq('div[rel="t1"]').show();
							self.jq('div[rel="t2"]').hide();
						} else {
							self.jq('div[rel="t2"]').show();
							self.jq('div[rel="t1"]').hide();
						}
						self.center();
					}
					this.jq('input[name="data[type]"]').click(function(){
						selectVal(this.value);
					});
					selectVal(self.jq('input[name="data[type]"]:checked').val());
				}
			},
			modeUrl:'<?php echo URL('mgr/setting.setStrategy'); ?>',
			url:'<?php echo URL('mgr/setting.setStrategy'); ?>',
			formMode:true
		});
		return false;
	});
	//批量通过
	$('#Pass,#del,#unshield,#disable_batch').click(function(){
		var ids =  getSelectID(),url;
		switch (this.id){
			case 'Pass' : url = '<?php echo URL('mgr/weibo/disableWeibo.verifyWeibo');?>';break;
			case 'del' : url = '<?php echo URL('mgr/weibo/disableWeibo.deleteVerifyWeibo');?>';break;
			case 'unshield' :  url = '<?php echo URL('mgr/weibo/disableWeibo.resume');?>';break;
			case 'disable_batch' :  url = '<?php echo URL('mgr/weibo/disableWeibo.disableBatch');?>';break;
		}
		if(ids.length != 0 )
			delConfirm( url + '&id=' + ids.join(','),'确认要执行该操作吗？'); 
		else 
			Xwb.ui.MsgBox.alert('提示','你没有选择任何项');
		return false;
	});
	function getSelectID(){
		var ids=[];
		$('#dataList input[name="id[]"]').each(function(){
			if(this.checked) ids.push(this.value);
		});
		return ids;
	}
	$('img.weibo-pic').hover(function(){
		var off = $(this).offset(),self = $(this);
		var p1 = $('#pic #p1')[0],p2=$('#pic #p2')[0];
		var clictHeight = document.documentElement.clientHeight || document.body.clientHeight;
		var load = function(){
			$(this).cssDisplay(1);
			$(p1).cssDisplay(0);
			$('#pic').cssDisplay(1);
			if(this.width + 13 > off.left ) $('#pic #p2').attr('width',off.left -13);
			//判断显示的大图片是向上停靠还是向下停靠
			var top = clictHeight > ( off.top - $(document).scrollTop() + this.height) ? off.top :off.top + (self.height() - $(this).height()) - 6;
			//判断是否居中对其
			top =top != off.top && top < $(document).scrollTop()   ? top + ($(this).outerHeight(true) - self.height())/2   : top;
			$('#pic').css({top:top,left:off.left - this.width - 13});
		};
		$('#pic img').cssDisplay(0);
		p2.onload = load;
		p2.src = this.src.replace('thumbnail','bmiddle');
		if(!p2.complete){
			//当大图片没有加载完的时候用小图片代替显示 大图片加载完成自动替换
			$(p1).attr({'src':this.src,width : this.width}).cssDisplay(1);
			$('#pic').cssDisplay(1);
			$('#pic').css({top:off.top,left:off.left - this.width - 13});
		} else {
			load.call(p2);
		}
	},function(){
		$('#pic').cssDisplay(0);
	});
});

$(function(){
	$('#dataList').click(function(e){

		var $target = $(e.target);
		if ($target.hasClass('icon-pass'))
		{
			if ($target.data('lock'))
			{
				e.preventDefault();
				return false;
			}

			$target.data('lock', 1);
		}
	});
});

//-->

</script>

</head>

<body class="main-body">
	<div id="pic" class="hidden" style="position:absolute;padding:5px;border:1px solid #aaa;"><img id="p1"/><img id="p2" /></div>
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>微博</p></div>

    <div class="main-cont">
    	<h3 class="title"><a class="btn-general" href="#" id="setting"><span>审核设置</span></a>微博列表</h3>
		<div class="set-area">
			<?php 
				$config 		= json_decode( V('-:sysConfig/xwb_strategy'), TRUE);
				$needStrategy 	= (isset($config['strategy']) && $config['strategy']);
				if (!$needStrategy) {
					echo '<p class="tips-desc">已启用先发布后审核，你可以在<a href="'.URL('mgr/weibo/disableComment.search').'">内容屏蔽</a>中对内容进行相关管理</p>';
				}
			?>
        	  
              <div class="search-area ">
				<form method="get" id="searchForm">
                    <input type="hidden" name="m" value="mgr/weibo/disableWeibo.verifyWeiboList" />
                    <input type="hidden" name="type" value="<?php echo $type;?>" />
					<p class="filter"><label>类&nbsp;&nbsp;&nbsp;&nbsp;型：</label>
                        <a href="<?php echo URL('mgr/weibo/disableWeibo.verifyWeiboList');?>" class="current">微博</a>|<a href="<?php echo URL('mgr/weibo/disableComment.comment');?>" >评论</a></p>
					<p class="filter"><label>状&nbsp;&nbsp;&nbsp;&nbsp;态：</label>
						<a href="<?php echo URL('mgr/weibo/disableWeibo.verifyWeiboList', array('type'=>0)); ?>" <?php if (!$type){echo 'class="current"';} ?>>未审核</a>|
						
						<?php if ( $needStrategy ) {?>
						<a href="<?php echo URL('mgr/weibo/disableWeibo.verifyWeiboList', array('type'=>1)); ?>" <?php if (1==$type){echo 'class="current"';} ?>>通过审核</a>|
						<a href="<?php echo URL('mgr/weibo/disableWeibo.verifyWeiboList', array('type'=>2)); ?>" <?php if (2==$type){echo 'class="current"';} ?>>被屏蔽</a>|
						<?php } ?>
						
						<a href="<?php echo URL('mgr/weibo/disableWeibo.verifyWeiboList', array('type'=>3)); ?>" <?php if (3==$type){echo 'class="current"';} ?>>被删除</a>
					</p>
            		<div class="item">
                    	<label for="disabled">时&nbsp;&nbsp;&nbsp;&nbsp;间：</label>
                        <input type="text" id="start"  name="start" value="<?php echo V('g:start', ''); ?>" class="ipt-txt w70 ">&nbsp;&nbsp;--&nbsp;&nbsp;
                        <input type="text" id="end" name="end" class="ipt-txt w70 " value="<?php echo V('g:end', ''); ?>">
                        <label>关键字：</label>
                        <input name="keyword" class="ipt-txt w120" type="text" value="<?php echo V('g:keyword', ''); ?>" />
                        <a class="btn-general" id="submitBtn" href="javascript:$('#searchForm').submit();"><span>搜索</span></a>
                    </div>
				</form>
			</div>

             <table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" id="dataList">
            		<colgroup>
						<col class="w50">
                        <col/>
    					<col class="w120">
    					<col class="w100">
    					<col class="w140">
                        <col class="w70">
						<col class="w150">
    				</colgroup>
                    <thead class="tb-tit-bg">
  						<tr>
    						<th><div class="th-gap"></div></th>
    						<th><div class="th-gap">微博内容</div></th>
    						<th><div class="th-gap">图片</div></th>
                            <th><div class="th-gap">作者</div></th>
                    		<th><div class="th-gap">发布时间</div></th>
							<th><div class="th-gap">状态</div></th>
    						<th><div class="th-gap">操作</div></th>
  						</tr>
                	</thead>
                	<tfoot class="td-foot-bg">
                    	<tr>
                    		<td colspan="7">
                                <div class="pre-next">
                                    <?php if (isset($list) && is_array($list) && !empty($list)): echo $pager; endif; ?>
                                </div>
								<?php if ( $type!=3 ) { ?><span class="check-all"><input class="ipt-checkbox" type="checkbox" value="" id="selectAll">全选</span><?php } ?>
                                <?php if ( 1==$type ) { ?><a class="btn-general highlight" href="" id="disable_batch"><span>屏蔽</span></a><?php } ?>
                                <?php if ( 2==$type ) { ?><a class="btn-general highlight" href="" id="unshield"><span>取消屏蔽</span></a><?php } ?>
                                <?php if (empty($type)) { ?>
                                    <a href="" class="btn-general highlight" id="Pass"><span>审核通过</span></a>
                                    <a href="" class="btn-general" id="del"><span>删除</span></a>
                                <?php } ?>
                            </td>
                   		</tr>
                    </tfoot>
                    <tbody>
                    <?php if (is_array($list) && !empty($list) ) { foreach ($list as $key=>$item){ ?>
  						<tr>
    						<td><?php if ( $type!=3 ) { ?><input name="id[]" type="checkbox" value="<?php echo $item['id']; ?>"><?php }else{echo $key+1;} ?></td>
							<td><?php echo F('escape', $item['weibo']); if (isset($item['retweeted_wid'])&&$item['retweeted_wid']){echo "&nbsp;<a target='_blank' href='".URL('show',array('id'=>$item['retweeted_wid']), 'index.php')."' >查看原微博</a>";} ?></td>
							<td><?php if (isset($item['picid']) && $item['picid']):?><img src="<?php echo F('profile_image_url.thumbnail_pic', $item['picid']); ?>" alt="" class="weibo-pic" /><?php elseif(isset($item['pic']) && $item['pic']):echo "<img src='{$item['pic']}' alt='' class='weibo-pic' />"; endif;?></td>
							<td><a href="<?php echo URL('ta', array('id'=>$item['sina_uid'], 'name'=>$item['nickname']), 'index.php');?>" target="_blank"><?php echo F('escape', $item['nickname']);?></a></td>
							<td><?php echo date('Y-m-d H:i:s', $item['dateline']);?></td>
							<td>
								<?php switch ($type){
                            		case 1: echo '已审核';break;
                            		case 2: echo '已屏蔽';break;
                            		case 3: echo '已删除';break;
                            		default: echo '未审核';
								}?>
							</td>
							<td>
    							<?php if ( 1==$type ) { ?><a class="icon-shield" href="javascript:confirmDisable('<?php echo URL('mgr/weibo/disableWeibo.disable', array('id'=>$item['id'], 'ajax'=>1), 'admin.php');?>',{'id':'<?php echo $item['id'];?>','text':'<?php echo $item['weibo']?>','user':'<?php echo $item['nickname'];?>','created_at':'<?php echo date('Y-m-d H:i:s', $item['dateline']);?>'})">屏蔽</a><?php } ?>
    							<?php if ( 2==$type ) { ?><a class="icon-unshield" href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableWeibo.resume', 'id=' . $item['id']);?>','确认要恢复该微博吗?')">取消屏蔽</a><?php } ?>
								<?php if (empty($type)) { ?>
								<a class="icon-pass" href="<?php echo URL('mgr/weibo/disableWeibo.verifyWeibo', array('id'=>$item['id'])); ?>">审核通过</a>
								<a class="icon-del" href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableWeibo.deleteVerifyWeibo', array('id'=>$item['id'])); ?>','确认要删除吗？')">删除</a>
								<?php } ?>
							</td>
                        </tr>
                    <?php } } else {echo '<tr><td colspan="7"><p class="no-data">搜索不到任何数据</p></td></tr>';} ?>
                        
                    </tbody>
                </table>
			
        </div>

    </div>

</body>

</html>
