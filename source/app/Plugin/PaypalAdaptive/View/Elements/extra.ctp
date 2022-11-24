<div class="form-group">
	<label class="col-md-3 control-label"><?php echo __('Paypal API Username');?></label>
	<div class="col-md-4">
		<?php
			echo $this->Form->input('config][username', array(
				'class' => 'form-control',
				'label' => false,
				'value' => isset($extra_params_value['username']) ? $extra_params_value['username'] : ''
			));
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label"><?php echo __('Paypal API Password');?></label>
	<div class="col-md-4">
		<?php
			echo $this->Form->input('config][password', array(
				'class' => 'form-control',
				'label' => false,
				'type' => 'text',
				'value' => isset($extra_params_value['password']) ? $extra_params_value['password'] : ''
			));
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label"><?php echo __('Paypal API Signature');?></label>
	<div class="col-md-4">
		<?php
			echo $this->Form->input('config][signature', array(
				'class' => 'form-control',
				'label' => false,
				'value' => isset($extra_params_value['signature']) ? $extra_params_value['signature'] : ''
			));
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label"><?php echo __('Paypal API AppId');?></label>
	<div class="col-md-4">
		<?php
			echo $this->Form->input('config][appid', array(
				'class' => 'form-control',
				'label' => false,
				'value' => isset($extra_params_value['appid']) ? $extra_params_value['appid'] : ''
			));
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label"><?php echo __('Paypal Email');?></label>
	<div class="col-md-4">
		<?php
			echo $this->Form->input('config][email', array(
				'class' => 'form-control',
				'label' => false,
				'value' => isset($extra_params_value['email']) ? $extra_params_value['email'] : ''
			));
		?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">
		<?php echo __('endingDate Restriction');?>
		(<a data-html="true" href="javascript:void(0);" target="_blank" class="tooltips" data-original-title="<?php echo __('Duration for which Preapproval is valid. It cannot be later than one year from the starting date. Contact PayPal if you would like to change or do not want to specify an ending date.');?>" data-placement="top">?</a>)
	</label>
	<div class="col-md-4">
		<?php
			echo $this->Form->input('config][ending_date', array(
				'class' => 'form-control',
				'label' => false,
				'value' => isset($extra_params_value['ending_date']) ? $extra_params_value['ending_date'] : 1,
				'style' => 'float:left;width:90%;',
				'after' => '<span style="float: right;padding-top: 5px;">'.__('year').'</span>'
			));
		?>		
		<div style="clear:both" class="alert alert-warning">
			<?php echo __('Do not change unless PayPal approved your “endingDate” change request. By Default, there is a maximum 1 year limit for Preapprovals. Leave blank for Unlimited.');?>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">
		<?php echo __('maxTotalAmountOfAllPayments Restriction');?>
		(<a data-html="true" href="javascript:void(0);" target="_blank" class="tooltips" data-original-title="<?php echo __('The Preapproved maximum total amount of all payments. It cannot exceed $2,000 USD or its equivalent in other currencies. Contact PayPal if you would like to change or do not want to specify a maximum amount.');?>" data-placement="top">?</a>)
	</label>
	<div class="col-md-4">
		<?php
			echo $this->Form->input('config][max_total', array(
				'class' => 'form-control',
				'label' => false,
				'value' => isset($extra_params_value['max_total']) ? $extra_params_value['max_total'] : '2000',
			));
		?>		
		<div class="alert alert-warning">
			<?php echo __('Do not change unless PayPal approved your "maxTotalAmountOfAllPayments" change request. By Default, there is a maximum $2000 limit for Preapproval. Leave blank for Unlimited.');?>
		</div>
	</div>
</div>