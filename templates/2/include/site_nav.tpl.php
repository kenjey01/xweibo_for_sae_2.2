<div class="site-nav">
	<div class="nav-bd">
		
	<?php 
		// 定义二级导航的逻辑
		function sonNavHtm(&$sonNavList, &$pageList)
		{
			echo '<ul>';
			foreach ($sonNavList as $aSonNav) 
			{
				if (!isset($aSonNav['data']) ||$aSonNav['data']['in_use'] != '1') continue;
				$sonPageId  = $aSonNav['data']['page_id'];
				//$uri = array();
				//if (isset($pageList[$sonPageId]) && $pageList[$sonPageId]['native'] == '0') {
					$uri = array(
						'page_id' => $sonPageId,
						'navId' => $aSonNav['data']['id']
						);
				//}
				if ($sonPageId == -1) {
					$sonUrl = $aSonNav['data']['url'];
				} else {
					$sonUrl 	= isset($pageList[$sonPageId]['url']) ? URL($pageList[$sonPageId]['url'], $uri) : '#';
				}
				//var_dump($aSonNav['data']['is_blank']);
				//$target  	= $aSonNav['data']['is_blank'] ? ' target="_blank" ' : '';
				//var_dump(strpos($aSonNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH));
				//var_dump($aSonNav['data']['page_id']==-1&&!strpos($aSonNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH));
				if($aSonNav['data']['page_id']==-1&&!strpos($aSonNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH)){
					$target='target="_blank"';	
				}
				else{
					$target='';
				}
				//var_dump($target);
				$selected = $aSonNav['data']['id'] == V('g:navId')?' cur':'';
				echo "<li><a href='$sonUrl' $target class='cur-common $selected'>{$aSonNav['data']['name']}</a></li>";
			}
			echo '</ul>';
		}
		
		
		$pageList = DR('PageModule.getPagelistByType');
		$navList  = DR('Nav.getNavList', FALSE, TRUE);
		$first = true;
		// 图标样式
		$nav_style = array(
			'1' => 'ico-pub',// 微博广场
			'6' => 'ico-rank', // 话题排行榜
			'7' => 'ico-live', // 在线直播
			'8' => 'ico-talk', // 在线访谈
			'3' => 'ico-star'
		);
		
		foreach ($navList as $id => $aNav)
		{
			if (!isset($aNav['data']) || $aNav['data']['in_use'] != '1') continue;
			$selected = $aNav['data']['id'] == V('g:navId')?' cur':'';
			echo '<div class="nav-block' . ($first?' first':''). '">';
			$first = false;
			$pageId  = $aNav['data']['page_id'];
			if ($pageId == '-1') {
				$pageUrl = $aNav['data']['url'];
				if (strpos($pageUrl, 'http://') === false) {
					$pageUrl = 'http://' . $pageUrl;
				}
			} else {
				$p = array('page_id' => $pageId, 'navId' => $aNav['data']['id']);
				$pageUrl = isset($pageList[$pageId]['url']) ? URL($pageList[$pageId]['url'], $p) : '#';
			}
			//$target  = $aNav['data']['is_blank'] ? ' target="_blank" ' : '';
			//var_dump($aNav['data']['page_id']	);
			if($aNav['data']['page_id']==-1&&!strpos($aNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH)){
					$target='_blank';	
				}
			else{
				$target='';
			}
			
			if (21 == $id) { // 我的首页  ?>
				<h3>
					<a href="<?php echo $pageUrl; ?>" <?php echo $target;?> class="<?php echo $selected;?>"><s class="ico-home"></s><?php echo $aNav['data']['name']; ?></a>
				</h3>
				<ul>
					<li>
					<a href="<?php echo URL('index.profile');?>" class="<?php echo APP::getRequestRoute() == 'index.profile'?' cur':''?>"><?php LO('include__siteNav__myWeibo');?></a>
					</li>
					<li>
					<a href="<?php echo URL('index.atme');?>" class="<?php echo in_array(APP::getRequestRoute(), array('index.atme', 'index.comments', 'index.messages', 'index.notices'))?' cur':''?>"><?php LO('include__siteNav__myMessage');?></a>
						<a href="<?php echo URL('index.atme');?>" class="square hidden" id="referMe"><span><span id="t">8</span></span></a>
					</li>
					<li><a href="<?php echo URL('index.favorites');?>" class="<?php echo APP::getRequestRoute() == 'index.favorites'?' cur':''?>"><?php LO('include__siteNav__myFavs');?></a></li>
				</ul>
			<?php } else {
				$style = isset($nav_style[$aNav['data']['page_id']]) ? $nav_style[$aNav['data']['page_id']] : 'ico-ct1';
				$style = 'class="' . $style . '"'
			?>
				
				<h3><a href="<?php echo $pageUrl; ?>" <?php echo $target;?> class=" <?php echo $selected;?>"><s <?php echo $style; ?>></s><?php echo $aNav['data']['name']; ?></a></h3>
					
			<?php } 
			if (isset($aNav['son'])) { // 二级导航
					sonNavHtm($aNav['son'], $pageList); 
				} 
			echo '</div>';
		} ?>
		
	</div>
</div>

