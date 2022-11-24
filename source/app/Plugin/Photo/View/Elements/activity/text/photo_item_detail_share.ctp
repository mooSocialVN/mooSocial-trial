<?php if (isset($activity['Activity']['parent_id']) && $activity['Activity']['parent_id']): ?>
    <?php
    $photoModel = MooCore::getInstance()->getModel('Photo_Photo');
    $photo = $photoModel->findById($activity['Activity']['parent_id']);
    
    ?>

    <?php
    echo __('shared %1$s\'s <a href="%2$s">photo</a>', $this->Moo->getName($photo['User'], false),    
                $photo['Photo']['moo_href']
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
        &rsaquo; <a href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo ($subject[$name]['moo_title']) ?></a>
    <?php else: ?>
        <?php if (!empty($activity['Activity']['parent_id'])): ?>
            
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?>