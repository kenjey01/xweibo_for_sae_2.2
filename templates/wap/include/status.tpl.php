	<div>
		<div><span><?php LO('include__status__tips');?></span></div>
		<form method="post" action="<?php echo WAP_URL('wbcom.postWB'); ?>">
			<div>
                            <?php
                            //var_dump($content);
                            ?>
				<textarea rows="2" name="content"><?php LO('include__status__talk', $content);?></textarea>
			</div>
			<div>
				<input type="submit" value=" <?php LO('include__status__btnPublish');?> " />
			</div>
		</form>
	</div>