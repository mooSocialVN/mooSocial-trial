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