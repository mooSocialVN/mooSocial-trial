<?php $videoHelper = MooCore::getInstance()->getHelper('Video_Video'); ?>
<a class="no_permission_video thumb_video" data-target="#themeModal" data-toggle="modal" href="<?php echo $video['Video']['moo_href']?>" style="background-image: url(<?php echo $videoHelper->getImage($video, array('prefix' => '850')) ?>)">
</a>