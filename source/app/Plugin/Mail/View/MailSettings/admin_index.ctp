<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'),'/admin/home');
$this->Html->addCrumb(__('Mail Setting'), array('plugin' => 'mail', 'controller' => 'mail_settings', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "mail"));
$this->end();
?>

<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('Mail', __('Mail Settings'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <?php echo $this->element('admin/setting');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>