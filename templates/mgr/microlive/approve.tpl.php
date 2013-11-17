<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线直播列表 - 组件扩展</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#dataList').click(function(e){

		var $target = $(e.target);
		if ($target.hasClass('icon-approve'))
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
</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：扩展工具<span>&gt;</span><a href="<?php echo URL('mgr/wb_live');?>">在线直播列表</a><span>&gt;</span>在线直播审批</p></div>
    <div class="main-cont">
        <h3 class="title">在线直播审批</h3>
		<div class="set-area">
        	<p class="approve-tips">
        		<span class="check"><input id="wbState" onchange="setWbState();" type="checkbox" <?php if ('P'==$live['wb_state']){echo 'checked="checked"'; } ?>  />审批后才能发布</span>
        		还有<span class="num"><?php echo $totalCnt;?></span>条微博没有审批
        		<a href="javascript:void(0);" onclick="location.reload();" class="btn-general"><span>刷新</span></a></p>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" id="dataList">
            	<colgroup>
					<col class="w70"/>
                    <col/>
    				<col class="w170" />
    			</colgroup>
                <thead class="tb-tit-bg">
  					<tr>
    					<th><div class="th-gap">序列</div></th>
    					<th><div class="th-gap">微博</div></th>
    					<th><div class="th-gap">操作</div></th>
  					</tr>
                </thead>
                <tfoot></tfoot>
                <tbody>
                	<?php $cnt=0; foreach ($list as $key=>$aRecord) {?>
                    <tr>
    					<td><?php echo ++$cnt; ?></td>
    					<td><?php echo $aRecord['text'].$aRecord['pic']; ?></td>
							<td><a href="<?php echo URL('mgr/wb_live.approveWb', array('id'=> $id, 'wb_id'=>$key, 'v' => isset($aRecord['v']) ? $aRecord['v'] : '', 'vid' => isset($aRecord['v']) ? $aRecord['id'] : '') )?>" class="icon-approve">审批</a>
    						<a href="<?php echo URL('mgr/wb_live.delWb', array('id'=> $id, 'wb_id'=>$key, 'v' => isset($aRecord['v']) ? $aRecord['v'] : '', 'vid' => isset($aRecord['v']) ? $aRecord['id'] : '') )?>" class="icon-del">删除</a>
    					</td>
  					</tr>
  					<?php } ?>
                </tbody>
			</table>
    	</div>
    </div>
    <script type="text/javascript">
    	function setWbState()
    	{
        	var state = $('#wbState').attr('checked') ? 'P' : 'A';
        	jQuery.post('<?php echo URL("mgr/wb_live.setWbState");?>', '<?php echo "id=$id&state="; ?>'+state);
    	}

        var counter = $('.approve-tips .num');
    	function getWbCnt(){
        	jQuery.getJSON('<?php echo URL("mgr/wb_live.countWb", array('id'=>$id) );?>', function(data){
        		if( data.errno == 0 )
        	    	counter.text(data.rst); 
        	    else {
        	    	//返回错误！
        	    }
        	});
        	setTimeout(getWbCnt, 20000);
    	}
    	
    	setTimeout(getWbCnt, 20000);
    </script>
</body>
</html>
