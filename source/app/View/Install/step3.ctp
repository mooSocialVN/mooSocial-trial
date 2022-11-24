<h2><?php echo __('Step 4: Root Admin Account');?></h2>
<form id="installForm">
<?php echo $this->Form->hidden('db_serialized', array('value' => $db_serialized)); ?>
<ul class="list6">
	<li><label><?php echo __('Name');?></label>
		<?php echo $this->Form->text('name'); ?>
	</li>
	<li><label><?php echo __('Email');?></label>
		<?php echo $this->Form->text('email'); ?>
	</li>
	<li><label><?php echo __('Password');?></label>
		<?php echo $this->Form->password('password'); ?>
	</li>
	<li><label><?php echo __('Confirm Password');?></label>
		<?php echo $this->Form->password('password2'); ?>
	</li>
	<li><label><?php echo __('Timezone');?></label>
		<?php
		$timezones = $this->Moo->getTimeZones();
        echo $this->Form->select('timezone', $timezones); 
        ?>
	</li>
	<li><label>&nbsp;</label>
	    <a href="javascript:void(0)" onclick="doStep(3)" id="step_but" class="btn btn-danger"><i class="icon-ok"></i> <?php echo __('Next')?></a>
	</li>
</ul>
</form>