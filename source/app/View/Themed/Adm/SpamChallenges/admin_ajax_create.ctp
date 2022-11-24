<?php
echo $this->Html->script(array('tinymce/tinymce.min'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Spam Challenges'), array('controller' => 'spam_challenges', 'action' => 'admin_index'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "spam_challenges"));
$this->end();
?>
<script>
$(document).ready(function(){
	$('#createButton').click(function(){
        disableButton('createButton');
        $.post("<?php echo $this->request->base?>/admin/spam_challenges/ajax_save", $("#createForm").serialize(), function(data){
            enableButton('createButton');
            var json = $.parseJSON(data);
            
            if ( json.result == 1 )
            	location.reload();
            else
            {
            	$(".error-message").fadeIn();
				$(".error-message").html('<strong>Error!</strong>'+json.message);
            }
        });
    });
});
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php if(!empty($edit)) echo __('Edit'); else echo __('Add New'); ?></h4>
</div>
<div class="modal-body">

<form id="createForm" class="form-horizontal" role="form">
<?php echo $this->Form->hidden('id', array('value' => $challenge['SpamChallenge']['id'])); ?>

    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Question');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('question', array('placeholder'=>__('Enter text'),'class'=>'form-control','value' => $challenge['SpamChallenge']['question'])); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Answers');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->textarea('answers', array('class'=>'form-control','value' => $challenge['SpamChallenge']['answers'])); ?>
                <span class="help-block"><?php echo __('One answer per line. Case is not sensitive');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Active');?></label>
            <div class="col-md-9">
                <div class="checkbox-list">
                    <label class="checkbox-inline">
                        <?php echo $this->Form->checkbox('active', array( 'checked' => $challenge['SpamChallenge']['active'] ) );	?>
                    </label>


                </div>
            </div>
        </div>
    </div>
</form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="#" id="createButton" class="btn btn-action"><?php echo __('Save Challenge');?></a>

</div>