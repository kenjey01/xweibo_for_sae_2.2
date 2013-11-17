<?php
	/**
	 * 推荐用户公用模板之：人物排列
	 * 需要传入$users
	 * @author yaoying
	 * @version $Id: mod_fame_list.tpl.php 16368 2011-05-26 09:19:45Z heli $
	 */

	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
	
?>

<div class="column-body<?php if (isset($hidden) && $hidden) {?> hidden<?php }?>">
    
<?php 
	if (isset($users) && is_array($users) && !empty($users)) { 
		$uid = USER::uid();
		foreach ($users as $row) {
?>
    <div class="column-item" rel="u:<?php echo $row['id'];?>">
        <div class="item-pic">
			<a href="<?php echo URL('ta', 'id=' . $row['id'] . '&name='. urlencode($row['screen_name']));?>" class="user-pic" title="<?php echo htmlspecialchars($row['screen_name']);?>"><img src="<?php echo $row['profile_image_url']?>" alt="<?php LO('modules__modFameList__profileImageUrl', F('escape', $row['screen_name']));?>" /></a>
			<?php if ($row['id'] != $uid) {?>
			<?php if ($row['following']) {?>
			<span class="followed-btn"><?php LO('common__template__followed');?></span>
			<?php } else {?>
			<a class="addfollow-btn"  rel="e:fl,t:1" href="#"><?php LO('common__template__toFollow');?></a></li>
			<?php }?>
			<?php }?>
        </div>
            
		<a href="<?php echo URL('ta', 'id=' . $row['id'] . '&name=' . urlencode($row['screen_name']));?>" class="nick" title="<?php echo htmlspecialchars($row['screen_name']);?>">
		<?php echo htmlspecialchars($row['screen_name']);?>
		<?php echo F('verified', $row);?>
		</a>
        
        <span class="info" title="<?php echo htmlspecialchars($row['description']);?>"><?php echo htmlspecialchars($row['description']);?></span>  
        
   </div>

<?php }}else{?>
    <div class="column-item">
	<span class="info"><?php LO('modules__modFameList__emptyTip');?></span>
	</div>
<?php }?>
</div>
