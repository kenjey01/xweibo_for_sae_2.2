<?php
	/**
	 * 推荐用户公用模板
	 * 需要传入$title， $categoty， $cid，$base_url，$users
	 * @author yaoying
	 * @version $Id: recommendUser.tpl.php 16719 2011-06-02 02:07:23Z weijiang $
	 */

	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
	
?>

<div class="fame-list">
    <div class="title-box">
    <h3><?php echo F('escape', $title);?></h3>
    </div>

    <div class="tab-s4">
    
		<?php if (is_array($category)) { $i=0;foreach($category as $key =>$item) {?>
			<a <?php if ($i==0) {?>class="current" name="starRecommend"<?php }?> href="javascript:;"><?php echo $item?></a>
		<?php 
			$i++;
			}
		} ?>
    
    </div>
	<?php $hidden = isset($hidden)?$hidden:false;?>
    <?php foreach ($users as $u) {?>
    <?php TPL::module('mod_fame_list', array('users' => $u, 'hidden' =>$hidden));?>
	<?php if ($hidden===false) {$hidden = true;}?>
    <?php }?>
</div>
