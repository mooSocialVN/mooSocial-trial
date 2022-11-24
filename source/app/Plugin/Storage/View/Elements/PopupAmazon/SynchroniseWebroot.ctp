<div class="modal fade in" id="portlet-mooSynWebrootActions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"> <?php echo __("Synchronise webroot directory"); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 uppercase">


                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <thead>
                                <tr class="uppercase">

                                    <th>  <?php echo __("Select types of files that you want to be included in the sync"); ?> </th>

                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 uppercase" style="margin-bottom: 10px;">
                        <input type="checkbox" name="sync"  value="img">
                        <?php echo __("Image (.jpg, .png, .ico , .gif)"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 uppercase" style="margin-bottom: 10px;">
                        <input type="checkbox" name="sync"  value="font">
                        <?php echo __("Font (.otf, .eot, .svg, .ttf, .woff)"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 uppercase" style="margin-bottom: 10px;">
                        <input type="checkbox" name="sync"  value="css">
                        <?php echo __("Cascading Style Sheets (.css)"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 uppercase" style="margin-bottom: 10px;">
                        <input type="checkbox" name="sync"  value="js">
                        <?php echo __("JavaScript (.js)"); ?>
                    </div>
                </div>
                <div id="sync-alert" style="display: none;" class="alert alert-danger" role="alert"> <strong><?php echo __("You must sync at least one type."); ?></strong> </div>
                <div class="row">
                    <div class="col-md-12 uppercase">
                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <thead>
                                <tr class="uppercase">
                                    <th>  <?php echo __("Select folders that you want to be included in the sync"); ?> </th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <div id="sync-jstree" >
                            <ul>
                                <li data-jstree='{"selected":true}' id="sync-webroot">webroot
                                    <ul>
                                        <?php
                                        $dir = new Folder(WWW_ROOT);
                                        $info = $dir->read(true,array('files', 'index.php'));
                                        if(isset($info[0])){
                                            foreach ($info[0] as $item){
                                                if($item != "uploads"){
                                                    echo '<li id="sync-webroot-'.$item.'">'.$item.'</li>';
                                                }

                                            }
                                        }
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="sync-folder-alert" style="display: none;" class="alert alert-danger" role="alert"> <strong><?php echo __("You must sync at least one folder."); ?></strong> </div>
            </div>
            <div class="modal-footer">
                <!-- Config -->
                <button type="button" class="sync-button btn blue ok"><?php echo __('OK'); ?></button>
                <button type="button" class="sync-button btn default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                <div id="sync-proccessing" style="display: none;" class="alert alert-info" role="alert">
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
    function mooSynWebrootActions() {
        // Set title
        $($('#portlet-mooSynWebrootActions  .modal-header .modal-title')[0]).html(mooPhrase.__('synchronise_webroot_directory'));

        // OK callback
        $('#portlet-mooSynWebrootActions  .modal-footer .ok').click(function () {
            var sync = [];
            $('input[name="sync"]:checked').each(function () {
                sync.push(this.value);
            });
            if (sync.length > 0 && $('#sync-jstree').jstree("get_selected").length > 0) {
                var folders = $('#sync-jstree').jstree("get_selected");
                var filter = [];
                for(i=0;i<folders.length;i++){
                    folders[i] = folders[i].replace("sync-webroot-","");

                    filter.push(folders[i]);

                }


                $.ajax({
                    url: '<?php echo Router::url(array(
                        'plugin' => 'storage',
                        'controller' => 'StorageAmazon',
                        'action' => 'admin_sync_webroot'))?>',
                    type: 'post',
                    dataType: 'json',
                    data: {sync: sync,folders:filter},
                    success: function (data) {
                        location.reload();
                    }
                });
                $('.sync-button').hide();
                $('#sync-alert').hide();
                $('#sync-proccessing').show();
            } else {
                if(sync.length == 0){
                    $('#sync-alert').show();
                }else{
                    $('#sync-alert').hide();
                }
                if($('#sync-jstree').jstree("get_selected").length == 0){
                    $('#sync-folder-alert').show();
                }else{
                    $('#sync-folder-alert').hide();
                }
            }
        });
        $('#portlet-mooSynWebrootActions').modal('show');

    }
    $(document).ready(function () {
        $('#sync-jstree').jstree({
            'core': {
                'expand_selected_onload':false,
            },
            "checkbox" : {
                "keep_selected_style" : false
            },
            "plugins" : [ "wholerow", "checkbox" ]
        });
    });
    //</scrip>
<?php $this->Html->scriptEnd(); ?>
