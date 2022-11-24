<?php
echo $this->Html->script(array('admin/jquery.fileuploader'), array('inline' => false));
echo $this->Html->css(array( 'fineuploader' ), array('inline' => false));

echo $this->Html->script(array('tinymce/tinymce.min'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Bulk Mail'), array('controller' => 'tools', 'action' => 'admin_bulkmail'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "bulkmail"));
$this->end();
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>

        
$(document).ready(function(){
    $('#send_button').click(function(){		
        $('#editor').val(tinyMCE.activeEditor.getContent());
        disableButton('createButton');
        $.post("<?php echo $this->request->base?>/admin/tools/ajax_bulkmail_start", $("#createForm").serialize(), function(data){
            enableButton('send_buttonsend_button');

            if (data != '') {
                $(".error-message").show();
                $(".error-message").html(data);
            } else {
                mooConfirmSendMail('<?php echo addslashes(__('Are you sure you want to proceed sending emails?'));?>', '<?php echo $this->request->base?>/admin/tools/ajax_bulkmail_send',
                    '<?php echo addslashes(__("Emails are adding into temp place in system for sending. It will not take more than one minute. Please don't close the browser or go to other page until go get the confirm message from system."));?>' );
            }
        });
    });
    
    tinymce.init({
        selector: "textarea",
        language : mooConfig.tinyMCE_language,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "template paste textcolor"
        ],
        toolbar1: "styleselect | bold italic | bullist numlist outdent indent | forecolor backcolor emoticons | link unlink anchor image | preview fullscreen code",
        image_advtab: true,
        image_dimensions: false,
        height: 500,
        relative_urls : false,
        remove_script_host : false,
        document_base_url : '<?php echo FULL_BASE_URL . $this->request->root?>'
    });


});


function sendTestEmail()
{
	disableButton('send_test_button');
	$('#editor').val(tinyMCE.activeEditor.getContent());        
	$.post("<?php echo $this->request->base?>/admin/tools/ajax_bulkmail_test", $("#createForm").serialize(), function(data){
		enableButton('send_test_button');
		if (data != '') {
			$(".error-message").show();
			$(".error-message").html(data);
		} else {
                   $.fn.SimpleModal({
                        model: 'modal',
                        title: '<?php echo addslashes(__('Message'));?>',
                        btn_ok: '<?php echo addslashes(__('OK'));?>',
                        hideFooter: false, 
                        closeButton: true,
                        contents: '<?php echo addslashes(__('An email has been sent to'));?> <?php echo $cuser['email'];?>'
                    }).showModal();
		}
	});
}

function sendEmails()
{
	$('#editor').val(tinyMCE.activeEditor.getContent());
	$.fn.SimpleModal({
        btn_ok: 'OK',
        model: 'confirm',
        callback: function(){
            disableButton('send_button'); 
            $.post("<?php echo $this->request->base?>/admin/tools/ajax_bulkmail_start", $("#createForm").serialize(), function(data){
                enableButton('send_button'); 
                if (data != '') {
                    $(".error-message").show();
                    $(".error-message").html(data);
                } else {       
                    $.fn.SimpleModal({
                        model: 'modal',
                        title: '<?php echo addslashes(__('Adding emails to temp place for sending.....'))?>',
                        contents: '<?php echo addslashes(__("Emails are adding into temp place in system for sending. It will not take more than one minute. Please don't close the browser or go to other page until go get the confirm message from system.<br/>Warning message when finished: <br/>All emails are added into temp place. Email sending is started running. It will take a few hours to finish. You can close web browser or go to other page now."));?><br /><br /><iframe frameborder="0" width="100%" height="200" src="<?php echo $this->request->base?>/admin/tools/ajax_bulkmail_send"></iframe>'
                    }).showModal();
                }
            });
        },
        title: '<?php echo addslashes(__('Please Confirm'));?>',
        contents: '<?php echo addslashes(__('Are you sure you want to proceed sending emails?'));?>',
        hideFooter: false, 
        closeButton: true
    }).showModal();
}

<?php $this->Html->scriptEnd(); ?>




    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form class="form-horizontal" id="createForm" method="post" action="<?php echo $this->request->base?>/admin/users/ajax_bulkmail_send/1" target="sending">
			<div class="alert alert-info"><?php echo __('Using this form, you will be able to send an email out to all of your members. Emails are sent out using a queue system, so they will be sent out over time. An email will be sent to you when all emails have been sent.');?></div>

            <div>
                <a href="<?php echo $this->request->base; ?>/tools/delete_old_file"><?php echo __('Delete uploaded old files'); ?></a>
            </div>

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo  __('Mail Subject'); ?></label>
                    <div class="col-md-9">
                        <?php echo $this->Form->text('subject',array('placeholder'=>__('Enter text'),'class'=>'form-control ')); ?>

														<span class="help-block">
														<?php echo  __('A block of help text.');?> </span>
                    </div>
                </div>
                <div style="display:none;" class="form-group">
                    <label class="col-md-3 control-label"><?php echo  __('Emails Cycle');?></label>
                    <div class="col-md-9">
                        <?php echo $this->Form->text('cycle',array('value'=>1000,'placeholder'=>__('Enter text'),'class'=>'form-control ')); ?>

                        <span class="help-block"><?php echo  __('Enter number of emails per cycle.');?><br /><?php echo  __("Please check your host's email limit");?> </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo  __('Mail Body');?></label>
                    <div class="col-md-9">
                        <?php echo $this->Form->textarea('body', array('id' => 'editor')); ?>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp;</label>
                    <div class="col-md-9">
                     
                        <div class="toggle_image_wrap">
                            <a href="javascript:void(0)" class="load-file"><?php  echo __('Upload files') ?></a>                                                
                        </div>

                        <div style="display: none;" class="document_file_upload" id="document_file_upload"></div>
                        <input type="hidden" name="document_file" id="document_file">
                        <input type="hidden" name="original_filename" id="original_filename">



                    </div>
                </div>

            </div>
        </form>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-circle btn-action" type="submit" data-toggle="modal" data-target="#myModal"  id="send_button"><?php echo  __('Send Emails');?></button>


                        <button class="btn btn-circle default" type="button" onclick="sendTestEmail()" id="send_test_button" ><?php echo  __('Send Test Email');?></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <div class="alert alert-danger error-message" style="display:none;margin-top:10px"></div>
                    </div>
                </div>
            </div>

        <!-- END FORM-->
    </div>





<?php $this->Html->scriptStart(array('inline' => false)); ?>
            var errorHandler = function(event, id, fileName, reason) {
            if ($('.qq-upload-list .errorUploadMsg').length > 0){
            $('.qq-upload-list .errorUploadMsg').html('<?php echo __d('announcement','Can not upload file more than ') . $file_max_upload?>');
            }else {
            $('.qq-upload-list').prepend('<div class="errorUploadMsg"><?php echo __d('announcement','Can not upload file more than ') . $file_max_upload?></div>');
            }
            $('.qq-upload-fail').remove();
            };

             var uploader1 = new qq.FineUploader({
                element: $('#document_file_upload')[0],
                multiple: true,
                text: {
                    uploadButton: '<div class="upload-section icon_upload"><i class="material-icons">photo_camera</i>'+'Upload'+'</div>'
                },
                validation: {
                   // allowedExtensions:  params.split(','),
                   // sizeLimit: mooConfig.sizeLimit
                },
                request: {
                    endpoint: "<?php echo $this->request->base?>/tools/uploadfile"
                },
                callbacks: {
                    onError: errorHandler,
                    onComplete: function(id, fileName, response) {
                        if (jQuery.isEmptyObject(response))
                        {    
                            return;
                        }

                        if(response.error){
                            alert(response.error);
                        }

                        file = jQuery(this.getItemByFileId(id));                    
                        element_delete = $('<a name_file= "'+response.document_file+'" href="javascript:void(0);">'+'Delete'+'<a/>');
                        file.find('.qq-upload-status-text').append(element_delete);
                       
                        $(".document_file_upload").show();
                        $('.document_file_upload .qq-upload-button').hide();
                        $('.document_file_upload .errorUploadMsg').hide();
                        
                        
                        
                        element_delete.click(function(event){ 
                        event.preventDefault();
                        $(this).parents('li').remove();
                        value_delete = $(this).attr('name_file');
                        URL_delete = '<?php echo $this->request->base?>' + '/tools/delete_file/' + value_delete;

                            $.post(URL_delete, function(data){
                            });
                            $('#document_file').val($('#document_file').val().replace(response.document_file + ',',''));
                            $('#original_filename').val($('#original_filename').val().replace(response.original_filename + ',',''));
                           
                        });

                        var document_file_name = $('#document_file').val();
                        $('#document_file').val(document_file_name + response.document_file + ',');

                        var original_file_name = $('#original_filename').val();
                        $('#original_filename').val(original_file_name+ response.original_filename + ',');
                    }
                }
            });


    $('.load-file').click(function(){
            $(".document_file_upload :input").click();
        });       
    function toggleField()
    {
    $('.opt_field').toggle();
    }

    
<?php $this->Html->scriptEnd(); ?>






