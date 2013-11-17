<div class="user-menu">
<a class="home-current" href="<?php  echo URL('index');?>"><?php LO('modules__userMenu__myIndex');?></a>
<a class="atme-current" href="<?php  echo URL('index.atme');?>"><?php LO('modules__userMenu__atMe');?></a>
<a class="comment-current" href="<?php  echo URL('index.comments');?>"><?php LO('modules__userMenu__myComment');?></a>

<?php if (HAS_DIRECT_MESSAGES) {?>
<a class="messages-current" href="<?php  echo URL('index.messages');?>"><?php LO('modules__userMenu__myMessage');?></a>
<?php } ?>

<a class="systemnotice-current" href="<?php  echo URL('index.notices');?>"><?php LO('modules__userMenu__myNotice');?></a>
<a class="favs-current" href="<?php  echo URL('index.favorites');?>"><?php LO('modules__userMenu__myFavs');?></a>
</div>
