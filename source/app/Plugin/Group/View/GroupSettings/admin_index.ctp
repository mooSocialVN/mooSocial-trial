<?php
$this->Html->addCrumb(__('Plugins Manager'), '/admin/plugins');
$this->Html->addCrumb(__('Group Setting'), array('controller' => 'group_settings', 'action' => 'admin_index'));
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array('cmenu' => 'Group'));
$this->end();
?>
<?php echo  $this->Moo->renderMenu('Group', __('Settings')); ?>

<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <?php echo  $this->element('admin/setting'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>