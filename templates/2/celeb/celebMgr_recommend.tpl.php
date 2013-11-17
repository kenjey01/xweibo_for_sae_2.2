<?php 
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', false, L('celeb__starChildSortList__fame'));?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
<link href="<?php echo W_BASE_URL ?>css/default/pub.css" rel="stylesheet" type="text/css" />
</head>

<body id="user-recommend">
	<div id="wrap">    
    	<div class="wrap-in">	
            <!-- 头部 开始-->
			<?php TPL::plugin('include/header'); ?>
            <!-- 头部 结束-->
            <div id="container" class="single">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav'); ?>
					<!-- 站点导航 结束 -->
				</div>
                <div class="content">
                	<div class="main-wrap">
                        <div class="main user-recom">
                        	<div class="main-bd">
                                <div class="recom-top">
									<img src="<?php echo W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/recommend_bg.png'; ?>" alt="" />
                                </div>
                                <div class="title-box">
								<h3><?php LO('celeb__starChildSortList__fame');?></h3>
                                </div>
                                <!-- 标签分类 开始 -->
                                <?php TPL::module('celeb/classify_list', array('sort_list' => $sort_list)); ?>
                                <!-- 标签分类 结束 -->
                                
                        		<!-- 名人列表 开始 -->
                        		<?php
                        		foreach($list as $key=>$rs){
                        			if(!empty($rs['data'])){
                        				$rs['id'] = $key;
                        				Xpipe::pagelet('user.outputCelebUserBlock', $rs);
                        			}
                      		  }
                      		  ?>
                      		  <!-- 名人列表 结束 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!-- 底部 开始-->
            <?php TPL::module('footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
    <?php TPL::module('gotop');?>
</body>
</html>
