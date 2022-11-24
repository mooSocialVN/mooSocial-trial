<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
$this->Paginator->options(array('url' => $this->passedArgs));
$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Setup Guide'), array('controller' => 'make_guide', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "make_guide"));
$this->end();
?>
<div class="make-guide-section">
    <div class="make-guide-section-header">
        <div class="make-guide-section-header-left">
            <h3><?php echo __('Completing moosocial setup')?></h3>
            <p><?php echo __('Only a few more tasks to go. You got this!')?></p>
        </div>
    </div>
    <?php echo $this->element('admin/guide'); ?>
</div>