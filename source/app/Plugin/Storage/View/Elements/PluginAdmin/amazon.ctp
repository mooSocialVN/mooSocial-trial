<?php
echo $this->Html->css(array('/storage/css/jstree/themes/default/style.min.css'), null, array('inline' => false));
echo $this->Html->script(array('/storage/js/jstree/jstree.min.js'), array('inline' => false));
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a id="storage-amazon-section" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
               href="#collapse_2" aria-expanded="false"> <?php echo __("Amazon S3"); ?></a>
        </h4>
    </div>
    <div id="collapse_2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
        <div class="panel-body" style="overflow-y:auto;">
            <div class="table-scrollable table-scrollable-borderless">
                <table class="table table-hover table-light">
                    <thead>
                    <tr class="uppercase">

                        <th> <?php echo __("Files"); ?> </th>
                        <th> <?php echo __("Storage Used"); ?> </th>
                        <th> <?php echo __("Status"); ?> </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <td> <?php echo $this->Storage->getS3TotalItem(); ?> </td>
                        <td><?php echo $this->Storage->getS3TotalSize(); ?> </td>

                        <td>
                                            <span
                                                class="label label-sm label-info"> <?php echo $this->Storage->getStatus("amazon"); ?> </span>
                        </td>
                    </tr>


                    </tbody>
                </table>
            </div>
            <dl>
                <?php
                $s3AccessKey = (Configure::read('Storage.storage_amazon_access_key') !== "") ? Configure::read('Storage.storage_amazon_access_key') : __("The Access Key ID is empty.You need to configure it.");
                $s3SecretKey = (Configure::read('Storage.storage_amazon_secret_key') !== "") ? Configure::read('Storage.storage_amazon_secret_key') : __("The Secret Access Key is empty.You need to configure it.");
                $s3BucketName = (Configure::read('Storage.storage_amazon_bucket_name') !== "") ? Configure::read('Storage.storage_amazon_bucket_name') : __("The Bucket Name is empty.You need to configure it.");
                $s3Region = $this->Storage->getS3Region(Configure::read('Storage.storage_amazon_s3_region'));
                $s3Cname = (Configure::read('Storage.storage_amazon_use_cname') == "1") ? __("Enabled") : __("Disable");
                $s3Header = Configure::read('Storage.storage_amazon_cache_control_header');
                $s3Https = (Configure::read('Storage.storage_amazon_server_file_vi_https') == "1") ? __("Enabled") : __("Disable");
                $s3StatusTransfer = $this->Storage->getS3StatusTransfer();
                $s3ImageSyncing = $this->Storage->getS3Syncing('img');
                $s3FontSyncing = $this->Storage->getS3Syncing('font');
                $s3CssSyncing = $this->Storage->getS3Syncing('css');
                $s3JsSyncing = $this->Storage->getS3Syncing('js');

                ?>
                <dt><?php echo __d("setting", "Access Key ID"); ?></dt>
                <dd><?php echo $s3AccessKey; ?></dd>
                <dt><?php echo __d("setting", "Secret Access Key"); ?></dt>
                <dd><?php echo $s3SecretKey; ?></dd>
                <dt><?php echo __d("setting", "Bucket Name"); ?></dt>
                <dd><?php echo $s3BucketName; ?></dd>
                <dt><?php echo __d("setting", "Region"); ?></dt>
                <dd><?php echo $s3Region; ?></dd>
                <dt><?php echo __d("setting", "Use a CNAME"); ?></dt>
                <dd><?php echo $s3Cname; ?></dd>
                <?php if ($s3Header != ""): ?>
                    <dt><?php echo __("Object Cache-Control Header"); ?></dt>
                    <dd><?php echo $s3Header; ?></dd>
                <?php endif; ?>
                <dt><?php echo __d("setting", "Always serve files from Amazon S3 via HTTPS"); ?></dt>
                <dd><?php echo $s3Https; ?></dd>
                <dt><?php echo __("Files Transfer Status"); ?></dt>
                <dd><?php echo $s3StatusTransfer; ?></dd>
                <dt><?php echo __("Sync in progress"); ?></dt>
                <dd><?php echo __("Image :"). " ".__n("%s file",'%s files',$s3ImageSyncing,$s3ImageSyncing); ?></dd>
                <dd><?php echo __("Font :"). " ".__n("%s file",'%s files',$s3FontSyncing,$s3FontSyncing); ?></dd>
                <dd><?php echo __("Cascading Style Sheets :"). " ".__n("%s file",'%s files',$s3CssSyncing,$s3CssSyncing); ?></dd>
                <dd><?php echo __("JavaScript :"). " ".__n("%s file",'%s files',$s3JsSyncing,$s3JsSyncing); ?></dd>

            </dl>
            <?php if(version_compare(phpversion(), '5.5.0', '>=')):?>

            <a href="<?php echo Router::url(array(
                'plugin' => 'storage',
                'controller' => 'StorageAmazon',
                'action' => 'admin_confirm_enable')) ?>" class="btn btn-circle btn-default"
               style="background-color: #3052e0;color:#fff;">
                <?php echo __("Enable this service"); ?> </a>
            <a href="<?php echo Router::url(array(
                'plugin' => 'storage',
                'controller' => 'StorageAmazon',
                'action' => 'admin_edit')) ?>" class="btn btn-circle btn-default">
                <i class="fa fa-magic"></i> <?php echo __("Edit"); ?> </a>
            <?php if (Configure::read('Storage.storage_current_type') == 'amazon'): ?>
                <?php if ($this->Storage->getS3StatusTransfer(true) != 1): ?>
                    <a href="javascript:void(0)"
                       onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to transfer stored files from local service to this storage service?')) ?>', '<?php echo Router::url(array(
                           'plugin' => 'storage',
                           'controller' => 'StorageAmazon',
                           'action' => 'admin_transfer')) ?>')" class="btn btn-circle btn-default">
                        <i class="fa fa-truck fa-flip-horizontal"></i> <?php echo __("Transfer"); ?>
                    </a>
                <?php endif; ?>
                <a href="javascript:void(0)"
                   onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to clear and refresh caches?')) ?>', '<?php echo Router::url(array(
                       'plugin' => 'storage',
                       'controller' => 'StorageAmazon',
                       'action' => 'admin_clear_caches')) ?>')" class="btn btn-circle btn-default">
                    <i class="fa fa-trash-o"></i> <?php echo __("Clear and Refresh Caches"); ?> </a>
                <a href="javascript:void(0)" onclick="mooSynWebrootActions()"
                   class="btn btn-circle btn-default">
                    <i class="fa fa-refresh"></i> <?php echo __("Synchronise webroot directory"); ?>
                </a>
                <a href="javascript:void(0)" onclick="mooCloudFontActions()"
                   class="btn btn-circle btn-default">
                    <i class="fa fa-cloud"></i> <?php echo __("CloudFront (CDN)"); ?>
                </a>
            <?php endif; ?>

            <a href="<?php echo Router::url(array(
                'plugin' => 'storage',
                'controller' => 'StorageAmazon',
                'action' => 'admin_help')) ?>"  class="btn btn-circle btn-default">
                <i class="fa fa-question-circle"></i> <?php echo __("Help"); ?>  </a>
            <?php else:?>
                <?php echo __("The minimum PHP version required to enable this service is 5.5.0 . Your server is currently running PHP %s , you need to upgrade to PHP 5.5.0 or higher to enable it.",phpversion()); ?>
            <?php endif;?>
        </div>
    </div>

</div>

<?php echo $this->element("Storage.PopupAmazon/SynchroniseWebroot"); ?>
<?php echo $this->element("Storage.PopupAmazon/CloudFront"); ?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
//<script type="text/javascript">
    $(document).ready(function () {
        <?php if(Configure::read('Storage.storage_current_type') == 'amazon'){
           echo "$('#storage-amazon-section').click();";
        } ?>
    });
    //</scrip>
<?php $this->Html->scriptEnd(); ?>


