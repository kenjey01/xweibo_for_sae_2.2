<!--活动列表-->
<?php
///缺少样式
//var_dump($events);
?>
<div class="mod-aside recent-event">
    <div class="hd">
        <h3><?php echo isset($mod['newTitle'])?$mod['newTitle']:L('modules_component_component_18_eventTitle');?></h3>
    </div>
    <div class="bd">
        <ul>
			<?php
			if(empty($events)){
				echo L('modules_component_component_18_empty');
			}
			else
				foreach($events as $row):
				?>
				<li>
					<a class="tit-event" href="<?php echo URL('event.details','eid=' . $row['id']);?>"><?php echo F('escape', $row['title']);?></a>
					<p><?php LO('modules_component_component_18_eventTime');?></p>
					<p><?php echo F('format_time.foramt_show_time',$row['start_time']);?> -</p>
					<p><?php echo F('format_time.foramt_show_time',$row['end_time']);?></p>
				</li>
				<?php
				endforeach;
				?>
        </ul>
    </div>
</div>
