<div class="mod-find">
	<div class="find-area">
		<form method="post" id="searchForm" action="<?php echo URL('search.user');?>">
			<div class="find-block">
				<input type="text" class="input-txt" name="k" value="" id="k" />
				<a id="searchBtn" class="s-btn skin-btn"><?php LO('modules__modFind__findPeople');?></a>
			</div>
			<div class="find-field">
			<label for="allsite"><input type="radio" id="allsite" name="base_app" value="0" <?php if (V('r:base_app') == '0' || !V('r:base_app', false)) {?>checked="checked"<?php }?> /><?php LO('modules__modFind__source');?></label>
				<label for="site"><input type="radio" id="site" name="base_app" value="1" <?php if (V('r:base_app') == '1') {?>checked="checked"<?php }?> /><?php LO('modules__modFind__onlyLocal');?></label>
			</div>
			<div class="find-tips hidden" id="searchTip">
			<span><?php LO('modules__modFind__inputSearch');?></span>
			</div>
		</form>
	</div>
</div>
