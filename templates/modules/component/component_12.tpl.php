<?php
	/**
	 * 话题微博模块模板
	 * 需要参数参见component_12_pls
	 * @version $Id$
	 */
?>

<div class="pub-feed-list">
    <div class="title-box">
        <h3><?php echo F('escape', $mod['title']). ' - ' .$rs['topic'];?></h3>
    </div>
	<div class="feed-list">
		<?php TPL::module('feedlist', array('list' => $rs['rst'])); ?>
	</div>
	<?php if (USER::isUserLogin() /*&& $source */&& $mod['param']['page_type']):?>
		<?php TPL::module('page', array('list' => $rs['rst'], 'limit' => $mod['param']['show_num']));?>
	<?php endif;?>
</div>