<?php
	/**
	 * 随便看看模块模板
	 * 需要参数参见component_9_pls
	 * @version $Id$
	 */
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<div class="pub-feed-list">
    <div class="title-box">
        <div></div>
		<a class="more" href="<?php echo URL('pub.look');?>"><?php LO('modules_component_component_9_more');?>&gt;&gt;</a>
        <h3><?php /*随便看看*/ echo F('escape', $mod['title']);?></h3>
    </div>
    
	<div class="feed-list">
    <?php
		TPL::module('feedlist', array('list' => $list));
	?>
	</div>
</div>
