

<?php
$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Languages Manager'), array('controller' => 'languages', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "languages"));
$this->end();

echo $this->Html->script(array('admin/jquery.fileuploader'), array('inline' => false));
echo $this->Html->css(array( 'fineuploader' ), array('inline' => false));
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('loaded.bs.modal', function (e) {
    Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
mooPhrase.add('fineupload_failupload','<?php echo __('Upload failed because the name of this file does not match with any extsting language file') ?>');
<?php $this->Html->scriptEnd(); ?>
<style type="text/css">
    .tabbable-custom > .nav-tabs {
        border-bottom: 1px solid #DDDDDD;
    }
</style>
<div>
	<h2><?php echo $language['Language']['name']?></h2>
</div>
<div>
	<div id="select-0" style="margin: 10px 0 0 0px;"></div>
</div>
<div style="padding-bottom: 10px;">
	<button class="btn btn-gray" onclick="uploader2.uploadStoredFiles();" onclick=""><?php echo __('Start upload');?></button>
</div>
<div class="portlet-body">
	<table class="table table-striped table-bordered table-hover" id="sample_1">
		<thead>
			<tr>
				<th><?php echo __('Name');?></th>
				<th><?php echo __('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($files as $file):?>
				<tr>
					<td>
						<?php echo $file?>
					</td>
					<td>
						<a href="<?php echo $this->request->base?>/admin/languages/download/<?php echo $language['Language']['id']?>/<?php echo $file?>" target="_blank"><i class="fa  fa-download"></i></a>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
var errorHandler = function(id, fileName, reason) {
        /*if ($(this._element).find('.qq-upload-list .errorUploadMsg').length > 0){
        	$(this._element).find('.qq-upload-list .errorUploadMsg').html(reason);
        }else {
        	$(this._element).find('.qq-upload-list').prepend('<li class="errorUploadMsg">' + reason + '</li>');
        }
        $(this._element).find('.qq-upload-fail').remove();*/
		console.log($(this._element));
		console.log($(this._element).find('.qq-upload-fail'));
		console.log($('.qq-upload-fail'));
    };
var uploader2 = new qq.FineUploader({
	element: $('#select-0')[0],
	text: {
    	uploadButton: '<div class="upload-section"><i class="icon-camera"></i><?php echo __('Click here to upload po file')?></div>'
    },
	autoUpload: false,	
	validation: {
  		allowedExtensions: ['po'],
    },
	request: {
		endpoint: "<?php echo $this->request->base?>/admin/languages/upload/<?php echo $language['Language']['id']?>"
	},
	callbacks: {
		onError: errorHandler,
		onComplete: function(id, fileName, response) {
			
		}
	}
});
<?php $this->Html->scriptEnd(); ?>