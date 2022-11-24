<div class="hidden" id="remove-hidden-after-loading">
    <?php

    echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
    echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
    $this->Html->addCrumb(__d("setting",'Storage System'), null);
    $url = Router::url(array(
        'plugin'=>'storage',
        'controller' => 'storages',
        'action' => 'admin_index'),true);
    $this->Html->addCrumb(__('Manage Storage Services'), $url);
    $this->Html->addCrumb(__('Amazon S3'), null);
    $this->startIfEmpty('sidebar-menu');
    echo $this->element('admin/adminnav', array('cmenu' => 'storage'));
    $this->end();
    ?>
    <?php echo $this->Moo->renderMenu('Storage', __('Settings'));?>
    <div class="portlet-body form">
        <div class=" portlet-tabs">
            <div class="tabbable tabbable-custom boxless tabbable-reversed">
                <?php if($isPost): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-wizard">
                            <div class="form-body">
                                <ul class="nav nav-pills nav-justified steps">
                                    <li >
                                        <a href="#tab1"  class="step" >
                                            <span class="number"> 1 </span>
                                            <span class="desc">
                                                                    <i class="fa fa-check"></i> <?php echo __('PHP Compatibility Test'); ?> </span>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="#tab2"  class="step" aria-expanded="true">
                                            <span class="number"> 2 </span>
                                            <span class="desc">
                                                                    <i class="fa fa-check"></i> <?php echo __('Amazon S3 Account Setup'); ?> </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab3"  class="step active">
                                            <span class="number"> 3 </span>
                                            <span class="desc">
                                                                    <i class="fa fa-check"></i> <?php echo __('Amazon S3 API Test'); ?> </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab4"  class="step">
                                            <span class="number"> 4 </span>
                                            <span class="desc">
                                                                    <i class="fa fa-check"></i> <?php echo __('Confirm'); ?> </span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="bar" class="progress progress-striped" role="progressbar">
                                    <div class="progress-bar progress-bar-success" style="width: 50%;"> </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <?php endif; ?>
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
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$( document ).ready(function() {
    $(".tab-2 >a").text("<?php echo __('Amazon S3'); ?>");
    $("#remove-hidden-after-loading").removeClass("hidden");
    // support for special option : storage_amazon_delete_image_after_adding
    var idDeleteImgOption = <?php echo $deleteImgOptionId; ?>; console.log(idDeleteImgOption);
    $('#ch'+idDeleteImgOption+'1').closest('div[class^="col-md-7"]').append("<div style='color:red;margin:8px 5px 5px 5px;'><?php echo __('Warning: This option will delete uploaded contents from local filesystem (%s) once they have been copied to S3. You will have to manually restore these contents to local filesystem if you disable S3 storage.',addslashes(WWW_ROOT.'upload')) ?></>");
    // end support
});
<?php $this->Html->scriptEnd(); ?>