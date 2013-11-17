<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论屏蔽 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/mgr.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
function confirmDisable(url, data) {

	Xwb.ui.MsgBox.confirm('提示','确认要屏蔽该评论吗?',function(id){ 
		if(id == "ok"){
			$.post(url, data,function(data) {
						try {
							if (data.rst) {
								window.location.reload();
							} else {
								alert(data.err);
							}
						} catch (e) {
						
						}
					});
		}
	});

}
</script>
</head>
<body  class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>指定微博搜索</p></div>
    <div  class="main-cont">
    	<div class="tab-box">
            <h5 class="tab-nav tab-nav-s1 clear">
                <a href="<?php echo URL('mgr/weibo/weiboCopy.weiboList');?>"><span>本站微博</span></a>
                <a class="current" href="<?php echo URL('mgr/weibo/disableComment.search');?>"><span>指定微博搜索</span></a>
                <a href="<?php echo URL('mgr/weibo/disableWeibo.weiboList');?>"><span>已屏蔽微博</span></a>
                <a href="<?php echo URL('mgr/weibo/disableComment.commentList');?>"><span>已屏蔽评论</span></a>
            </h5>
            <div class="tab-con-s1">
                <div class="set-area">
                     <p class="tips-desc">通过微博地址,找到该条微博，你就可以对该微博和评论进行操作了。</p>
                    <div class="search-area">
                        <form method="get"  id="postForm">
                          <div class="form-s2">
                            <div class="item">
                                <input name="url" class="input-txt" type="text" value="<?php echo V('r:url');?>" />
                                <a class="btn-general" href="#this" onclick="$('#postForm')[0].submit();"><span>搜索</span></a>
                                <input type="hidden" name="<?php echo R_GET_VAR_NAME;?>" value="mgr/weibo/disableComment.search">
                            </div>
                            </div>
                        </form>
                    </div>
                    <?php if (V('r:url', false) !== false) {?>
                    <?php $d = F('get_filter_cache', 'weibo');?>
                    <table class="table" cellpadding="0" cellspacing="0" border="0" width="100%">
                    <colgroup>
                            <col />
                            <col class="w150"/>
                            <col class="w150" />
                            <col class="w150" />
                        </colgroup>
                        <thead class="tb-tit-bg">
                        <tr>
                            <th><div class="th-gap">微博内容</div></th>
                            <th><div class="th-gap">作者</div></th>
                            <th><div class="th-gap">发布时间</div></th>
                            <th><div class="th-gap">操作</div></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($weibo) && !empty($weibo)) {?>
                            <tr <?php if (isset($d[(string)$weibo['id']])) {?>class="pink-row"<?php }?>>
                                <td><?php echo htmlspecialchars($weibo['text']);?></td>
                                <td><?php echo htmlspecialchars($weibo['user']['name']);?></td>
                                <td><?php echo  date('Y-m-d H:i:s', strtotime($weibo['created_at']));?></td>
                                <td>
                                <?php if (isset($d[(string)$weibo['id']])) {?>
                                    <a class="icon-unshield" href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableWeibo.resume', 'id=' . $weibo['id'] . '&type=1', 'admin.php');?>','确认要恢复该微博吗');">恢复</a>
                                        <?php } else {?>
                                            <a class="icon-shield" href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableWeibo.disable', 'id=' . $weibo['id'], 'admin.php');?>','确认要屏蔽该微博吗?')">屏蔽</a>
                                        <?php }?>
                                </td>
                            </tr>
                            <?php } else {?>
                                <tr><td colspan="4"><p class="no-data">没有找到相关的微博</p></td></tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <br/>
                    <table class="table" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <colgroup>
                            <col />
                            <col class="w150"/>
                            <col class="w150" />
                            <col class="w150" />
                        </colgroup>
                        <thead class="tb-tit-bg">
                        <tr>
                            <th><div class="th-gap">评论内容</div></th>
                            <th><div class="th-gap">作者</div></th>
                            <th><div class="th-gap">发布时间</div></th>
                            <th><div class="th-gap">操作</div></th>
                        </tr>
                        </thead>
                        <tfoot class="tb-tit-bg">
                        <tr>
                            <td colspan="4">
                            <div class="pre-next">
                            <?php if (isset($pager)) {echo $pager;}?>
                            <!--
                                <form name="form" id="form"><div >
                                    <a class="pre" href="">上一页</a><a class="next" href="">下一页</a></div>
                                    <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
                                        <option>1/2</option>
                                        <option>2/2</option>
                                    </select>
                                </form>
                            -->
                            </div>
                            
                            </td>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php $d = F('get_filter_cache', 'comment'); ?>
                        <?php if (isset($info) && is_array($info) && !empty($info)) {foreach ($info as $row) {?>
                        <tr <?php if (isset($d[(string)$row['id']])) { ?>class="pink-row"<?php }?>>
                            <td><?php echo htmlspecialchars($row['text']);?></td>
                            <td><?php echo htmlspecialchars($row['user']['screen_name']);?></td>
                            <td><?php echo  date('Y-m-d H:i:s', strtotime($row['created_at']));?></td>
                            <td class="opration">
                        
                            <?php if (isset($d[(string)$row['id']])) {?>
        <a class="icon-unshield" href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableComment.resume', 'id=' . $row['id'] . '&type=2', 'admin.php');?>','确认要恢复该评论吗?')">恢复</a>
                            <?php } else {?>
                                <a class="icon-shield" href="javascript:confirmDisable('<?php echo URL('mgr/weibo/disableComment.disable', 'id=' . $row['id'], 'admin.php');?>',{'id':'<?php echo $row['id'];?>','text':'<?php echo $row['text']?>','user':'<?php echo $row['user']['screen_name'];?>','created_at':'<?php echo date('Y-m-d H:i:s', strtotime($row['created_at']));?>'})">屏蔽</a>
                            <?php }?>
                            
                            </td>
                        </tr>
                        <?php }} else {?>
                            <?php if (V('r:url','') !== '') {?>
                        <tr><td colspan="4"><p class="no-data">该微博没有相关评论</p></td></tr>
                            <?php } else {?>
                        <tr><td colspan="4"><p class="no-data">尚没有添加任何关键字</p></td></tr>
                            <?php }?>
                        <?php }?>
                        </tbody>
                    </table>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
