<?php
if ((isset($list['x_total']) && !empty($list['x_total'])) || !empty($list)):
$gData = V('g', array());
if(!isset($query)){
	$query = array();		
}
foreach ($gData as $k => $v) {
	if ($k === R_GET_VAR_NAME || $k == 'page') { continue; }
	$query[$k] = $v;
}

if ($page > 1) {
	$query['page'] = $page - 1;
	
	if (isset($list['previous_cursor'])) {
		$query['cursor'] = $list['previous_cursor'] - $limit == 0 ? -1 : $list['previous_cursor'] - $limit;
	}
	
	$pre_link = WAP_URL($ctrl, $query);
	
	unset($query['page']);
	$first_link = WAP_URL($ctrl, $query);
}

if (!isset($list['x_total']) || ceil($list['x_total'] / $limit) > $page) {
	$query['page'] = $page + 1;
	if (isset($list['next_cursor'])) {
		$query['cursor'] = $list['next_cursor'];
	}
	$next_link = WAP_URL($ctrl, $query);
}
?>
<div class="pages">
	<form>
		<?php if (isset($first_link)): ?><a href="<?php echo $first_link; ?>"><?php LO('include__pager__first');?></a>&nbsp;<?php endif; ?><?php if (isset($pre_link)): ?><a href="<?php echo $pre_link; ?>"><?php LO('include__pager__prev');?></a>&nbsp;<?php endif; ?><?php if (isset($next_link)): ?><a href="<?php echo $next_link; ?>"><?php LO('include__pager__next');?></a><?php endif; ?>
	</form>
</div>
<?php endif; ?>