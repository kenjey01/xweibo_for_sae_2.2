<div class="user-list">
	<?php if (empty($list['users'])):?>
	<!-- ta tip -->
	<div class="default-tips">
	<div class="icon-tips"></div>
	<?php if (V('g:page', 1) > 1):?>
	<p><?php LO('modules__blockUserList__pageTip');?></p>
	<?php else:?>
	<p><?php echo $empty_text;?></p>
	<?php endif;?>
	</div>
	<!-- end tip -->
	<?php else:?>
		<?php TPL::module('userlist', array('list' => $list, 'userinfo'=>$userinfo, 'fids'=>$fids));?>
		<?php TPL::module('page', array('list' => $list, 'limit' => $limit));?>
	<?php endif;?>
</div>
