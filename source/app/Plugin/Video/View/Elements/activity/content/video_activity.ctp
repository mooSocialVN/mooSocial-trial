<?php $video = json_decode($activity['Activity']['params'],true); ?>
<div class="activity_feed_message">
	<?php echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1));?>
	<?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterShowFeedContent', $this, array('activity' => $activity))); ?>
	<?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<div class="activity_item">
    <div class="video-feed-body">
        <div class="video-feed-content">
            <?php
            $w = 590;
            $h = 465;
            $ssl_mode = Configure::read('core.ssl_mode');
            $http = (!empty($ssl_mode)) ? 'https' :  'http';

            switch ( $video['source'] )
            {
                case 'youtube':
                    echo '<iframe width="' . $w . '" height="' . $h . '" src="'.$http.'://www.youtube.com/embed/' . $video['source_id'] . '?wmode=opaque" frameborder="0" allowfullscreen></iframe>';
                    break;

                case 'vimeo':
                    echo '<iframe src="'.$http.'://player.vimeo.com/video/' . $video['source_id'] . '" width="' . $w . '" height="' . $h . '" frameborder="0"></iframe>';
                    break;
            }
            ?>
        </div>
        <div class="video-feed-info">
            <div class="video-title">
                <a class="activity_item_title" target="_blank" href="
            <?php if ( !empty( $video['group_id'] ) ): ?>
                <?php echo $this->request->base?>/groups/view/<?php echo $video['group_id']?>/video_id:<?php echo $video['id']?>
            <?php else: ?>
                <?php if(!empty($video['id'])):?>
                    <?php echo $this->request->base?>/videos/view/<?php echo $video['id']?>/<?php echo seoUrl($video['title'])?>
                <?php else:?>
                    <?php if($video['source'] == 'youtube'): ?>
                        <?php echo 'https://'.$video['source'].'.com/watch?v='.$video['source_id'];?>
                    <?php else: ?>
                        <?php echo 'https://'.$video['source'].'.com/'.$video['source_id'];?>
                    <?php endif; ?>
                <?php endif;?>
            <?php endif; ?>">
                    <?php echo $video['title']?>
                </a>
            </div>
            <div class="video-description">
                <?php echo $this->Text->truncate(nl2br($this->Text->convert_clickable_links_for_hashtags($video['description'], Configure::read('Video.video_hashtag_enabled') )), 400, array('exact' => false))?>
            </div>
        </div>
    </div>
</div>
