<?php if ($activity['Activity']['target_id']): ?>
    <?php
    
    $subject = MooCore::getInstance()->getItemByType($activity['Activity']['type'], $activity['Activity']['target_id']);
    $show_subject = MooCore::getInstance()->checkShowSubjectActivity($subject);
    $name = key($subject);
    ?>
    <?php if ($show_subject): ?>
        &rsaquo; <a href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo ($subject[$name]['moo_title']) ?></a>
    <?php else: ?>

        <?php $number = count(explode(',', $activity['Activity']['items'])); ?>
        <?php
        if ($number > 1) {
            echo __('added %s new photos', $number);
        } else {
            echo __('added %s new photo', $number);
        }
        ?>
    <?php endif; ?>
<?php else: ?>
    <?php list($plugin, $name) = mooPluginSplit($activity['Activity']['item_type']); ?>
    <?php if ($object): ?>		
        <?php $number = count(explode(',', $activity['Activity']['items'])); ?>
        <?php
        if ($number > 1) {
            echo __('added %s new photos to album', $number);
        } else {
            echo __('added %s new photo to album', $number);
        }
        ?> <a href="<?php echo $object[$name]['moo_href']; ?>"><?php echo ($object[$name]['moo_title']) ?></a>
    <?php endif; ?>
<?php endif; ?>