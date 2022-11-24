<?php if (isset($activity['Activity']['parent_id']) && $activity['Activity']['parent_id']): ?>
    <?php
    list($plugin, $name) = mooPluginSplit($activity['Activity']['item_type']);
    $activityModel = MooCore::getInstance()->getModel('Activity');
    $parentFeed = $activityModel->findById($activity['Activity']['parent_id']);
    
    ?>
    
    <?php
    echo __('shared %1$s\'s <a href="%2$s">post</a>', $this->Moo->getName($parentFeed['User'], false),    
                $this->Html->url(array(
                    'plugin' => false,
                    'controller' => 'users',
                    'action' => 'view',
                    $parentFeed['User']['id'],
                    'activity_id' => $activity['Activity']['parent_id']
                ))
        );
    ?>
    
<?php endif; ?>

<?php echo $this->element('activity/text/wall_post', array('activity' => $activity, 'object' => $object)); ?>
