<?php
echo $this->Html->script(array('tinymce/tinymce.min'), array('inline' => false));
echo $this->element('admin/adminnav', array("cmenu" => "bulkmail"));
?>

<script>
    $(document).ready(function(){
        tinymce.init({
            selector: "textarea",
            language : mooConfig.tinyMCE_language,
            theme: "modern",
            skin: 'light',
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor"
            ],
            toolbar1: "styleselect | bold italic | bullist numlist outdent indent | forecolor backcolor emoticons | link unlink anchor image media | preview fullscreen code",
            image_advtab: true,
            image_dimensions: false,
            height: 500,
            relative_urls : false,
            remove_script_host : true,
            document_base_url : '<?php echo FULL_BASE_URL . $this->request->root?>',
            directionality : mooConfig.site_directionality
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
		    mooAlert('An email has been sent to <?php echo Configure::read('core.site_email')?>');
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
                        title: 'Sending Emails Progress',
                        contents: 'Sending emails is in progress. Please do not close this window<br /><br /><iframe frameborder="0" width="100%" height="200" src="<?php echo $this->request->base?>/admin/tools/ajax_bulkmail_send"></iframe>'
                    }).showModal();
                }
            });
        },
        title: 'Please Confirm',
        contents: 'Are you sure you want to proceed sending emails?',
        hideFooter: false, 
        closeButton: false
    }).showModal();
}
</script>

<style>
.list6 .mce-tinymce {
    margin-left: 0px;
}
</style>

<div id="center">
	<form id="createForm" method="post" action="<?php echo $this->request->base?>/admin/users/ajax_bulkmail_send/1" target="sending">
	<h1>Bulk Mail</h1>	
	<ul class="list6">
		<li><label>Mail Subject</label><?php echo $this->Form->text('subject'); ?></li>
		<li><label>Emails Cycle</label><?php echo $this->Form->text('cycle', array('value' => 30)); ?> <a href="javascript:void(0)" class="tip" title="Enter number of emails per cycle.<br />Please check your host's email limit">(?)</a></li>
		<li><label style="float:none;margin-bottom:10px;">Mail Body</label><?php echo $this->Form->textarea('body', array('id' => 'editor')); ?></li>		
	</ul>
	</form>
	
	<div style="margin-top:20px;text-align: center;">		
	    <a href="javascript:void(0)" class="button button-action button-medium" onclick="sendEmails()" id="send_button"><i class="icon-envelope"></i> Send Emails</a>
	    <a href="javascript:void(0)" class="button button-primary button-medium" onclick="sendTestEmail()" id="send_test_button"><i class="icon-envelope-alt"></i> Send Test Email</a>
	</div>	
	<div class="error-message" style="display:none;margin-top:10px"></div>
</div>
