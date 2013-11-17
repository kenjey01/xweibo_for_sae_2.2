<?php
	$letter = array(L('celeb__starChildSortList__other'),'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php echo F('web_page_title', false, L('celeb__starChildSortList__fameTitle', $sort['name']));?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
<link href="<?php echo W_BASE_URL;?>css/default/pub.css" rel="stylesheet" type="text/css" />
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
                                <!-- 名人堂二级分类 开始 -->
                                <div class="title-box">
								<h3><a href="<?php echo URL('celeb');?>"><?php LO('celeb__starChildSortList__fame');?></a>
                                    <em class="gt">&gt;</em><a href="<?php echo URL('celeb.starSortList', 'id='.$sort_parent['id']);?>" class="guide-link" title="<?php echo strip_tags($sort_parent['name']);?>"><?php echo strip_tags($sort_parent['name']);?></a>
                                    <em class="gt">&gt;</em><span><?php echo strip_tags($sort['name']);?></span>
                                    </h3>
                                </div>
                                
                                <!-- 字母检索 开始 -->
                                <div class="guide-index">
									<h4><?php echo $sort['name'];?></h4>
    									<div class="index-list">
    									<?php if(empty($index_list)): ?>
										<span><?php LO('celeb__starChildSortList__categoryEmptyTip');?></span>
    									<?php else: ?>
										<span><?php LO('celeb__starChildSortList__letterSearch');?></span>
											<?php foreach($index_list as $id):?>
											 	<a href="#<?php echo $id;?>"><?php echo $letter[$id];?></a>
											<?php endforeach;?>
    									<?php endif; ?>
    									</div>
							    </div>
                                <!-- 字母检索 结束 -->
                                
                                <!-- 名人列表 开始 -->
                        		<?php
                        		foreach($list as $id => $re){
                        			Xpipe::pagelet(
                        				'user.outputCelebUserBlock',
                        				array(
                        					'id' => $id,
                        					'name' => $letter[$id],
                        					'data' => $re,
                        					'show_more_link' => false,
                        				)
                        			);
                        		}
                        		?>
                                <!-- 名人列表 结束 -->
                                
                                <!-- 名人堂二级分类 结束 -->
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
