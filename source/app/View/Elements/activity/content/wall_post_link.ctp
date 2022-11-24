<?php
$link = unserialize($activity['Activity']['params']);
$url = (isset($link['url']) ? $link['url'] : $activity['Activity']['content']);
?>
<div class="activity_feed_message">
    <?php echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1));?>
    <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterShowFeedContent', $this, array('activity' => $activity))); ?>
    <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>

<?php  if ( !empty( $link['title'] ) ):?>
    <div class="activity_item activity_tb">
        <?php if ( !empty( $link['image'] ) ): ?>
        <div class="activity_left">
            <?php
                if ( strpos( $link['image'], 'http' ) === false ):
                    $link_image = $this->storage->getUrl($activity['Activity']["id"],'',$link['image'],"links") ;//$this->request->webroot . 'uploads/links/' .  $link['image'] ;
                else:
                    $link_image = $link['image'];
                endif;
            ?>
            <a class="activity_img_thumb" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                <img src="<?php echo $link_image ?>" class="activity-img">
            </a>
        </div>
        <?php endif; ?>
        <div class="<?php if ( !empty( $link['title'] ) ): ?>activity_right <?php endif; ?>">
            <a class="activity_item_title" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                <?php echo h($link['title'])?>
            </a>
            <?php
                if ( !empty( $link['description'] ) )
                    echo '<div class="activity_item_text">' . ($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
            ?>
        </div>
    </div>
<?php elseif ( !empty( $link['type'] ) && $link['type'] == 'img' && !empty( $link['image'])):?>
    <div class="activity_item">
        <div class="activity_parse_img">
            <img src="<?php echo $link['image'] ?>" class="activity-img">
        </div>
    </div>
<?php endif; ?>