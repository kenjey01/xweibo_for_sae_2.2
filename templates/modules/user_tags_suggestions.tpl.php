<?php foreach($tagsuglist as $tag):?>
<a href="#" rel="e:ct,t:<?php echo $tag['value'];?>" ><span>+</span><?php echo $tag['value'];?></a>
<?php endforeach;?>
