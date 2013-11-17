<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关键字过滤 - 用户管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body class="main-body">
	<div class="path"><span class="pos"></span>当前位置：<a href="#">系统设置</a>&gt;<span>清除缓存</span></div>
    <div class="main-cont">
        <h3 class="title">清除缓存</h3>
		<div class="set-area">
        	<p class="approve-tips">
            	当站点进行了数据恢复、工作出现异常或者后台进行了一些模块、数据设置前台没有立即生效的时候，你可以使用本功能清除缓存。
                <br/>清除缓存的时候，可能让服务器负载升高，请尽量避开会员访问的高峰时间。
            </p>
            <div class="btn-area" id="btnArea">
                <a href="#" class="btn-general highlight" rel="e:cl"><span>清除缓存</span></a>
                <span class="program-tips hidden">正在更新缓存，请稍后</span>
            </div>
        </div>
    </div>
<script type="text/javascript">
var X = window.Xwb;

X.use('base', {
   view : '#btnArea',
   
   autoRender : true,
   
   actionMgr : true,
   
   status : null,
   
   onactiontrig : function(e){
       switch (e.data.e) {
           case 'cl':
            this.actClear(e.data, e);
           break;
       }
   },
   
   actClear : function(data, e){
       e.lock(1);
       
       var self = this;
       
       this.status(1);
       
       $.post('<?php echo URL('mgr/setting.cacheClear');?>', function(){
           self.clearDone(e);
       });
   },
   
   clearDone : function(e){
       this.status(2, function(){
           e.lock(0);
       });
   },
   
   onViewReady : function(){
       var $tip = this.jq('.program-tips'), interval, runState = 0, tipClock = 0;
       
       function repeat(s, n){
            var a = [];
            while(a.length < n){
                a.push(s);
            }
            return a.join('');
        }
       
       this.status = function(state, fn){
           switch (state) {
               case 1: //开始执行
               if (runState > 0) {
                   return;
               }
               
               $tip.show().cssDisplay(1);
               
               $tip.text('正在更新缓存，请稍后');
               
                interval = setInterval(function(){
                    $tip.text('正在更新缓存，请稍后' + repeat('.', (tipClock%5) + 1));
                    tipClock++;
                }, 250);
                
                runState = 1;
               break;
               
               case 2: //完成
                    window.clearInterval(interval);
                    runState = tipClock = 0;
                    $tip.text('清除成功!')
                    .fadeOut(2000, function(){
                        fn && fn();
                    });
               break;
           }
       }
   }
});

</script>
</body>
</html>
