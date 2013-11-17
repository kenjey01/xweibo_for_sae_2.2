<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 组件设置 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：组件管理<span> &gt; </span>组件设置<span> &gt; </span>组件列表</div>
    <div class="set-wrap">
        <div class="sub-set01">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
            	<form action="" method="post">
                	<div class="set1">
        				<div class="sub-set-l">名人列表获取方式：</div>
                		<div class="sub-set-r">
                    		<label for="personlist">
                				<input name="personlist" type="radio" value="" checked="checked" />自定义名人推荐列表
                        	</label><br />
                        	<label for="personlist">
                				<input name="personlist" type="radio" value="" />使用新浪微博提供的名人列表
                        	</label>
                		</div>
                    </div>
                    <div class="set2">
                    	<div class="sub-set-l">组件显示的标题：</div>
                    	<div class="sub-set-r">名人推荐</div>
                    </div>
                    <div class="set3">
                    	<div class="sub-set-l">内容显示设置：</div>
                		<div class="sub-set-r">
                    		<label for="content">
                				<input name="content" type="radio" value="" checked="checked" />显示用户名及名人的自我介绍
                        	</label><br />
                        	<label for="content">
                				<input name="content" type="radio" value="" />显示用户名及站长对名人的注释
                        	</label><br />
                        	<label for="content">
                				<input name="content" type="radio" value="" />仅显示用户名
                        	</label>
                		</div>
                    </div>
                    <div class="set4">
                    	<div class="sub-set-l">每一版显示名人推荐的数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number1">
                    			<input name="number1" type="text" /><span class="sub-tips">（建议：推荐数量设置为3至5之间为佳）</span>
                        	</label>
                    	</div>
                    </div>
                    <div class="button sub-position"><input name="" type="submit" value="提交" /></div>
            	</form>
    		</div>
        </div>
        <div class="sub-set02">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form action="" method="post">
                	<div class="set1">
                		<div class="sub-set-l">组件显示的用户数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number2">
                    			<input name="number2" type="text" /><span class="sub-tips">（建议：推荐数量设置为3至5之间为佳）</span>
                       		</label>
                    	</div>
                	</div>
                	<div class="button"><input name="" type="submit" value="提交" /></div>
            	</form>
    		</div>
        </div>
        <div class="sub-set03">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form action="" method="post">
                	<div class="set1">
                    	<div class="sub-set-l">组件使用的用户列表：</div>
                    	<div class="sub-set-r"><a href="recommended_users.html">微博频道用户列表</a></div>
                    </div>
                	<div class="set2">
                		<div class="sub-set-l">组件显示官方用户的数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number3">
                    			<input name="number3" type="text" /><span class="sub-tips">（建议：推荐数量设置为3至5之间为佳）</span>
                       		</label>
                    	</div>
                	</div>
                	<div class="button"><input name="" type="submit" value="提交" /></div>
                </form>
    		</div>
        </div>
        <div class="sub-set04">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form action="" method="post">
                	<div class="set1">
                    	<div class="sub-set-l">组件使用的话题列表：</div>
                    	<div class="sub-set-r"><a href="recommended_topic.html">今日话题列表</a></div>
                    </div>
                    <div class="set2">
                    	<div class="sub-set-l">组件显示的标题：</div>
                    	<div class="sub-set-r">今日话题</div>
                    </div>
                	<div class="set3">
                		<div class="sub-set-l">组件显示用户的条数：</div>
                    	<div class="sub-set-r">
                    		<label for="number4">
                    			<input name="number4" type="text" /><span class="sub-tips">（注意：微博条数不得超过3条）</span>
                       		</label>
                    	</div>
                	</div>
                	<div class="button"><input name="" type="submit" value="提交" /></div>
                </form>
    		</div>
        </div>
        <div class="sub-set05">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form action="" method="post">
                    <div class="set1">
                    	<div class="sub-set-l">组件显示的标题：</div>
                    	<div class="sub-set-r">随便看看</div>
                    </div>
                	<div class="set2">
                		<div class="sub-set-l">滚动展示的数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number5">
                    			<input name="number5" type="text" /><span class="sub-tips">（建议：推荐数量设置为4至6之间为佳）</span>
                       		</label>
                    	</div>
                	</div>
                	<div class="button"><input name="" type="submit" value="提交" /></div>
                </form>
    		</div>
        </div>
        <div class="sub-set06">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form action="" method="post">
                    <div class="set1">
                    	<div class="sub-set-l">组件显示的标题：</div>
                    	<div class="sub-set-r">同城微博</div>
                    </div>
                	<div class="set2">
                		<div class="sub-set-l">组件显示用户的数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number6">
                    			<input name="number6" type="text" /><span class="sub-tips">（建议：推荐数量设置为3至5之间为佳）</span>
                       		</label>
                    	</div>
                	</div>
                	<div class="button"><input name="" type="submit" value="提交" /></div>
                </form>
    		</div>
        </div>
        <div class="sub-set07">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
    		</div>
        </div>
        <div class="sub-set08">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form action="" method="post">
                	<div class="set1">
        				<div class="sub-set-l">话题获取方式：</div>
                		<div class="sub-set-r">
                    		<label for="topic-get">
                				<input name="topic-get" type="radio" value="" checked="checked" />自定义话题列表
                        	</label><br />
                        	<label for="topic-get">
                				<input name="topic-get" type="radio" value="" />使用新浪微博提供的热门话题
                        	</label>
                            <div class="defined-topic">
                            	<label for="">请选择热门话题榜单组件使用的话题列表：
                                	<select name="">
                                    	<option selected="selected">热门话题列表</option>
                                    </select>
                        		</label>
                            </div>
                		</div>
                    </div>
                    <div class="set2">
                    	<div class="sub-set-l">组件显示的标题：</div>
                    	<div class="sub-set-r">热门话题</div>
                    </div>
                    <div class="set4">
                    	<div class="sub-set-l">组件显示推荐话题的的数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number8">
                    			<input name="number8" type="text" /><span class="sub-tips">（建议：推荐数量设置为5至10之间为佳，最大值为10）</span>
                        	</label>
                    	</div>
                    </div>
                    <div class="button"><input name="" type="submit" value="提交" /></div>
            	</form>
    		</div>
        </div>
        <div class="sub-set09">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form action="" method="post">
                    <div class="set1">
                    	<div class="sub-set-l">组件显示的标题：</div>
                    	<div class="sub-set-r">猜你喜欢</div>
                    </div>
                	<div class="set2">
                		<div class="sub-set-l">组件显示用户的数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number9">
                    			<input name="number9" type="text" /><span class="sub-tips">（建议数量设置为3的倍数,范围3至9）</span>
                       		</label>
                    	</div>
                	</div>
                	<div class="button"><input name="" type="submit" value="提交" /></div>
                </form>
    		</div>
        </div>
        <div class="sub-set10">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form action="" method="post">
                	<div class="set1">
                		<div class="sub-set-l">组件显示推荐用户的数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number10">
                    			<input name="number10" type="text" /><span class="sub-tips">（建议：推荐数量设置为5至10之间为佳）</span>
                       		</label>
                    	</div>
                	</div>
                	<div class="button"><input name="" type="submit" value="提交" /></div>
                </form>
    		</div>
        </div>
        <div class="sub-set11">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
            	<form action="" method="post">
        			<div class="rec-userlist">
                		<label for="rec-userlist">请选择推荐用户组件使用的用户列表：
                    		<select name="rec-userlist">
                        		<option selected="selected">推荐用户列表</option>
                        	</select>
                    	</label>
                	</div>
                	<div class="set1">
                		<div class="sub-set-l">组件显示推荐用户的数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number11">
                    			<input name="number11" type="text" /><span class="sub-tips">（建议：推荐数量设置为5至10之间为佳）</span>
                       		</label>
                    	</div>
                	</div>
                	<div class="button"><input name="" type="submit" value="提交" /></div>
                </form>
    		</div>
        </div>
    </div>
</div>
</body>
</html>
