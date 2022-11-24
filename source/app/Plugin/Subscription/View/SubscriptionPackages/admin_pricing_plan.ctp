<?php ob_start();?>
		<div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Title');?></label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('titleNUMID',array('style'=>"width:100%; padding: 6px 0px",'required'=>'required','name'=>'PricingPlanNum[title]'));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Price');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Price');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('priceNUMID',array('style'=>"width:100%; padding: 6px 0px",'name'=>'PricingPlanNum[price]'));
                ?> <span><?php echo  $currency['Currency']['currency_code'] ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Plan Duration');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Maximum duration of this plan. For one-time plans, the plan will expire after the period of time set here. For recurring plans, the user will be billed at the above billing cycles for the period of time specified here');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('plan_durationNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[plan_duration]'));
                ?>
            </div>
            <div class="col-md-2">
                <?php
                $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'), 5 => __('Forever') );
                echo $this->Form->input('plan_typeNUMID', array(
                    'options' => $planType,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[plan_type]'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Expiration Reminder');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Specifies time before expiration to send renewal reminder');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('expiration_reminderNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[expiration_reminder]'));
                ?>
            </div>
            <div class="col-md-2">
                <?php
                $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year') );
                echo $this->Form->input('expiration_reminder_typeNUMID', array(
                    'options' => $planType,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[expiration_reminder_type]'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Show at');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Location where users can view and select this plan (Register page or Manage Membership page)');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                $showAt = array(1=>__('Register'),2 => __('Manage Membership'));
                echo $this->Form->input('show_atNUMID', array(
                    'options' => $showAt,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[show_at]',
                    'multiple' => 'multiple',
                	'required'=>'required'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Android Product Id');?></label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('android_product_idNUMID',array('style'=>"width:100%; padding: 6px 0px",'name'=>'PricingPlanNum[android_product_id]'));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Ios Product Id');?></label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('ios_product_idNUMID',array('style'=>"width:100%; padding: 6px 0px",'name'=>'PricingPlanNum[ios_product_id]'));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Enable Plan');?></label>
            <div class="col-md-4">
                <div class="col-md-2">
                    <?php
                    echo $this->Form->input('enable_planNUMID', array(
                        'type' => 'checkbox',
                        'label' => false,
                        'name' => 'PricingPlanNum[enable_plan]',
                        'hiddenField' => false
                    ));
                    ?>
                </div>
            </div>
        </div>
<?php $onTime = ob_get_clean(); ?>

<?php ob_start(); ?>
		<div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Title');?></label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('titleNUMID',array('style'=>"width:100%; padding: 6px 0px",'required'=>'required','name'=>'PricingPlanNum[title]'));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Recurring Price');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __(' The amount will be charged each billing cycle for recurring plans');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('priceNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[price]'));
                ?> <span><?php echo  $currency['Currency']['currency_code'] ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Billing Cycle');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Time duration of each billing cycle');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('billing_cycleNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[billing_cycle]'));
                ?>
            </div>
            <div class="col-md-2">
                <?php
                $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'));
                echo $this->Form->input('billing_cycle_typeNUMID', array(
                    'options' => $planType,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[billing_cycle_type]',
                	'onChange' => 'typeChange(this)'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Plan Duration');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Maximum duration of this plan. For one-time plans, the plan will expire after the period of time set here. For recurring plans, the user will be billed at the above billing cycles for the period of time specified here');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('plan_durationNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[plan_duration]'));
                ?>
                <label style="display:none;" class="check_duration"><?php echo __('Billing duration must be above time duration of each cycle')?></label>
            </div>
            <div class="col-md-2">
                <?php
                $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'), 5 => __('Forever') );
                echo $this->Form->input('plan_typeNUMID', array(
                    'options' => $planType,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[plan_type]'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Expiration Reminder');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Specifies time before expiration to send renewal reminder');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('expiration_reminderNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[expiration_reminder]'));
                ?>
            </div>
            <div class="col-md-2">
                <?php
                $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year') );
                echo $this->Form->input('expiration_reminder_typeNUMID', array(
                    'options' => $planType,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[expiration_reminder_type]'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Show at');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Location where users can view and select this plan (Register page or Manage Membership page)');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                $showAt = array(1=>'Register',2 => 'Manage Membership');
                echo $this->Form->input('show_atNUMID', array(
                    'options' => $showAt,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[show_at]',
                    'multiple' => 'multiple',
                	'required'=>'required'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Enable Plan');?></label>
            <div class="col-md-4">
                <div class="col-md-2">
                    <?php
                    echo $this->Form->input('enable_planNUMID', array(
                        'type' => 'checkbox',
                        'label' => false,
                        'name' => 'PricingPlanNum[enable_plan]',
                        'hiddenField' => false
                    ));
                    ?>
                </div>
            </div>
        </div>
<?php $recurring = ob_get_clean(); ?>

<?php ob_start(); ?>
		<div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Title');?></label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('titleNUMID',array('style'=>"width:100%; padding: 6px 0px",'required'=>'required','name'=>'PricingPlanNum[title]'));
                ?>
            </div>
        </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __( 'Trial Price');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Amount to charge users during trial duration. Setting this to zero will make this a free trial');?>" data-placement="top">?</a>)</label>
                <div class="col-md-2">
                    <?php
                    echo $this->Form->text('trial_priceNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[trial_price]'));
                    ?> <span><?php echo  $currency['Currency']['currency_code'] ?></span>
                </div>
                <div class="col-md-2">
                    <div style="color:red"><?php echo __('Please enter 0 if you plan to use Stripe payment gateway. Stripe ONLY support Free for trial.');?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __( 'Trial Duration');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Maximum duration users can try out this plan');?>" data-placement="top">?</a>)</label>
                <div class="col-md-2">
                    <?php
                    echo $this->Form->text('trial_durationNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[trial_duration]'));
                    ?>
                </div>
                <div class="col-md-2">
                    <?php
                    $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'), 5 => __('Forever') );
                    echo $this->Form->input('trial_duration_typeNUMID', array(
                        'options' => $planType,
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => false,
                        'value' => 1,
                        'name' => 'PricingPlanNum[trial_duration_type]'
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __( 'Recurring Price');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('The amount will be charged each billing cycle for recurring plans');?>" data-placement="top">?</a>)</label>
                <div class="col-md-2">
                    <?php
                    echo $this->Form->text('priceNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[price]'));
                    ?> <span><?php echo  $currency['Currency']['currency_code'] ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __( 'Billing Cycle');?></label>
                <div class="col-md-2">
                    <?php
                    echo $this->Form->text('billing_cycleNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[billing_cycle]'));
                    ?>                    
                </div>
                <div class="col-md-2">
                    <?php
                    $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'), 5 => __('Forever') );
                    echo $this->Form->input('billing_cycle_typeNUMID', array(
                        'options' => $planType,
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => false,
                        'value' => 1,
                        'name' => 'PricingPlanNum[billing_cycle_type]',
                    	'onChange' => 'typeChange(this)'
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __( 'Plan Duration');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Maximum duration of this plan. For one-time plans, the plan will expire after the period of time set here. For recurring plans, the user will be billed at the above billing cycles for the period of time specified here');?>" data-placement="top">?</a>)</label>
                <div class="col-md-2">
                    <?php
                    echo $this->Form->text('plan_durationNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[plan_duration]'));
                    ?>
                    <label style="display:none;" class="check_duration"><?php echo __('Billing duration must be above time duration of each cycle')?></label>
                </div>
                <div class="col-md-2">
                    <?php
                    $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'), 5 => __('Forever') );
                    echo $this->Form->input('plan_typeNUMID', array(
                        'options' => $planType,
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => false,
                        'value' => 1,
                        'name' => 'PricingPlanNum[plan_type]'
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __( 'Expiration Reminder');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Specifies time before expiration to send renewal reminder');?>" data-placement="top">?</a>)</label>
                <div class="col-md-2">
                    <?php
                    echo $this->Form->text('expiration_reminderNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[expiration_reminder]'));
                    ?>
                </div>
                <div class="col-md-2">
                    <?php
                    $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'));
                    echo $this->Form->input('expiration_reminder_typeNUMID', array(
                        'options' => $planType,
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => false,
                        'value' => 1,
                        'name' => 'PricingPlanNum[expiration_reminder_type]'
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __( 'Show at');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Location where users can view and select this plan (Register page or Manage Membership page)');?>" data-placement="top">?</a>)</label>
                <div class="col-md-2">
                    <?php
                    $showAt = array(1=>'Register', 2 => 'Manage Membership');
                    echo $this->Form->input('show_atNUMID', array(
                        'options' => $showAt,
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => false,
                        'value' => 1,
                        'name' => 'PricingPlanNum[show_at]',
                        'multiple' => 'multiple',
                    	'required'=>'required'
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __( 'Enable Plan');?></label>
                <div class="col-md-4">
                    <div class="col-md-2">
                        <?php
                        echo $this->Form->input('enable_planNUMID', array(
                            'type' => 'checkbox',
                            'label' => false,
                            'name' => 'PricingPlanNum[enable_plan]',
                            'hiddenField' => false
                        ));
                        ?>
                    </div>
                </div>
            </div>
<?php $trial_recurring = ob_get_clean(); ?>

<?php ob_start(); ?>
		<div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Title');?></label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('titleNUMID',array('style'=>"width:100%; padding: 6px 0px",'required'=>'required','name'=>'PricingPlanNum[title]'));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Trial Price');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Amount to charge users during trial duration. Setting this to zero will make this a free trial');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('trial_priceNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[trial_price]'));
                ?> <span><?php echo  $currency['Currency']['currency_code'] ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Trial Duration');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Maximum duration users can try out this plan');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('trial_durationNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[trial_duration]'));
                ?>
            </div>
            <div class="col-md-2">
                <?php
                $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'), 5 => __('Forever') );
                echo $this->Form->input('trial_duration_typeNUMID', array(
                    'options' => $planType,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[trial_duration_type]'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Price');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Price');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('priceNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[price]'));
                ?> <span><?php echo  $currency['Currency']['currency_code'] ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Plan Duration');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Maximum duration of this plan. For one-time plans, the plan will expire after the period of time set here. For recurring plans, the user will be billed at the above billing cycles for the period of time specified here');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('plan_durationNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[plan_duration]'));
                ?>
            </div>
            <div class="col-md-2">
                <?php
                $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year'), 5 => __('Forever') );
                echo $this->Form->input('plan_typeNUMID', array(
                    'options' => $planType,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[plan_type]'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Expiration Reminder');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Specifies time before expiration to send renewal reminder');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->text('expiration_reminderNUMID',array('style'=>"width:100%; padding: 6px 0px",'name' => 'PricingPlanNum[expiration_reminder]'));
                ?>
            </div>
            <div class="col-md-2">
                <?php
                $planType = array(1=>__('Days'),2 => __('Week'), 3 => __('Month'), 4 => __('Year') );
                echo $this->Form->input('expiration_reminder_typeNUMID', array(
                    'options' => $planType,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[expiration_reminder_type]'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Show at');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Location where users can view and select this plan (Register page or Manage Membership page)');?>" data-placement="top">?</a>)</label>
            <div class="col-md-2">
                <?php
                $showAt = array(1=>'Register', 2 => 'Manage Membership');
                echo $this->Form->input('show_atNUMID', array(
                    'options' => $showAt,
                    'class' => 'form-control',
                    'label' => false,
                    'empty' => false,
                    'value' => 1,
                    'name' => 'PricingPlanNum[show_at]',
                    'multiple' => 'multiple',
                	'required'=>'required'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __( 'Enable Plan');?></label>
            <div class="col-md-4">
                <div class="col-md-2">
                    <?php
                    echo $this->Form->input('enable_planNUMID', array(
                        'type' => 'checkbox',
                        'label' => false,
                        'name' => 'PricingPlanNum[enable_plan]',
                        'hiddenField' => false
                    ));
                    ?>
                </div>
            </div>
        </div>
<?php $trial_onetime = ob_get_clean(); ?>
<?php echo json_encode(array('oneTime' => htmlentities($onTime),'recurring' => htmlentities($recurring), 'trialOneTime' => htmlentities($trial_onetime), 'trialRecurring' => htmlentities($trial_recurring))); ?>