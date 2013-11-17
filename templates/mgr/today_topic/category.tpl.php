<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>话题推荐管理 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<script>
function openPop(url,title) {

	Xwb.use('MgrDlg',{
		modeUrl:url,
		formMode:true,
		valcfg:{
			form:'AUTO',
			trigger:'#pop_ok'
		},
		dlgcfg:{
			cs:'win-topic win-fixed',
			onViewReady:function(View){
				var self=this;
				$(View).find('#pop_cancel').click(function(){
					self.close();
				})
			},
			title:title,
			destroyOnClose:true
		}
	})
};
</script>
<body class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>话题</p></div>
    <div class="main-cont">
    	<h3 class="title"><a class="btn-general" href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.addCategory');?>','添加话题列表');"><span>添加话题列表</span></a>话题列表</h3>
		<div class="set-area">
            <table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
                <colgroup>
                    <col class="w70"/>
                    <col />
                    <col class="w150" />
                    <col class="w160" />
                </colgroup>
                <thead class="tb-tit-bg">
                <tr>
                    <th><div class="th-gap">编号</div></th>
                    <th><div class="th-gap">名称</div></th>
                    <th><div class="th-gap">类型</div></th>
                    <!--<td>组件应用情况</td>-->
                    <th><div class="th-gap">操作</div></th>
                </tr>
                </thead>
                <tfoot class="tb-tit-bg"></tfoot>
                <tbody>
                <?php if (!empty($data) && is_array($data)) foreach($data as $key => $item) {?>
                <tr>
                    <td><?php echo ++$key;?></td>
                    <td><?php echo htmlspecialchars($item['topic_name']);?></td>
                    <td><?php echo $item['native'] == 1 ? '内置':'自定义';?></td>
                    <!--<td><?php echo implode(',', $item['apps']);?></td>-->
                    <td>
                    
                        <a class="icon-topic" href="<?php echo URL('mgr/weibo/todayTopic.topicList','category=' . $item['topic_id'], 'admin.php');?>">查看话题</a>
<!--
                        <a class="change-icon" href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.addCategory','id=' . $item['topic_id'], 'admin.php');?>','编辑话题列表');">编辑</a>
-->
                        <?php if ($item['native'] != 1) {?>
                        <a class="icon-del" href="<?php echo URL('mgr/weibo/todayTopic.delCategory', 'id=' . $item['topic_id'], 'admin.php');?>">删除</a>
                        <?php }?>
                        
                    </td>
                </tr>
                <?php } else {?>
                <tr><td colspan="5"><p class="no-data">尚没有数据</p></td></tr>
                <?php }?>
                </tbody>
            </table>
        </div>   
    </div>
<div id="pop_window" class="win-pop win-fixed win-topic hidden"></div>
<div id="pop_mask" class="mask hidden"></div>
</body>
</html>
