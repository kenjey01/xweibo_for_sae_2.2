<?php

class loginGuide {
	/**
	 * 返回登录引导关注页的推荐用户组ID列表
	 *
	 */
	function get() {
		$itemGroup = APP::N('itemGroups');

		$groups = $itemGroup->getItems(2);

		return $groups;
	}


}