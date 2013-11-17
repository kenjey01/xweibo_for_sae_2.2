<?php
//分类目录 （目前用于名人堂）
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<div class="classify-list">
<ul>
    <?php if (isset($sort_list) && is_array($sort_list) && !empty($sort_list)) {foreach($sort_list as $key=>$rs):?>
    <li>
        <div class="main-tag skin-bg"><a href="<?php echo URL('celeb.starSortList', 'id='.$key);?>" title="<?php echo F('escape',strip_tags($rs['name']));?>"><?php echo strip_tags($rs['name']);?></a></div>
        <p class="taglinks">
            <?php foreach($rs['data'] as $value):?>
                <?php if(!isset($value['status']) || !$value['status']){continue;} ?>
                <a href="<?php echo URL('celeb.starChildSortList', 'id='.$value['id']);?>"  style="<?php if(isset($value['color'])) echo 'color:'.$value['color'];?>"><?php echo strip_tags($value['name']);?></a>
            <?php endforeach;?>
        </p>
    </li>
    <?php endforeach;} else {?>
		<?php if (USER::aid()) {?>
			<?php LO('modules_celeb_classify_list_adminEmptyTip', URL('mgr/admin.index','#4,4', 'admin.php'));?>
		<?php } else {?>
			<?php LO('modules_celeb_classify_list_emptyTip');?>
		<?php }?>
	<?php }?>
</ul>
</div>
