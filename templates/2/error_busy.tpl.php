<?php
$data = array(
'<p>垂钓绿湾春，春深杏花乱。</p><p>潭清疑水浅，荷动知鱼散。</p>',
'<p>宣室求贤访逐臣，贾生才调更无伦。</p><p>可怜夜半虚前席，不问苍生问鬼神。</p>',
'<p>秦时明月汉时关，万里长征人未还。</p><p>但使龙城飞将在，不教胡马度阴山。</p>',
'<p>江雨霏霏江草齐，六朝如梦鸟空啼。</p><p>无情最是台城柳，依旧烟笼十里堤。</p>',
'<p>银烛秋光冷画屏，轻罗小扇扑流萤。</p><p>天阶夜色凉如水，坐看牵牛织女星。</p>',
'<p>新妆宜面下朱楼，深锁春光一院愁。</p><p>行到中庭数花朵，蜻蜓飞上玉搔头。</p>',
'<p>更深月色半人家，北斗阑干南斗斜。</p><p>今夜偏知春气暖，虫声新透绿窗纱。</p>',
'<p>寒雨连江夜入吴，平明送客楚山孤。</p><p>洛阳亲友如相问，一片冰心在玉壶。</p>',
'<p>昨夜星辰昨夜风，画楼西畔桂堂东。</p><p>身无彩凤双飞翼，心有灵犀一点通。</p>',
'<p>鸡鸣紫陌曙光寒，莺啭皇州春色阑。</p><p>金阙晓钟开万户，玉阶仙仗拥千官。</p>',
'<p>渔舟逐水爱山春，两岸桃花夹古津。</p><p>坐看红树不知远，行尽青溪不见人。</p>',
'<p>纤云四卷天无河，清风吹空月舒波。</p><p>沙平水息声影绝，一杯相属君当歌。</p>'
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title','','错误提示');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="error">
	<div id="wrap">
    	<div class="wrap-in">
            <!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php TPL::plugin('include/site_nav');?>
					<!-- 站点导航 结束 -->
				</div>
                <div class="content">
                	<div class="main-wrap">
                        <div class="main">
                            <div class="main-bd">
                                <div class="error-box">
                                    <div class="error-busy-bg">
                                        <div class="error-busy-con">
                                            <p>读首唐诗休息下再试吧：</p>
                                            <br />
											<?php echo $data[array_rand($data)];?>
                                            <p><a href="javascript:window.location.reload()">再刷新看看</a></p>
                                        </div>
                                    </div>
                                </div>
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
</body>
</html>
