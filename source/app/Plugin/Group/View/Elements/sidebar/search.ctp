<div id="filters" style="margin-top:5px">
    <?php if (!Configure::read('core.guest_search') && empty($uid)): ?>
    <?php else: ?>
        <?php echo $this->Form->text('keyword', array('placeholder' => __('Enter keyword to search'), 'rel' => 'groups', 'class' => 'json-view')); ?>
    <?php endif; ?>
</div>