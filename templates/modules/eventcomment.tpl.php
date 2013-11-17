<div class="add-comment add-comment-dash">
<p class="title title-small"><?php LO('modules__eventComment__topic', URL('search.weibo', array('k' => $info['title'])), F('escape', $info['title']));?></p>
	<div class="post-comment-main">
		<div class="icon-face-choose" rel='e:ic'></div>
		<div class="comment-r">
		<textarea class="comment-textarea style-normal" id="inputor">#<?php echo F('escape', $info['title']);?>#</textarea>
			<div>
				<a class="btn-s1" href="javascript:;" rel="e:sd,eid:<?php echo  $info['id'] ;?>,a:event"><span><?php LO('modules__eventComment__publish');?></span></a>
				<span id="warn" class="keyin-tips"><?php LO('modules__eventComment__length');?></span>
			</div>
		</div>

	</div>
</div>
