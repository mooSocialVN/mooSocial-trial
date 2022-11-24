<div class="comment_message">
    <?php
    echo $activity['Activity']['content'];
    ?>
</div>
<div class="activity_item">
    <?php if ($activity['Activity']['item_type']):?>
        <?php
        list($plugin, $name) = mooPluginSplit($activity['Activity']['item_type']);
        ?>
        <?php echo $this->element('activity/content/'.strtolower($name).'_create', array('activity' => $activity,'object'=>$object),array('plugin'=>$plugin));?>
    <?php endif;?>
</div>
