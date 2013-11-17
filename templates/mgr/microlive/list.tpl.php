<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线直播列表 - 组件扩展</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body class="main-body">
    <div class="path"><p>当前位置：扩展工具<span>&gt;</span>在线直播列表</p></div>
    <div class="main-cont">
        <h3 class="title"><a href="<?php echo URL('mgr/wb_live.create');?>" class="btn-general"><span>新建在线直播</span></a><a href="<?php echo URL('mgr/wb_live.set');?>" class="btn-general"><span>编辑在线直播基本信息</span></a>在线直播列表</h3>
        <div class="set-area">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                <colgroup>
                    <col class="w60"/>
                    <col/>
                    <col class="w140"/>
                    <col class="w140" />
                    <col class="w70" />
                    <col class="w180"/>
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">标题</div></th>
                        <th><div class="th-gap">开始时间</div></th>
                        <th><div class="th-gap">结束时间</div></th>
                        <th><div class="th-gap">状态</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg">
                    <tr>
                        <td colspan="6">
                        <div class="td-inside">
						<div class="pre-next"><?php if (!empty($list) && is_array($list)):?><?php echo $pager;?><?php endif;?></div>
                        </div>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
					<?php if (!empty($list) && is_array($list)):?>
                	<?php foreach ($list as $key=>$aRecord) {?>
                    <tr>
    					<td><?php echo $offsetCnt+$key; ?></td>
    					<td><a href="<?php echo URL('mgr/wb_live.modify', array('id'=>$aRecord['id'], 'page'=>$currentPage));?>" ><?php echo $aRecord['title']; ?></a></td>
                        <td><?php echo date('Y-m-d H:i:s', $aRecord['start_time']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $aRecord['end_time']); ?></td>
                        <td><?php 
                        	if ($aRecord['status']=='P'){echo '<span class="no-start">未开始</span>';} 
                        	elseif ($aRecord['status']=='E'){echo '<span class="finish">已结束</span>';} 
                        	else {echo '<span class="going">进行中</span>';}
                        ?></td>
    					<td><a href="<?php echo URL('mgr/wb_live.modify', array('id'=>$aRecord['id'], 'page'=>$currentPage));?>" class="icon-edit">编辑</a>
    						<a href="<?php echo URL('mgr/wb_live.approveWbList', array('id'=>$aRecord['id']) ); ?>" class="icon-approve">审批</a>
    						<a href="javascript:delConfirm('<?php echo URL('mgr/wb_live.delLive', array('id'=>$aRecord['id'], 'page'=>$currentPage) ); ?>');" class="icon-del">删除</a>
    					</td>
  					</tr>
  					<?php } ?>
					<?php else:?>
					<tr><td colspan="6"><p class="no-data">还没有任何在线直播</p></td></tr>
					<?php endif;?>
                </tbody>
			</table>
    	</div>
    </div>
</body>
</html>
