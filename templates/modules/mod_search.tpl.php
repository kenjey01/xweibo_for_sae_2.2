<?php
$router_str = APP::getRuningRoute(false);
if ($router_str == 'search.recommend') {
	$router_str = 'search.user';
}
?>
<div class="mod-search">
	<div class="search-area">
		<form method="get" id="searchForm" action="">
		<div class="tab-s1">
		<span <?php if ($router_str != 'search.weibo' && $router_str != 'search.user' && $router_str != 'search.recommend'):?>class="current"<?php endif;?>><span><a href="<?php echo URL('search', array('k' => V('r:k', ''), 'base_app' => V('r:base_app', '0')));?>"><?php LO('modules__modSearch__general');?></a></span></span>
			<span <?php if ($router_str == 'search.weibo'):?>class="current"<?php endif;?>><span><a href="<?php echo URL('search.weibo', array('k' => V('r:k', ''), 'base_app' => V('r:base_app', '0')));?>"><?php LO('modules__modSearch__weibo');?></a></span></span>
			<span <?php if ($router_str == 'search.user'):?>class="current"<?php endif;?>><span><a href="<?php echo URL('search.user', array('k' => V('r:k', ''), 'base_app' => V('r:base_app', '0')));?>"><?php LO('modules__modSearch__user');?></a></span></span>
		</div>
		
		<div class="search-block">
			<div class="search-inner">
				<input type="text" class="input-txt" value="<?php echo htmlspecialchars(V('r:k', ''));?>" name="k"  id="k" />
				<input type="hidden" name="m" value="<?php echo $router_str;?>"/>
			</div>
			<a href="#" class="s-btn skin-btn" id="searchBtn"><?php LO('modules__modSearch__search');?></a>
		</div>
		<?php if ($router_str == 'search.user'): ?>
		<input type="hidden" name="base_app" value="<?php echo V('r:base_app', '0'); ?>" />
		<div class="search-field">
		<label for="nick"><input type="radio" id="nick" name="ut" value="nick" <?php echo V('r:ut', 'nick') == 'nick' ? 'checked="checked"' : ''; ?> <?php if (trim(V('r:k', '')) !== ''): ?>onclick="javascript:$('#searchForm').submit();"<?php endif; ?> /><?php LO('modules__modSearch__nickname');?></label>
			<label for="sintro"><input type="radio" id="sintro" name="ut" value="sintro" <?php echo V('r:ut', '') == 'sintro' ? 'checked="checked"' : ''; ?> <?php if (trim(V('r:k', '')) !== ''): ?>onclick="javascript:$('#searchForm').submit();"<?php endif; ?> /><?php LO('modules__modSearch__desc');?></label>
			<label for="tags"><input type="radio" id="tags" name="ut" value="tags" <?php echo V('r:ut', '') == 'tags' ? 'checked="checked"' : ''; ?> <?php if (trim(V('r:k', '')) !== ''): ?>onclick="javascript:$('#searchForm').submit();"<?php endif; ?> /><?php LO('modules__modSearch__tags');?></label>
		</div>
		<?php else: ?>
		<div class="search-field" rel="subject:<?php echo htmlspecialchars(V('r:k', ''));?>">
			<p>
			<span class="ico-join"><a hideFocus="true" href="#" rel="e:sd,m:#<?php echo F('escape', addslashes(V('r:k')));?>#" title="<?php LO('modules__modSearch__pubWeibo');?>"><?php LO('modules__modSearch__attendTopic');?></a></span>
				<?php
				$sina_uid = USER::uid();
				$add_result = DR('xweibo/xwb.isSubjectFollowed', FALSE, $sina_uid, V('r:k'));
				if ($add_result['errno'] == 0):
				?>
				<span class="ico-follow"><a href="javascript:;" rel="e:addSubject"><?php LO('modules__modSearch__followTopic');?></a></span>
				<?php
				elseif($add_result['errno'] == 1):
				?>
				<span><?php LO('modules__modSearch__followed');?>(<a href="javascript:;" rel="e:delSubject"><?php LO('modules__modSearch__cancelFollowed');?></a>)</span>
				<?php
				endif;
				?>
				<!--span class="icon-join"><a href="">参与该话题</a></span><span>已关注(<a href="">取消关注</a>)</span-->
			</p>
		</div>
		<?php endif; ?>
		</form>
	</div>
</div>
