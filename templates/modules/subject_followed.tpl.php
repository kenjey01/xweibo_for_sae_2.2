<?php
?>
<div class="mod-aside att-topic">
	<div class="hd"><h3><?php LO('modules__subjectFollowed__followedTopic');?><span>(<?php echo count($list['rst']);?>)</span></h3></div>
    <div class="bd" id="subjectCount">
			<?php
			if(count($list['rst'])==0&&V('g:m')=='ta'):
			?>
			<?php LO('modules__subjectFollowed__emptyFollowedTopic');?>	
			<?php
			endif;
			?>        
		<ul>
			
			<?php
			foreach($list['rst'] as $row):
			?>
			<li rel="subject:<?php echo F('escape', $row['subject']); ?>"><a href="<?php echo URL('search.weibo','k='. urlencode($row['subject']))?>"><?php echo F('escape', $row['subject']);?></a>
			<?php
			if(V('g:m')!='ta'):
			?>
			<span class="close" rel="e:deleteSubject" title="<?php LO('modules__subjectFollowed__delete');?>">x</span>
			<?php
			endif;
			?>
			</li>
			<?php
			endforeach;
			?>
            
        </ul>
		<?php
		if(V('g:m')!='ta'):
		?>
		<div class="add-topic-btn"><a href="javascript:;" id="addSubject"><?php LO('modules__subjectFollowed__add');?></a></div>
		<?php
		endif;
		?>
    </div>
</div>
