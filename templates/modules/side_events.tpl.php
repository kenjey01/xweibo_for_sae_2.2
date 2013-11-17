    <div class="bd">
        <ul>
			<?php if (is_array($events)) {foreach($events as $event) {?>
            <li>
                <a class="tit-event" href="<?php echo URL('event.details','eid=' . $event['id']);?>"><?php echo htmlspecialchars($event['title']);?></a>
                <p><?php LO('modules__sideEvents__time');?></p>
                <p><?php echo F('format_time.foramt_show_time',$event['start_time']);?></p>
                <p><?php echo F('format_time.foramt_show_time',$event['end_time']);?></p>
            </li>
            <?php }}?>
        </ul>
    </div>
