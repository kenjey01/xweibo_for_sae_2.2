<?php
/**************************************************
*  Created:  2010-06-08
*
*  头像url
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

/**
 * profile image url
 *
 * @param string $url
 * @param string $type
 * @return string
 */
function profile_image_url($url, $type = 'index')
{
	if (strpos($url, 'http') === false) {
		//$id = $url % 4 + 1;
		//解决长ID问题
		$id = (substr($url+100,-2)*1) % 4 + 1;
		
		if ($type == 'index') {
			$size = 50;
		} elseif ($type == 'comment') {
			$size = 30;
		} elseif ($type == 'profile') {
			$size = 180;
		}
		$url = 'http://tp'.$id.'.sinaimg.cn/'.$url.'/'.$size.'/'.date('Ymd', APP_LOCAL_TIMESTAMP);
		return $url;
	} else {
		switch ($type) {
			case 'comment':
				$urls = explode('/', $url);
				$urls[4] = 30;
				$url_new = implode('/', $urls);
				break;
			case 'profile':
				$urls = explode('/', $url);
				$urls[4] = 180;
				$url_new = implode('/', $urls);
				break;
			default:
				$url_new = $url;
		}
		return $url_new;
	}
}

/**
 * 构造微博图片url
 *
 * @params string $picid 图片id
 * @params string $type 图片类型
 *
 * @return string
 */
function thumbnail_pic($picid, $type = 'thumbnail')
{
	$no = rand(1, 4);
	$url = 'http://ww'.$no.'.sinaimg.cn/'.$type.'/'.$picid.'.jpg';
	return $url;
}
