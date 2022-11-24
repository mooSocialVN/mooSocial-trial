<?php
echo $this->Html->script(array('admin/jquery.fileuploader'), array('inline' => false));
echo $this->Html->css(array( 'fineuploader' ), array('inline' => false));

$this->Html->addCrumb(__('Plugins Manager'), array('controller' => 'plugins', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "addon_upload"));
$this->end();

?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
var errorHandler = function(event, id, fileName, reason) {
            if ($('.qq-upload-list .errorUploadMsg').length > 0){
            $('.qq-upload-list .errorUploadMsg').html('<?php echo __('Can not upload file more than ') . $file_max_upload?>');
            }else {
            $('.qq-upload-list').prepend('<div class="errorUploadMsg"><?php echo __('Can not upload file more than ') . $file_max_upload?></div>');
            }
            $('.qq-upload-fail').remove();
            };
var extractFile = function(element,type)
{
    $.post("<?php echo $this->request->base?>/admin/addon_upload/extract", {'document_file' : element.find('.document_file').val(),'type':type}, function(data){            
        data = JSON.parse(data);
        if (data.status)
        {
            if (type == 'plugin')
            {
                $.post("<?php echo $this->request->base?>/admin/plugins/extract/" + data.name, function(data){ 
                    data = JSON.parse(data);
                    if (data.status)
                    {
                        window.location.search += "#portlet_plugin"
                        window.location.reload();
                    }
                    else
                    {
                        element.find('.error_content').html(data.message);
                        element.find('.error_content').show();
                    }
                });
            }

            if (type == 'theme')
            {
                var plugin = '';

                if (data.name == 'mootube')
                {
                    plugin = 'MooTube';
                }

                if (data.name == 'mooX1')
                {
                    plugin = 'MooX1';
                }

                if (data.name == 'moorallyup')
                {
                    plugin = 'Moorallyup';
                }

                if (plugin != '')
                {
                    $.post("<?php echo $this->request->base?>/admin/plugins/extract/" + plugin, function(data){ 
                        data = JSON.parse(data);
                        if (data.status)
                        {
                            $.post("<?php echo $this->request->base?>/admin/themes/extract/" + data.name, function(data){ 
                                data = JSON.parse(data);
                                if (data.status)
                                {
                                    window.location.search += "#portlet_theme"
                                    window.location.reload();
                                }
                                else
                                {
                                    element.find('.error_content').html(data.message);
                                    element.find('.error_content').show();
                                }
                            });
                        }
                        else
                        {
                            element.find('.error_content').html(data.message);
                            element.find('.error_content').show();
                        }
                    });
                }
                else
                {
                    $.post("<?php echo $this->request->base?>/admin/themes/extract/" + data.name, function(data){ 
                        data = JSON.parse(data);
                        if (data.status)
                        {
                            window.location.search += "#portlet_theme"
                            window.location.reload();
                        }
                        else
                        {
                            element.find('.error_content').html(data.message);
                            element.find('.error_content').show();
                        }
                    });
                }
            }

            if (type == 'path')
            {
                window.location.search += "#portlet_path"
                window.location.reload();
            }
        }
        else
        {
            element.find('.error_content').html(data.message);
            element.find('.error_content').show();
        }        
    });
}
$('.upload_content').each(function(e){
        var element = $(this);
        var type = $(this).data('type');
            var uploader1 = new qq.FineUploader({
            element: $(this).find('.document_file_upload')[0],
            multiple: false,
            text: {
                uploadButton: '<div class="upload-section icon_upload"><i class="material-icons">photo_camera</i>'+'Upload'+'</div>'
            },
            validation: {
                allowedExtensions:  ['zip'],
                sizeLimit: mooConfig.sizeLimit
            },
            request: {
                endpoint: "<?php echo $this->request->base?>/admin/addon_upload/upload?type=" + type
            },
            'messages' : {
                'typeError' : '<?php echo __('{file} has an invalid extension. Valid extension(s): {extensions}.');?>',
                'sizeError': '<?php echo __('{file} is too large, maximum file size is {sizeLimit}.');?>',
            },
            callbacks: {
                onError: errorHandler,
                onComplete: function(id, fileName, response) {
                    element.find('.error_content').hide();
                    if (jQuery.isEmptyObject(response))
                    {    
                        return;
                    }

                    if(response.error){
                        alert(response.error);
                    }

                    file = jQuery(this.getItemByFileId(id));                    
                    element_delete = $('<a name_file= "'+response.document_file+'" href="javascript:void(0);">'+'<?php echo __('Delete'); ?>'+'<a/>');
                    file.find('.qq-upload-status-text').append(element_delete);
                    
                    element.find(".document_file_upload").show();
                    element.find('.document_file_upload .qq-upload-button').hide();
                    element.find('.document_file_upload .errorUploadMsg').hide();
                    
                    
                    
                    element_delete.click(function(event){ 
                    event.preventDefault();
                    $(this).parents('li').remove();
                        element.find('.document_file').val('');
                        element.find('.load-file').show();
                        element.find('.extract_content').hide();
                    });

                    element.find('.document_file').val(response.document_file);
                    element.find('.load-file').hide();
                    element.find('.extract_content').show();
                    if (type == 'plugin')
                    {
                        element.find('.check_plugin').val(response.check_plugin);
                    }
                }
            }
        });


        element.find('.load-file').click(function(){
            element.find(".document_file_upload :input").click();
        });

        

        element.find('.extract_action').click(function(){
            if (type == 'plugin')
            {
                if (element.find('.check_plugin').val() == "1")
                {
                    if (confirm("<?php echo __('Do you want to upgrade the plugin now? All custom changes if any that related to the plugin will be overwritten.'); ?>") == true) {
                        extractFile(element,type);
                    }
                }
                else
                {
                    extractFile(element,type);
                }
            }
            else
            {
                extractFile(element,type);
            }
        });
});

<?php $this->Html->scriptEnd(); ?>

<div class="portlet-body">
    <div class=" portlet-tabs">
        <?php if (!$checkZip): ?>
            <div class="alert alert-danger">
                <?php echo __('Please enalbe PHP Zip Extension');?>
            </div>
        <?php else :?>
            <?php if (!$checkPermission): ?>
                <div class="alert alert-danger">
                    <?php echo __('Please change permission writable for below directories. Contract your hosting provider of you don’t know how to do that. %s','<br>'.implode('<br/>',$folders));?>
                </div>                  
            <?php endif; ?>
        <?php endif;?>
        <?php if ($checkZip && $checkPermission):?>
            <div class="alert alert-info" style="padding-bottom: 10px;">
                <div><?php echo __('Please download the package that you want to install at client area. Click on "Upload package" link below to select one package from your computer to upload. You only can upload ONE package to install each time.');?></div>
                <br>
                <div><?php echo __('IMPORTANCE:');?></div>
                <br>
                <div>
                    <?php echo __('1. The package will auto install after the "Install Now" button is clicked');?>
                </div>
                <div>
                    <?php echo __('2. If the package has been installed, system will check to see the uploaded package is new version or NOT. If yes, it will auto upgrade. Be careful if your plugin OR Template has been customized. All changes will be overwritten');?>
                </div>
                <div>
                    <?php echo __('3. If the package requires to install Patch, please unzip the installation package, read installation guide to know where the patch file is, Upload it at "Upload Path" tab after plugin is installed.');?>
                </div>
                <div>
                    <?php echo __('4. For template, please upload and install at "Upload Theme" tab.') ?>
                </div>
            </div>
            <div class="tabbable tabbable-custom boxless tabbable-reversed">
                <ul class="nav nav-tabs list7 chart-tabs">
                    <li class="active">
                        <a href="#portlet_plugin" data-toggle="tab">
                            <?php echo __('Upload Plugin');?> </a>
                    </li>
                    <li>
                        <a href="#portlet_theme" data-toggle="tab">
                            <?php echo __('Upload Theme');?> </a>
                    </li>
                    <li>
                        <a href="#portlet_path" data-toggle="tab">
                            <?php echo __('Upload Path');?> </a>
                    </li>
                </ul>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_plugin">
                                <form id="upload_plugin" class="upload_content" data-type="plugin">
                                    <div class="toggle_image_wrap">
                                        <a href="javascript:void(0)" data-type="upload_plugin" class="load-file"><?php  echo __('Upload Package') ?></a>              
                                        <div style="display: none;" class="document_file_upload"></div>    
                                        <input type="hidden" name="document_file" class="document_file">       
                                        <input type="hidden" name="check_plugin" class="check_plugin">
                                    </div>
                                    <div class="extract_content" style="display:none">
                                        <div style="display: none;" class="error_content alert alert-danger">
                                            <?php echo __('Package verification failed');?>
                                        </div>
                                        <div>
                                            <a class="extract_action" href="javascript:void(0);"><?php echo __('Install now'); ?></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="portlet_theme">
                                <form id="upload_theme" class="upload_content" data-type="theme">
                                    <div class="toggle_image_wrap">
                                        <a href="javascript:void(0)" data-type="upload_plugin" class="load-file"><?php  echo __('Upload Package') ?></a>              
                                        <div style="display: none;" class="document_file_upload"></div>                
                                        <input type="hidden" name="document_file" class="document_file">       
                                    </div>
                                    <div class="extract_content" style="display:none">
                                        <div style="display: none;" class="error_content alert alert-danger">
                                            <?php echo __('Package verification failed');?>
                                        </div>
                                        <div>
                                            <a class="extract_action" href="javascript:void(0);"><?php echo __('Install now'); ?></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="portlet_path">  
                                <form id="upload_theme" class="upload_content" data-type="path">
                                    <div class="toggle_image_wrap">
                                        <a href="javascript:void(0)" data-type="upload_plugin" class="load-file"><?php  echo __('Upload Package') ?></a>              
                                        <div style="display: none;" class="document_file_upload"></div>                
                                        <input type="hidden" name="document_file" class="document_file">       
                                    </div>
                                    <div class="extract_content" style="display:none">
                                        <div style="display: none;" class="error_content alert alert-danger">
                                            <?php echo __('Package verification failed');?>
                                        </div>
                                        <div>
                                            <a class="extract_action" href="javascript:void(0);"><?php echo __('Install now'); ?></a>
                                        </div>
                                    </div>
                                </form>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

