<?php
	/**
	 * 当前站点最新微博模块
	 * 需要参数参见component_14_pls
	 * @version $Id: component_14.tpl.php 17248 2011-06-16 06:28:11Z heli $
	 */
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<?php if (isset($mod['loginPage'])):?>
<!-- start 登录页面 的本地微博 -->
<?php if (is_array($list) && $list):?>
<div class="list-bd">
	<ul class="feed-list">
		<?php foreach ($list as $item):?>
		<li>
		<div class="user-pic"><a href="<?php echo URL('ta', array('id' => (string)$item['user']['id'], 'name' => $item['user']['screen_name']));?>"><img src="<?php echo $item['user']['profile_image_url'];?>" alt="" /></a></div>
			<div class="feed-content">
			<p class="feed-main"><a href="<?php echo URL('ta', array('id' => (string)$item['user']['id'], 'name' => $item['user']['screen_name']));?>"><?php echo F('escape', $item['user']['screen_name']);?><?php echo F('verified', $item['user']);?></a>：<?php echo F('format_text', $item['text']);?></p>
			<p class="feed-info"><?php echo F('format_time', $item['created_at']);?></p>
			</div>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<?php else:?>
<div class="default-tips">
	<div class="icon-tips"></div>
	<p><?php LO('pls__component14__login__emptyTip');?></p>
</div>
<?php endif;?>
<!-- end 登录页面 的本地微博 -->
<?php else:?>
<div class="pub-feed-list">
    <div class="title-box">
        <div></div>
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
    
	<div class="feed-list">
    <?php
		TPL::module('feedlist', array('list' => $list));
	?>
	</div>
</div>
<?php endif;?>
