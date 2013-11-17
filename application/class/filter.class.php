<?php
/**************************************************
*  Created:  2010-11-18
*
*  用户、微博、回复过滤
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/

require_once  APP::functionFile('get_filter_cache');
class filter{
	var $cfg = array(
				'sub_filter' => true,//是否过滤最后回复、发表、转发
				'only_chk_verify' => false // 是否只检查是否通过认证
				);

	/**
	 * 得到过滤器要使用的数据
	 * @param $index 要得到的数据类型
	 * @return array
	 */
	function getFilterData($index = null) {
		static $data = null;
		if ($data === null) {
			$data = array(
						'user_verify' => get_filter_cache('user_verify'),
						'weibo' => get_filter_cache('weibo'),
						'comment' => get_filter_cache('comment'),
						'content' => get_filter_cache('content'),
						'nick' => get_filter_cache('nick')
						);
		}
		if ($index !== null && isset($data[$index])) {
			return $data[$index];
		}
		return $data;
	}

	/**
	 * 设置配置项
	 * @param $index 配置项下标
	 * @param $value 配置项的值
	 */
	function setConfig($index, $value = null) {
		if (is_array($index)) {
			$this->cfg = array_merge($this->cfg, $index);
		} else {
			$this->cfg[$index] = $value;
		}
	}
	/**
	 * 过滤单条用户数据
	 * @param $data array 单条用户数据
	 * @return array
	 */
	function user(&$data) {
		if (!is_array($data)) {
			return false;
		}
		$data['filter_state'] = array();
		if (!(isset($data['id']))) {
			$data['filter_state'][] = 1; //要过滤的数据不完整
			return $data;
		}

		$f_verify = $this->getFilterData('user_verify');
		if (isset($f_verify[(string)$data['id']])) {
			$data['site_v'] = 1;
			$data['site_v_reason'] = $f_verify[(string)$data['id']]['reason'];
		} else {
			$data['site_v'] = 0;
			$data['site_v_reason'] = '';
		}
		
		///原有系统用户过滤
		$f_nick = $this->getFilterData('nick');
		if (isset($f_nick[(string)$data['id']])) {
			$data['filter_state'][] = 2; // 用户已被屏蔽
			//return $data;
		}
		///现在的user_action过滤表
		if(F('user_action_check',array(3),$data['id'])){
			$data['filter_state'][] = 2;
		}
		
		
		// 过滤最后发布的微博
		if ($this->cfg['sub_filter'] && isset($data['status'])) {
			$this->weibo($data['status']);
		}
		return $data;
	}

	/**
	 * 批量过滤用户
	 * @param $data array 要过滤的数据
	 * @return array
	 */
	function users(&$data) {
		$after = array();
		$count = count($data);
		for ($i=0; $i<$count; $i++) {
			$user=$this->user($data[$i]);
			if($user){
				$after[] = $user;	
			}
			
		}
		return $after;
	}

	/**
	 * 过滤微博或回复
	 * @param $data array 要过滤的数据
	 * @return array
	 */
	function weibo(&$data) {
		if (!is_array($data)) {
			return false;
		}
		$data['filter_state'] = array();
		// 检查格式
		if (!isset($data['id']) && isset($data['text'])) {
			//$this->addError(array('error'=>'要过滤的数据不完整', 'data'=>$data));
			$data['filter_state'][] = 1;
			return array();
		}

		$f_weibo = $this->getFilterData('weibo');
		if (!$this->cfg['only_chk_verify']) {
			if (!isset($data['status'])) {
				if (isset($f_weibo[(string)$data['id']])) {
					$data['filter_state'][] = 3;// 该微博被屏蔽
					//return $data;
				}
			} else {
				$f_comment = $this->getFilterData('comment');
				if (isset($f_comment[(string)$data['id']])) {
					$data['filter_state'][] = 3;// 该回复被屏蔽
					//return $data;
				}
			}

			$f_content = $this->getFilterData('content');
			reset($f_content);
			do {
				$f = key($f_content);
				if (!empty($f) && strpos($data['text'], $f) > -1) {
					//$this->addError(array('error'=>'内容包含有关键字:' . $k, 'data'=>$data));
					$data['filter_state'][] = 4;
					//return $data;
				}
			} while(next($f_content));
			if (isset($data['user'])) {
				$this->user($data['user']);
			}
		} // end if

		// 处理子内容
		if ($this->cfg['sub_filter']) {
			if (isset($data['retweeted_status'])) {
				//$d = &$data['retweeted_status'];
				$this->weibo($data['retweeted_status']);
			}
			if (isset($data['status'])) {
				//$d = &$data['status'];
				$this->weibo($data['status']);
			}
			/*
			if (isset($d)) {
				$this->weibo($d);
			}*/
		}
		return $data;
	}

	/**
	 * 批量过滤微博
	 * @param $data array
	 * @return array
	 */
	function weibos(&$data) {
		$count = count($data);
		$after = array();
		for ($i=0; $i< $count; $i++) {
			$after[] = $n = $this->weibo($data[$i]);
//echo '<pre>';var_dump($n);exit;echo '</pre>';

		}
		return $after;
	}
}

