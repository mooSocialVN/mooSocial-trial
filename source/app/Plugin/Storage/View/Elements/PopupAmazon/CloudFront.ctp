<div class="modal fade in" id="portlet-mooCloudFrontActions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"> <?php echo __("Amazon CloudFront – Content Delivery Network (CDN)"); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 ">


                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <thead>
                                <tr >
                                    <th>  <?php echo __d("setting","CDN Mapping"); ?> <a data-html="true" href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __("Be sure to add the protocol in front of the domain name. For example, %s will work but %s may cause problems. Be sure to use HTTPS.",'http://my.cloudfrontcdndomain.net','my.cloudfrontcdndomain.net'); ?>" data-placement="bottom">?</a> </th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 uppercase" style="margin-bottom: 10px;">
                        <input type="email" class="form-control" id="cloudfront-cdn-mapping" placeholder="http://my.cloudfrontcdndomain.net" value="<?php echo Configure::read('Storage.storage_cloudfront_cdn_mapping'); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="cloudFront-enable"  value="1" <?php  if (Configure::read('Storage.storage_cloudfront_enable') == "1"){ echo "checked";} ?>> <?php echo __("Enable"); ?>
                        </label>
                    </div>
                </div>

                <div id="sync-cloudfont-alert" style="display: none;" class="alert alert-danger" role="alert"> <strong><?php echo __("CDN Mapping must be a URL with a valid domain"); ?></strong> </div>
            </div>
            <div class="modal-footer">
                <!-- Config -->
                <button type="button" class="sync-button btn blue ok"><?php echo __('OK'); ?></button>
                <button type="button" class="sync-button btn default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                <div id="sync-cloudfont-proccessing" style="display: none;" class="alert alert-info" role="alert">
                    <strong><?php echo __("Processing, Please Wait..."); ?></strong>
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only"> 85% Complete </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
//<script type="text/javascript">
    function isURL(str) {
        var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
            '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
        return pattern.test(str);
    }
    function mooCloudFontActions() {
        // Set title
        //$($('#portlet-mooCloudFrontActions  .modal-header .modal-title')[0]).html(mooPhrase.__('synchronise_webroot_directory'));

        // OK callback
        $('#portlet-mooCloudFrontActions .modal-footer .ok').click(function () {
            var enable = [];
            $('input[name="cloudFront-enable"]:checked').each(function(){
                enable.push(this.value);
            });

            if (isURL($('#cloudfront-cdn-mapping').val()) == true ) {

                $.ajax({
                    url: '<?php echo Router::url(array(
                        'plugin' => 'storage',
                        'controller' => 'StorageAmazon',
                        'action' => 'admin_cloudfront'))?>',
                    type: 'post',
                    dataType: 'json',
                    data: {enable: enable,url:$('#cloudfront-cdn-mapping').val()},
                    success: function (data) {
                        location.reload();
                    }
                });
                $('#sync-cloudfont-alert').hide();
                $('#sync-cloudfont-proccessing').show();
            } else {
                $('#sync-cloudfont-alert').show();

            }
        });
        $('#portlet-mooCloudFrontActions').modal('show');

    }
    $(document).ready(function () {

    });
    //</scrip>
<?php $this->Html->scriptEnd(); ?>
