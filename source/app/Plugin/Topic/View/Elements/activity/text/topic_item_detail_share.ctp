<?php if (isset($activity['Activity']['parent_id']) && $activity['Activity']['parent_id']): ?>
    <?php
    $topicModel = MooCore::getInstance()->getModel('Topic_Topic');
    $topic = $topicModel->findById($activity['Activity']['parent_id']);
    
    ?>

    <?php
    echo __('shared %1$s\'s <a href="%2$s">topic</a>', $this->Moo->getName($topic['User'], false),    
                $topic['Topic']['moo_href']
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
            
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?>