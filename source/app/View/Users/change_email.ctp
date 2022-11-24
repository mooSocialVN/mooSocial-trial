<?php echo  $this->Session->flash(); ?>
<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<div class="bar-content">
    <div class="profile-info-menu">
        <?php echo $this->element('profilenav', array("cmenu" => "profile"));?>
    </div>
</div>
<?php $this->end(); ?>
<div class="box2 bar-content-warp">
	<?php if (!$step1):?>
		<div class="box_header mo_breadcrumb">
			<div class="box_header_main">
				<h1 class="box_header_title"><?php echo __('Confirm Password')?></h1>
			</div>
		</div>
		<div class="box_content profile-info-edit">
			<div class="create_form">			
				<form class="form-horizontal" id="form_submit" action="<?php echo $this->request->base?>/users/change_email" method="post">
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo __('Current Password')?></label>
						<div class="col-sm-9">
							<?php echo $this->Form->password('password', array('class' => 'form-control')); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
							<div class="create-form-actions">
								<input class="btn btn-primary" id="submit" type="button" value="<?php echo __('Continue')?>">
							</div>
							<div class="alert alert-danger error-message" id="errorMessage" style="display: none;"></div>
						</div>						
					</div>
				</form>
			</div>
		</div>
	<?php else:?>
		<div class="box_header mo_breadcrumb">
			<div class="box_header_main">
				<h1 class="box_header_title"><?php echo __('Change email')?></h1>
			</div>
		</div>
		<div class="box_content profile-info-edit">
			<div class="create_form">			
				<form class="form-horizontal" id="form_submit" action="<?php echo $this->request->base?>/users/change_email?step1=true" method="post">
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo __('Enter your new email')?></label>
						<div class="col-sm-9">
							<?php echo $this->Form->text('email', array('class' => 'form-control')); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
							<div class="create-form-actions">
								<input class="btn btn-primary" id="submit" type="button" value="<?php echo __('Continue')?>">
							</div>
							<div class="alert alert-danger error-message" id="errorMessage" style="display: none;"></div>
						</div>						
					</div>
				</form>
			</div>
		</div>
	<?php endif;?>
</div>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooButton'), 'object' => array('$','mooButton'))); ?>
	$('#form_submit').on('submit', function(e) {
		e.preventDefault();
	});
	$('#submit').click(function(){
		mooButton.disableButton('submit');
		$('#errorMessage').hide();
		<?php if ($step1):?>
			$.post(mooConfig.url.base + "/users/save_email", {'email' : $('#email').val().trim()}, function(data){
	                var json = $.parseJSON(data);
	                if(json.result == 0) {
	                    mooButton.enableButton('submit');
	                    $('#errorMessage').html(json.message).show();
	                }
	                else {                    
	                	window.location = '<?php echo $this->request->base?>/users/profile';
	                }
	        });
		<?php else:?>
			$.post(mooConfig.url.base + "/users/check_password", {'password' : $('#password').val().trim()}, function(data){
	                var json = $.parseJSON(data);
	                if(json.result == 0) {
	                    mooButton.enableButton('submit');
	                    $('#errorMessage').html(json.message).show();
	                }
	                else {                    
	                	window.location = '<?php echo $this->request->base?>/users/change_email?step1=1';
	                }
	        });
		<?php endif;?>
	});
<?php $this->Html->scriptEnd(); ?>