<div class="row">
	<form method="get" action="<?php echo WAP_URL('search');?>">
        <input type="hidden" name='<?php echo WAP_SESSION_NAME;?>' value='<?php echo V('r:'.WAP_SESSION_NAME) ?>'/>
		<span><?php LO('include__search__searchType');?></span>&nbsp;<input type="text" name="k" size="15" />&nbsp;
		<input type="hidden" name="m" value="search"/>
		<input type="submit" value=" <?php LO('include__search__btnSearch');?> " />
	</form>
</div>