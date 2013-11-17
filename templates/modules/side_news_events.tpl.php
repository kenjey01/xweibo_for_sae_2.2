<div class="mod-aside recent-event">
    <div class="hd">
	<a href="<?php echo URL('event.eventlist');?>"><?php LO('modules__sideNewsEvents__moreTip');?>&gt;&gt;</a>
	<h3><?php LO('modules__sideNewsEvents__newsEvent');?></h3>
    </div>
	<?php TPL::module('side_events', array('events' => $events));?>
</div>
