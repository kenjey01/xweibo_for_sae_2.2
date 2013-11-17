<!-- 模板使用说明 -->
<pre style="color: green; border: 1px solid blue; left: 550px; top: 150px; position: absolute; padding: 20px; background-color: #eeeeee;">
<b style="color: red;">模板与pagelet使用说明: </b>


//单个变量赋值 在模板中产生 $tpl_var
TPL::assign('tpl_var',$tpl_var);

//多个变量（数组）赋值，在模板中产生 $date_str $time_str　变量
TPL::assign($arr_var);

//在　PAGE_TYPE_CURRENT　定义的布局目录下寻找模板，并渲染
TPL::display('demo/pipeTest');

//TPL::fetch　则获取内容

//TPL::plugin　可调用同一布局下的不同布局模板，或者 不通用的　pagelets
TPL::plugin('demo/inc/pipePlug');

//TPL::module 可调用不同布局的公共模块，通常是　pagelet　模板
TPL::module('demo/pipeModule',array('title'=>$title));

//在pagaelet中调试，查看变量
Xpipe::debug($tpl_var);

//在布局模板中嵌入pagelet
&lt;?php Xpipe::pagelet('demo/plTest.test', "top".$tn++); ?&gt;
</pre>
