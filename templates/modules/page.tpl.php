<div class="list-footer">
    <div class="page">
		<?php
		 $limit = isset($limit) ? $limit : null;
		 $type = isset($type) ? $type : null;
		 if ($type) {
			 echo DS('common/pager.getPageHtml', '', $list, $limit, $count);
		 } else {
			 if (isset($extends)) {
				 DS('common/pager.setVarExtends', '', $extends);
			 }
			 echo DS('common/pager.getPageList', '', $list, $limit);
		 }
		?>
    </div>
</div>
