<?php
	/**
	 * 热门转发和热门评论模块
	 * 需要参数参见component_1_pls
	 * @version $Id$
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
?>

<div class="hot-mblog">
    <div class="tab-s2">
        <span class="current"><span><a href="javascript:;"><?php LO('modules_component_component_1_hotForward');?></a></span></span>
        <span><span><a href="javascript:;"><?php LO('modules_component_component_1_hotComment');?></a></span></span>
    </div>
<?php
?>
    <div class="hot-mblog-body feed-list">
		<?php
			$mod['header'] = 2;
			Xpipe::pagelet('component/component_common.hotWB_getRepost', $mod); 
		?>
    </div>
	
	<div class="hot-mblog-body feed-list hidden">
		<?php
			$mod['header'] = 3;
			Xpipe::pagelet('component/component_common.hotWB_getComment', $mod); 
		?>
	</div>
</div>
