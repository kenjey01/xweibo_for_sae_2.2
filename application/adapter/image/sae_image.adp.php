<?php 
 /** 
  * Image  
  * 
  * 提供图片的一些常用处理程序 
  *$img = new images();
  *$img->loadFile("test.gif")->crop(0,0,100,100)->resize(50,50)->waterMark("mark.png", 'left','center')->save("b.gif");
  */ 
  
 class sae_image { 
         var $img;   //图像标识符 
         var $info;  //保存图片的一些信息 
         var $saeimg; //sae类
  
         function sae_image($file=null) { 
         	$this->saeimg = new SaeImage();
            if($file) $this->loadFile($file); 
         } 
  
         /** 
          * 初始化，创建图像标识符 
          * 
          * @param $file 源文件 
          */ 
         function loadFile($file) { 
         	$this->saeimg->clean();
         	$http = APP::ADP('http');
         	$http->setUrl($file);
         	$data = $http->request();
         	if($data){
			 $this->saeimg->setData($data);
			 return $this; 
         	}else{
         		return false;
         	}
         } 
  
         /** 
          * 图片缩放 
          * 
          * @param int $width 目标宽度 
          * @param int $height 目标高度 
          * @param boolean $keepScale，是否等比缩放 
          * @return array $wh 包含缩放后宽度和高度的数组 $wh[0]为宽度，$wh[1]为高度 
          */ 
         function resize($width = 0, $height = 0, $keepScale=true) { 
         	$this->saeimg->resize($width,$height);
			return $this; 
         } 
         function  getImgInfo(){
         	$key = array('width', 'height', 'type'); 
			$info = array_combine($key, array_slice($this->saeimg->getImageAttr(), 0, 3)); 
         	return $info;
         }
  		 /** 
          * 将图片输出到浏览器 
          * 
          * @param $type 格式 
          */ 
         function output($type='gif') {                
             return $this->saeimg->exec( $type , true );
         } 
         
         /** 
          * 图片裁剪 
          * 
          * @param int $x x坐标 
          * @param int $y y坐标 
          * @param int $w 裁剪宽度 
          * @param int $h 裁剪高度 
          * @return resource 返回成功或者失败
          */ 
         function crop($x, $y, $w, $h){ 
         	return $this->saeimg($x,$y,($x+$w),($y+$h));
         }
         function save($key){
         	$io = APP::ADP('io');
         	return $io->write($key,$this->saeimg->exec());
         }
 } 
 ?>
