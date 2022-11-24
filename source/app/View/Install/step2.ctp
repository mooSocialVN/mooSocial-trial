<h2><?php echo __('Step 3: Site Settings');?></h2>
<form id="installForm">
<?php echo $this->Form->hidden('db_serialized', array('value' => $db_serialized)); ?>
<ul class="list6">
	<li><label><?php echo __('Site Name');?></label>
		<?php echo $this->Form->text('site_name'); ?>
	</li>
	<li><label><?php echo __('Site Email');?></label>
		<?php echo $this->Form->text('site_email'); ?>
	</li>
	<li><label><?php echo __('Default Timezone');?></label>
        <?php 
        $timezones = $this->Moo->getTimeZones();
        echo $this->Form->select('timezone', $timezones); 
        ?>
    </li> 
	<li><label>&nbsp;</label>
		<a href="javascript:void(0)" onclick="doStep(2)" id="step_but" class="btn btn-danger"><i class="icon-ok"></i> <?php echo __('Next');?></a>
	</li>
</ul>
</form>