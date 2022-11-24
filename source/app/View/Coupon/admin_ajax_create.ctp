<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Add New');?></h4>
</div>
<div class="modal-body">
<form id="createFieldForm" class="form-horizontal system-setting" role="form">
    <?php echo $this->Form->hidden('id', array('value' => $coupon['Coupon']['id'])); ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Code'); ?></label>

            <div class="col-md-9">
                <?php echo $this->Form->text('code', array('placeholder' => __('Enter code'),'class' => 'form-control','value' => $coupon['Coupon']['code'])); ?>

            </div>            
        </div>                              
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Description');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->textarea('description', array('class' => 'form-control','value' => $coupon['Coupon']['description'])); ?>

            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Discount Type');?></label>
            <div class="col-md-9">
                <?php
                	$options = array('empty'=>false,'class'=>'form-control','value' => $coupon['Coupon']['type']);
                    echo $this->Form->select('type', array( '0'=> __('Cart discount'), '1'=> __('Cart % discount')
                        ),
                        $options
                    );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Coupon Amount'); ?></label>

            <div class="col-md-9">
                <?php echo $this->Form->text('value', array('placeholder' => __('Enter amount'),'class' => 'form-control','value' => $coupon['Coupon']['value'])); ?>

            </div>            
        </div>  
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Coupon expiry date'); ?></label>

            <div class="col-md-9">
                <?php echo $this->Form->text('expire', array('class' => 'form-control datepicker form-control input-small input-inline','value' => $coupon['Coupon']['expire']!='0000-00-00' ? $coupon['Coupon']['expire'] : '')); ?>

            </div>            
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Usage limit per coupon'); ?> </label>

            <div class="col-md-9">
                <?php echo $this->Form->text('limit', array('placeholder' => __('Enter number'),'class' => 'form-control','value' => $coupon['Coupon']['limit'])); ?>
				<div><?php echo __('How many times this coupon can be used. Enter 0 or leave it empty for unlimited.');?></div>
            </div>            
        </div>   
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Active');?></label>

            <div class="col-md-9">
                <?php echo $this->Form->checkbox( 'actived', array('checked' => $coupon['Coupon']['actived'] ) ); ?>
            </div>
        </div>
    </div>

</form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="javascript:void(0);" id="createButton" class="btn btn-action"><?php echo __('Save');?></a>

</div>

<script>
$('#createButton').click(function(){
	disableButton('createButton');
	$.post("<?php echo $this->request->base?>/admin/coupon/ajax_save", $("#createFieldForm").serialize(), function(data){
		enableButton('createButton');
		var json = $.parseJSON(data);

		if ( json.result == 1 )
			location.reload();
		else
		{
			$(".error-message").show();
			$(".error-message").html(json.message);
		}
	});
	return false;
});

$('.datepicker').pickadate({
	monthsFull: ['<?php echo addslashes(__( 'January'))?>', '<?php echo addslashes(__( 'February'))?>', '<?php echo addslashes(__( 'March'))?>', '<?php echo addslashes(__( 'April'))?>', '<?php echo addslashes(__( 'May'))?>', '<?php echo addslashes(__( 'June'))?>', '<?php echo addslashes(__( 'July'))?>', '<?php echo addslashes(__( 'August'))?>', '<?php echo addslashes(__( 'September'))?>', '<?php echo addslashes(__( 'October'))?>', '<?php echo addslashes(__( 'November'))?>', '<?php echo addslashes(__( 'December'))?>'],
	monthsShort: ['<?php echo addslashes(__( 'Jan'))?>', '<?php echo addslashes(__( 'Feb'))?>', '<?php echo addslashes(__( 'Mar'))?>', '<?php echo addslashes(__( 'Apr'))?>', '<?php echo addslashes(__( 'May'))?>', '<?php echo addslashes(__( 'Jun'))?>', '<?php echo addslashes(__( 'Jul'))?>', '<?php echo addslashes(__( 'Aug'))?>', '<?php echo addslashes(__( 'Sep'))?>', '<?php echo addslashes(__( 'Oct'))?>', '<?php echo addslashes(__( 'Nov'))?>', '<?php echo addslashes(__( 'Dec'))?>'],
	weekdaysFull: ['<?php echo addslashes(__( 'Sunday'))?>', '<?php echo addslashes(__( 'Monday'))?>', '<?php echo addslashes(__( 'Tuesday'))?>', '<?php echo addslashes(__( 'Wednesday'))?>', '<?php echo addslashes(__( 'Thursday'))?>', '<?php echo addslashes(__( 'Friday'))?>', '<?php echo addslashes(__( 'Saturday'))?>'],
	weekdaysShort: ['<?php echo addslashes(__( 'Sun'))?>', '<?php echo addslashes(__( 'Mon'))?>', '<?php echo addslashes(__( 'Tue'))?>', '<?php echo addslashes(__( 'Wed'))?>', '<?php echo addslashes(__( 'Thu'))?>', '<?php echo addslashes(__( 'Fri'))?>', '<?php echo addslashes(__( 'Sat'))?>'],
	today:"<?php echo addslashes(__( 'Today'))?>",
	clear:"<?php echo addslashes(__( 'Clear'))?>",
	close: "<?php echo addslashes(__( 'Close'))?>",
	format: 'yyyy-mm-dd'
});
</script>