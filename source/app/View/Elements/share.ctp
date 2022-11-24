<?php if ($activity['Activity']['privacy'] != PRIVACY_ME): ?>

    <?php if (!empty($activity['Activity']['share']) && $activity['Activity']['share']): ?>
        <?php $object_id = !empty($activity['Activity']['parent_id']) ? $activity['Activity']['parent_id'] : $activity['Activity']['id']; ?>

        <?php if ((!empty($activity['Activity']['item_type']) && !empty($activity['Activity']['params'])) ||
                $activity['Activity']['action'] == 'wall_post' || $activity['Activity']['action'] == 'wall_post_link' ||
                $activity['Activity']['action'] == 'wall_post_share' || $activity['Activity']['action'] == 'photos_add' ||
                $activity['Activity']['action'] == 'photos_add_share'): ?>
        <div class="act-item act-item-share">
            <a href="javascript:void(0);" share-url="<?php echo $this->Html->url(array('plugin' => false, 'controller' => 'share', 'action' => 'ajax_share', 'id' => $object_id), true); ?>" class="shareFeedBtn">
                <span class="act-item-symbol">
                    <span class="act-item-icon material-icons moo-icon moo-icon-share">share</span>
                </span>
                <span class="act-item-text">
                    <span class="act-item-txt"><?php echo __('Share'); ?></span>
                </span>
            </a>
        </div>
        <?php else: ?>
        <div class="act-item act-item-share">
            <a href="javascript:void(0);" share-url="<?php echo $this->Html->url(array('plugin' => false, 'controller' => 'share', 'action' => 'ajax_share', $activity['Activity']['item_type'], 'id' => $object_id, 'type' => $activity['Activity']['action']), true); ?>" class="shareFeedBtn">
                <span class="act-item-symbol">
                    <span class="act-item-icon material-icons moo-icon moo-icon-share">share</span>
                </span>
                <span class="act-item-text">
                    <span class="act-item-txt"><?php echo __('Share'); ?></span>
                </span>
            </a>
        </div>
        <?php endif; ?>

    <?php endif; ?>
<?php endif; ?>
