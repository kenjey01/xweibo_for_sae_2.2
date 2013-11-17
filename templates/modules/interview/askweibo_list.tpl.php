<div class="feed-list">
	<!--feed标题，信息过滤-->
	<div class="title-box">
		<div class="feed-refresh hidden">
			<a href="#"><?php LO('modules_interview_askweibo_list_hasNew');?></a>
    	</div>
		<h3><?php LO('modules_interview_askweibo_list_fansAsk');?></h3>
	</div>
                            
	<!-- 提问微博列表  开始-->
	<?php if( $wbList['askCnt']<=0 ){ ?>
		<div class="default-tips" id="emptyTip">
			<div class="icon-tips"></div>
			<p><?php LO('modules_interview_askweibo_list_weiboEmpty');?></p>
		</div>
		<ul id="xwb_weibo_list_ct"></ul>
	<?php } else { ?>

	<ul id="xwb_weibo_list_ct">
	<?php
		foreach ($wbList['askList'] as $aWbTmp)
		{
			if ( isset($aWbTmp['askWb']['id']) ) 
			{
				$wb			= $aWbTmp['askWb'];
				$wb['uid'] 	= 'false';	// 设置为特殊字符，目的不显示删除链接
				
				echo '<li rel="w:'.$wb['id'].'">';
					TPL::module('feed', $wb);
				echo '</li>';
			}
		}
	}
	?>
	</ul>
	<!-- 提问微博列表  结束-->

	<!-- 分页 开始-->
	<?php TPL::module('page', array('list'=>$wbList['askList'], 'count'=>$wbList['askCnt'], 'limit'=>$limit, 'type'=>'event'));?>
	<!-- 分页 结束-->
</div>
