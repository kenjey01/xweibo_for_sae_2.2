<div class="title-box">
	<h3><?php LO('modules_interview_askweibo_nopage_counts', $wbList['askCnt']); ?></h3>
</div>

<div class="feed-list ask-list">
	<!-- 提问微博列表  开始-->
	<?php if( $wbList['askCnt']<=0 ){ ?>
		<div class="default-tips" id="emptyTip">
			<div class="icon-tips"></div>
			<p><?php LO('modules_interview_askweibo_nopage_weiboEmpty');?></p>
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
</div>
