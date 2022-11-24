<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb('Site Manager');
$this->Html->addCrumb('Plugin Settings Manager', array('controller' => 'pluginsettings', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "pluginsettings"));
$this->end();
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $(document).on('loaded.bs.modal', function (e) {
Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});



jQuery(document).ready(function(){
	jQuery( ".mooTable" ).sortable( {
        items: "tr:not(.tbl_head)", 
        handle: ".reorder",
        update: function(event, ui) {
            var list = jQuery('.mooTable').sortable('toArray');
            jQuery.post('<?php echo $this->request->base?>/admin/plugins/ajax_reorder', { plugins: list });
        }
    });
	

});
<?php $this->Html->scriptEnd(); ?>

<a href="<?php echo $this->request->base?>/admin/pluginsettings/create" class="btn green btn_create_theme">
    <i class="fa fa-plus"></i> Create New Setting
</a>

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Managed Plugin Settings
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="/admin/settings">
                <?php if($settings != null):
                    foreach ($settings as $setting): ?>
                    <div class="form-group">
                        <div class="col-md-3">
                            <?php echo $setting['label'];?>
                        </div>
                        <div class="col-md-3"> 
                            <?php echo $setting['name'];?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                switch($setting['type'])
                                {
                                    case 'text':
                                        echo $this->Form->text('type', array(
                                                'value' => $setting['value'],
                                                'class' => 'form-control',
                                                'label' => false
                                            ));
                                        break;
                                    case 'textarea':
                                        echo $this->Form->textarea('type', array(
                                                'value' => $setting['value'],
                                                'class' => 'form-control',
                                                'label' => false
                                            ));
                                        break;
                                    case 'radio':
                                        $options = array();
                                        $checked = '';
                                        foreach($setting['value'] as $setting)
                                        {
                                            $options[$setting['value']] = $setting['name'];
                                            if($setting['select'] == 1)
                                            {
                                                $checked = $setting['value'];
                                            }
                                        }
                                        echo $this->Form->radio('multi.radio.', $options, array('separator' => '<br/>', 'value' => $checked));
                                        break;
                                    case 'checkbox':
                                        $options = array();
                                        $checked = '';
                                        foreach($setting['value'] as $setting)
                                        {
                                            echo $this->Form->input('multi.radio.', array(
                                                'type' => 'checkbox', 
                                                'checked' => $setting['select'],
                                                'label' => $setting['name'],
                                                'id' => 'ch'.$setting['value']
                                            ));
                                        }
                                        break;
                                    case 'select':
                                        $options = array();
                                        $selected = '';
                                        foreach($setting['value'] as $setting)
                                        {
                                            $options[$setting['value']] = $setting['name'];
                                            if($setting['select'] == 1)
                                            {
                                                $selected = $setting['value'];
                                            }
                                        }
                                        echo $this->Form->input('id', array(
                                            'options' => $options,
                                            'value' => $selected,
                                            'class' => 'form-control',
                                            'label' => false
                                        ));
                                        break;
                                }
                            ?>
                        </div>
                    </div>
                    <hr>
                <?php 
                    endforeach;
                    endif;
                ?>
            </form>
        </div>
    </div>
</div>
