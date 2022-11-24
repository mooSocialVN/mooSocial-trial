<?php if($this->request->is('ajax')): ?>
    <script type="text/javascript">
        require(["jquery","mooResponsive"], function ($, mooResponsive) {
            mooResponsive.initGridListView('#<?php echo (isset($id_div)) ? $id_div : 'GridListBar' ?>');
        });
    </script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooResponsive'), 'object' => array('$', 'mooResponsive'))); ?>
    mooResponsive.initGridListView('#<?php echo (isset($id_div)) ? $id_div : 'GridListBar' ?>');
    <?php $this->Html->scriptEnd(); ?>
<?php endif;?>

<?php
    if(isset($active_type) && (($active_type == 'grid-view') || ($active_type == 'list-view'))){

    }else{
        $active_type = 'list-view';
    }
?>
<div id="<?php echo (isset($id_div)) ? $id_div : 'GridListBar' ?>" class="grid-list-bar" data-target="<?php echo (isset($target_div)) ? $target_div : '#list-content' ?>">
    <a class="gl-item <?php echo ($active_type == 'list-view') ? 'active':'' ?>" data-type="list" href="javascript:void(0);"><span class="gl-item-icon material-icons moo-icon moo-icon-view_list">view_list</span><span class="gl-item-text"><?php echo __('List') ?></span></a>
    <a class="gl-item <?php echo ($active_type == 'grid-view') ? 'active':'' ?>" data-type="grid" href="javascript:void(0);"><span class="gl-item-icon material-icons moo-icon moo-icon-view_module">view_module</span><span class="gl-item-text"><?php echo __('Grid') ?></span></a>
</div>