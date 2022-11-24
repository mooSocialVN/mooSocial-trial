<?php $videoHelper = MooCore::getInstance()->getHelper('Video_Video'); ?>
<?php if (!empty($video['Video']['pc_upload'])): ?>
    <?php $this->getEventManager()->dispatch(new CakeEvent('Video.View.Elements.renderVideoUpload', $this, array('video' => $video))); ?>
<?php else: ?>    
    <?php
    $ssl_mode = Configure::read('core.ssl_mode');
    $http = (!empty($ssl_mode)) ? 'https' : 'http';
    switch ($video['Video']['source']) {
        case VIDEO_TYPE_YOUTUBE:
            echo '<iframe width="' . VIDEO_WIDTH . '" height="' . VIDEO_HEIGHT . '" src="' . $http . '://www.youtube.com/embed/' . $video['Video']['source_id'] . '?wmode=opaque" frameborder="0" allowfullscreen></iframe>';
            break;

        case VIDEO_TYPE_VIMEO:
            echo '<iframe src="' . $http . '://player.vimeo.com/video/' . $video['Video']['source_id'] . '" width="' . VIDEO_WIDTH . '" height="' . VIDEO_HEIGHT . '" frameborder="0"></iframe>';
            break;
    }
    ?>
<?php endif; ?>