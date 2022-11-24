<?php if (isset($activity['Activity']['parent_id']) && $activity['Activity']['parent_id']): ?><!-- shared feed -->
    <?php
    $albumModel = MooCore::getInstance()->getModel('Photo_Album');
    $album = $albumModel->findById($activity['Activity']['parent_id']);
    ?>
    <?php
    echo __('shared %1$s\'s <a href="%2$s">album</a>', $this->Moo->getName($album['User'], false),    
                $album['Album']['moo_href']
        );
    ?>
    
<?php endif; ?>

    
    <?php if ($activity['Activity']['target_id']): ?>
    <?php
    $subject = MooCore::getInstance()->getItemByType($activity['Activity']['type'], $activity['Activity']['target_id']);

    list($plugin, $name) = mooPluginSplit($activity['Activity']['type']);
    $show_subject = MooCore::getInstance()->checkShowSubjectActivity($subject);

    if ($show_subject):
        ?>
        &rsaquo; <a href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo $subject[$name]['moo_title'] ?></a>
    <?php else: ?>
        <?php if (!empty($activity['Activity']['parent_id'])): ?>
            <?php //echo __('to your timeline'); ?>
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?>