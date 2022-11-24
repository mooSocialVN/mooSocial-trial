<div class="hidden" id="remove-hidden-after-loading">
<?php
    echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
    echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
    $this->Html->addCrumb(__d("setting",'Storage System'), null);

    $this->Html->addCrumb(__('Manage Storage Services'), '/admin/storage/storages');
    $this->startIfEmpty('sidebar-menu');
    echo $this->element('admin/adminnav', array('cmenu' => 'storage'));
    $this->end();
    $this->addPhraseJs(array(
        "synchronise_webroot_directory"=>__("Synchronise webroot directory"),
    ));
?>
<?php echo $this->Moo->renderMenu('Storage', __('Manage Storage Services'));?>

    <div class="row">
        <div class="col-md-12" style="padding-top: 5px;">
            <div class="note note-info">
                <p>
                    <?php echo __("View and manage storage system services. The storage system is used to handle file uploads for your site. You can configure this to use Amazon's S3  service.");?>
                </p>
                <p>
                <ul>
                    <li>
                        <?php echo __('Requires cronjob with Amazon S3:')?> "*/5 * * * * cd <?php echo APP;?> & Console/cake Storage.cron start >/dev/null 2>&1"
                    </li>
                </ul>
                </p>
                <p style="color: #3052e0;font-weight: bold;"><?php echo __("Curent storage: %s",$this->Storage->getName(Configure::read('Storage.storage_current_type'))); ?> </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="padding-top: 5px;">
            <div class="panel-group accordion" id="accordion1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                               href="#collapse_1" aria-expanded="false"> <?php echo __( "Local Storage"); ?> </a>
                        </h4>
                    </div>
                    <div id="collapse_1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-hover table-light">
                                    <thead>
                                    <tr class="uppercase">
                                        <th> <?php echo __( "Status"); ?> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <td>
                                            <span
                                                class="label label-sm label-success"> <?php echo $this->Storage->getStatus("local"); ?> </span>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>
                            <a href="javascript:void(0)"
                               onclick="mooConfirm('<?php echo addslashes(__( 'Are you sure you want to enable this service?')) ?>', '<?php echo Router::url(array(
                                   'plugin' => 'storage',
                                   'controller' => 'StorageLocal',
                                   'action' => 'admin_confirm_enable')) ?>')" class="btn btn-circle btn-default"
                               style="background-color: #3052e0;color:#fff;">
                                <?php echo __( "Enable this service"); ?> </a>
                            <a href="javascript:void(0)" onclick="mooLocalCdnActions()"
                               class="btn btn-circle btn-default">
                                <i class="fa fa-cloud"></i> <?php echo __( "Content Delivery Network (CDN)"); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                    $dir = new Folder(APP_PATH."Plugin".DS."Storage".DS."View".DS."Elements".DS."PluginAdmin");
                    $files = $dir->find('.*\.ctp');
                    foreach($files as $file){
                        $name = rtrim($file,".ctp");
                        echo $this->element("Storage.PluginAdmin/".$name);
                    }

                ?>
            </div>
        </div>

    </div>

</div>
<?php echo $this->element("Storage.PopupAmazon/LocalCdn"); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $(document).ready(function () {
        $(".tab-2").hide();
        $("#remove-hidden-after-loading").removeClass("hidden");
    });
<?php $this->Html->scriptEnd(); ?>


