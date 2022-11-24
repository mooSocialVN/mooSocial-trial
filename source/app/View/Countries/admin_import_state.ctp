<?php
    echo $this->Html->css(array( 'fineuploader' ));
?>
<script type="text/javascript">
    var errorHandler = function (event, id, fileName, reason) {
        console.log("id: " + id + ", fileName: " + fileName + ", reason: " + reason);
    };

   $(document).ready(function(){
        var uploader = new qq.FineUploader({
            element: $('#attachments_upload')[0],
            multiple: false,
            autoUpload: true,
            text: {
                uploadButton: '<div class="upload-section"><i class="material-icons">photo_camera</i><?php echo addslashes(__('Drag or click here to upload a CSV file'));?></div>'
            },
            validation: {
                allowedExtensions: ['csv', 'txt'],
                sizeLimit: 134217728
            },
            request: {
                endpoint: "<?php echo $this->request->base ?>" + "/admin/countries/uploads"
            },
            callbacks: {
                onError: errorHandler,
                onComplete: function (id, fileName, response) {
                    $('#filename').val(response.filename);
                }
            }
        });
        });
        
      $('#createButton').click(function(){
            if($('#filename').val() != ''){
                disableButton('createButton');
                $.post("<?php echo  $this->request->base ?>/admin/countries/getcsvstates", $("#frm_getcsv").serialize(), function (data) {
                    enableButton('createButton');
                    var json = $.parseJSON(data);

                    if (json.result == 1)
                        location.reload();
                    else
                    {
                        $(".error-message").show();
                        $(".error-message").html('<strong>Error!</strong>' + json.message);
                    }
                });
            }
            return false;
        });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Import State/Province');?></h4>
</div>
<div class="modal-body">
        <div class="form-body">
             <div id="photos_upload"></div>
                    <div id="attachments_upload"></div>                                     
                     <form id='frm_getcsv' method="post" enctype="multipart/form-data">
                        <input type="hidden" value="" id="filename" name="filename">
                        <input type="hidden" id="country_id" name="country_id" value="<?php echo $country['Country']['id'] ?>">                       
                </form>
            <div>
                <?php echo __('You can upload a text file with a list of states/provinces that you would like to import and each state/province should be on a new line.'); ?>
            </div>
        </div>
        <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal"><?php echo  __('Close') ?></button>
    <a href="#" id="createButton" class="btn btn-action"><?php echo  __('Import') ?></a>
</div>