<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($, mooUser) {
        mooUser.initOnUserList();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initOnUserList();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php
echo $this->element('lists/users_list_bit');
?>

<?php if (!empty($more_result)):?>

    <?php if ( !empty($type) && $type == 'search' ): ?>
    <script> var searchParams = <?php echo (isset($params))? json_encode($params) : 'false'; ?></script>
    <?php endif; ?>
	<?php $this->Html->viewMore($more_url); ?>
<?php endif; ?>