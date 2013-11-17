<?php 
	/**
	 * 热门话题列表模块模板
	 * 需要参数参见component_6_pls
	 * @version $Id$
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
	$base_app = 0;
	if(isset($mod['param']['topic_get']) && $mod['param']['topic_get'] == 2){
		$base_app = 1;
	}
?>

<div class="mod-aside top10">
    <div class="hd"><h3><?php echo F('escape', $mod['title']);?></h3></div>
    <div class="bd">
        <ul>
    
        <?php
            $count  = 1;
            if (!empty($rs)) 
            {
                foreach ($rs as $row) 
                {
                    $topic 	= F('escape', $row['topic']);
                    $url 	= URL('search.weibo', array('base_app' => $base_app, 'k' => isset($row['query']) ? $row['query']: $row['topic']));
        ?>
                     <li>
                        <div class="ranking<?php if ($count < 4):?> r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
                        <a href="<?php echo $url;?>"><?php echo $topic;?></a>
                    </li>
        <?php 
                $count++;
                }
            }
        ?>
        </ul>
    </div>
</div>
