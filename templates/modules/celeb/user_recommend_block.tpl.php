<?php
/*
名人组块（目前用于名人堂）
$Id: user_recommend_block.tpl.php 16654 2011-05-31 09:44:16Z linyi1 $
必须：
    $id（名人组id） 
    $name（名人组名称）
    $data（名人数据数组）
非必须：
    $parent_name（名人组的上级名称）
    $show_more_link（是否显示“更多”的链接）
    $block_id（手动指定的本块id，默认以$id指定）
*/
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
$show_more_link = isset($show_more_link) ? (bool)$show_more_link : true;
$block_id = isset($block_id) ? $block_id : $id;
?>
<div class="recom-box" id="celeb_block_<?php echo $block_id;?>">
    <div class="t"><div></div></div>
    <div class="recom-box-c">
        <div class="hd">
        	<a name="<?php echo $block_id; ?>"></a>
        	<?php if($show_more_link): ?>
            <span><a href="<?php echo URL('celeb.starChildSortList', 'id='. $id);?>"><?php LO('modules_user_recommend_block_more');?>&gt;&gt;</a></span>
            <?php endif; ?>
            <?php if (isset($parent_name)): ?>
                <h3><?php echo strip_tags($parent_name);?><em class="gt">&gt;</em><a href="<?php echo URL('celeb.starChildSortList', 'id='. $id);?>"><?php echo strip_tags($name);?></a></h3>
            <?php else: ?>
                <h3><?php echo strip_tags($name);?></h3>
            <?php endif; ?>
        </div>
        <div class="bd" id="MultiCheckBox_<?php echo $block_id;?>">
           <ul class="interest-list">
           <?php foreach($data as $value):?>
		   <?php if(!F('user_action_check',array(3),$value['sina_uid'])) :?>
           <li rel="u:<?php echo $value['sina_uid'];?>">
               <div class="user-pic" id="pic">
                   <a href="<?php echo URL('ta', 'id='.$value['sina_uid']);?>" rel="e:ck" title="<?php echo F('escape', $value['nick']);?>">
                       <img src="<?php echo APP::F('profile_image_url', $value['face']);?>" alt="" />
                       <span class="checkbimg"></span>
                   </a>
               </div>
               <p>
                   <a href="<?php echo URL('ta', 'id='.$value['sina_uid']);?>" title="<?php echo F('escape', $value['nick']);?>"><?php echo F('escape', $value['nick']);?>
                       <!--<?php echo F('verified', $value);?>-->
                   </a>
               </p>
           </li>
		   <?php endif;?>
           <?php endforeach;?>
           
           </ul>
        </div>
        
        <div class="oper-area"><label for="selectAll_<?php echo $block_id;?>"><input type="checkbox" id="selectAll_<?php echo $block_id;?>" rel="e:sa" /><?php LO('modules_user_recommend_block_selectAll');?></label><a href="#" rel="e:submit" class="btn-s2"><span><?php LO('modules_user_recommend_block_followMore');?></span></a></div>
    </div>
    <div class="b"><div></div></div>
</div>

