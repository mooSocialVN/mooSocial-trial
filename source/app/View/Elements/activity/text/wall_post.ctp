<?php if ($activity['Activity']['target_id']): ?>
    <?php
    $subject = MooCore::getInstance()->getItemByType($activity['Activity']['type'], $activity['Activity']['target_id']);

    list($plugin, $name) = mooPluginSplit($activity['Activity']['type']);
    $show_subject = MooCore::getInstance()->checkShowSubjectActivity($subject);
    
    if ($show_subject):
        ?>
        &rsaquo; <?php if($name != 'User'): ?><a href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo $subject[$name]['moo_title'] ?></a><?php else: ?><?php echo $this->Moo->getName($subject[$name], false) ?><?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
