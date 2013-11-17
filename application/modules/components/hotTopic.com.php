<?php
/**
* 热门话题
*
* @version $1.1: hotTopic.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/

require_once P_COMS . '/PageModule.com.php';

class hotTopic extends PageModule{

	var $component_id = 6;

	function hotTopic() {
		parent :: PageModule();

		//如果未登录，使用管理员的token访问
		if (!USER::uid()) {
			DS('xweibo/xwb.setToken', '', 2);
		}
	}

	/**
	 * \获取 话题列表
	 */
	function get($param = array()) 
	{
//		$this->clearCfgCache();
		$cfg 		= $this->configList();
		$topic_get 	= isset($param['topic_get']) ? (int)$param['topic_get'] : 1;
		//$topic_id 	= ($topic_get == 0 && isset($param['topic_id'])) ? $param['topic_id'] : 0;
		$topics		= isset($param['topics'])?$param['topics']:NULL;
		$show_num	= isset($param['show_num']) ? (int)$param['show_num'] : (int)$cfg['show_num'];
		//$show_num 	= ($show_num > 0) ? (int)$show_num: 10;

		//表示使用本地内容列表
		if ($topic_get == 0 && $topics != NULL && is_array($topics) && isset($topics[0])) {
			$rs = array();
			foreach($topics as $topic){
				$rs[] = array('topic'=>$topic,'query'=>F('escape',$topic));
			}
			return RST($rs);
		} else { //否则使用新浪API
			$source = $topic_get == 2 ? 1 : 0;
			$rs =DR('xweibo/xwb.getTrendsDaily', '', false, $source);
			
			if ($rs['errno'] == 0) {
				$tmp = array();
				$count = 0;

				foreach (current($rs['rst']['trends']) as $row) {
					if (++$count > $show_num) {
						break;
					}
					array_push($tmp, array('topic' => $row['name'], 'query' => $row['query']));
				}

				return RST($tmp);
			}

			return $rs;

		}

	}
}
