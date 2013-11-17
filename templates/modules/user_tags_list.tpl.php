<ul>
<?php if ($taglist):?>
<?php foreach($taglist as $tag):?>
<?php foreach ($tag as $key => $item):?>
<li><a href="<?php echo URL('search', 'k='.urlencode($item));?>" class="a1"><?php echo F('escape', $item);?></a><a href="#" class="close-ico" rel="e:dt,id:<?php echo $key;?>"></a></li>
<?php endforeach;?>
<?php endforeach;?>
<?php endif;?>
</ul>
