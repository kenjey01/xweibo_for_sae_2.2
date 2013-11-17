<?php if ( is_array($interviewList) ) { ?>
<div class="program-list">
	<div class="tit-hd">
		<a href="<?php echo URL('interview.page'); ?>" class="more"><?php LO('modules_interview_program_list_more');?>&gt;&gt;</a>
		<h3><?php LO('modules_interview_program_list_interviewList');?></h3>
	</div>
	
	<div class="bd">
		<ul>
			<?php foreach ($interviewList as $aInterview) { ?>
			<li>
				<p><a href="<?php echo URL('interview', array('id'=>$aInterview['id']) ); ?>" target="_blank"><?php echo $aInterview['title']; ?></a>
					<?php if ($aInterview['status']=='P'){echo L('modules_interview_program_list_ready'); } elseif ($aInterview['status']=='E'){ echo L('modules_interview_program_list_closed'); } else {echo L('modules_interview_program_list_running');}?>
				</p>
              	<p><span class="label"><?php LO('modules_interview_program_list_members');?></span>
              		<?php 
              			if ( is_array($aInterview['master']) ) 
              			{
              				foreach ($aInterview['master'] as $aMaster)
              				{
              		?>
              		<span class="emcee"><?php echo $aMaster['screen_name']; ?></span>
              		<?php } } ?>
              	</p>
              	<p><span class="label"><?php LO('modules_interview_program_list_timeField');?></span><span class="time"><?php echo date(L('modules_interview_program_list_time'), $aInterview['start_time'])?></span></p>
        	</li>
        	 <?php } ?>
      	</ul>
 	</div>
</div>
 <?php } ?>
