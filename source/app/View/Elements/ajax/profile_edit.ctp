<?php

$bday_month = '';
$bday_day = '';
$bday_year = '';
if (!empty($cuser['birthday']))
{
	$birthday = explode('-', $cuser['birthday']);
	$bday_year = $birthday[0];
	$bday_month = $birthday[1];
	$bday_day = $birthday[2];
}
?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initOnProfileEdit();
<?php $this->Html->scriptEnd(); ?>

<div class="form-holder">
    <div class="form-holder-title"><?php echo __('Required Information')?></div>
    <div class="form-holder-main">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo __('Full Name')?></label>
            <div class="col-sm-9">
                <?php
                if ( Configure::read('core.name_change') )
                    echo $this->Form->text('name', array('value' => html_entity_decode($cuser['name']), 'class' => 'form-control'));
                else
                {
                    echo $this->Form->hidden('name', array('value' => $cuser['name'], 'class' => 'form-control'));
                    echo '<div class="help-block">'.$cuser['name'].'</div>';
                }
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo __('Email Address')?></label>
            <div class="col-sm-9">
                <?php echo $cuser['email']?> <a href="<?php echo $this->request->base?>/users/change_email"><?php  echo __('edit')?></a>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo __('Birthday')?> <a href="javascript:void(0)" class="tip" title="<?php echo __('Only month and date will be shown on your profile')?>">(?)</a></label>
            <div class="col-sm-9">
                <div class="form-row row">
                    <div class="col-xs-4">
                        <?php echo $this->Form->month('birthday', array('value' => $bday_month, 'class' => 'form-control'))?>
                    </div>
                    <div class="col-xs-4">
                        <?php echo $this->Form->day('birthday', array('value' => $bday_day, 'class' => 'form-control'))?>
                    </div>
                    <div class="col-xs-4">
                        <?php echo $this->Form->year('birthday', 1930, date('Y'), array('value' => $bday_year, 'class' => 'form-control'))?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo __('Gender')?></label>
            <div class="col-sm-9">
                <?php echo $this->Form->select('gender', $this->Moo->getGenderList(), array('value' => $cuser['gender'], 'class' => 'form-control')); ?>
            </div>
        </div>
        <?php $enable_timezone_selection = Configure::read('core.enable_timezone_selection');
        if ( !empty( $enable_timezone_selection ) ): ?>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __('Timezone')?></label>
                <div class="col-sm-9">
                    <?php echo $this->Form->select('timezone', $this->Moo->getTimeZones(), array('value' => $cuser['timezone'], 'class' => 'form-control')); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="form-holder">
    <div class="form-holder-title"><?php echo __('Optional Information')?></div>
    <div class="form-holder-main">
        <?php if ( in_array('user_username', $uacos) && ( Configure::read('core.username_change') || empty($cuser['username']) ) ): ?>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __('Profile address')?></label>
                <div class="col-sm-9">
                    <?php echo $this->Form->text('username', array('value' => $cuser['username'], 'class' => 'form-control')); ?>
                    <div class="help-block">
                        <?php
                        $ssl_mode = Configure::read('core.ssl_mode');
                        $http = (!empty($ssl_mode)) ? 'https' :  'http';
                        ?>
                        <?php echo $http.'://'.$_SERVER['SERVER_NAME'].$this->base;?>/<span id="profile_user_name"><?php if ($cuser['username']) echo '-'.$cuser['username']?></span>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-primary btn-cs" id="checkButton">
                        <span class="btn-cs-main">
                            <span class="btn-icon material-icons moo-icon moo-icon-done">done</span>
                            <span class="btn-text"><?php echo __('Check Availability')?></span>
                        </span>
                    </a>
                    <div class="help-block" style="display:none;" id="message"></div>
                </div>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo __('About')?></label>
            <div class="col-sm-9">
                <?php echo $this->Form->textarea('about', array('value' => $cuser['about'], 'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
</div>

<?php if ( !empty( $custom_fields ) || (count($profile_type) > 1 && ($is_edit || !$cuser['ProfileType']['id'])) ): ?>
<div class="form-holder">
    <div class="form-holder-title"><?php echo __('Additional Information')?></div>
    <div class="form-holder-main">
        <?php echo $this->element( 'custom_fields', array( 'show_require' => true, 'show_heading' => true, 'form_type' => 'horizontal' ) ); ?>
    </div>
</div>
<?php endif; ?>

<div class="form-holder">
    <div class="form-holder-title"><?php echo __('User Settings')?></div>
    <div class="form-holder-main">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo __('Profile Privacy')?></label>
            <div class="col-sm-9">
                <?php echo $this->Form->select('privacy', array( PRIVACY_EVERYONE => __('Everyone'),
                    PRIVACY_FRIENDS => __('Friends Only'),
                    PRIVACY_ME => __('Only Me')),
                    array('value' => $cuser['privacy'], 'empty' => false, 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <label class="checkbox-control">
                    <?php echo $this->Form->checkbox('hide_online', array('checked' => $cuser['hide_online'])); ?>
                    <?php echo __('Do not show my online status')?>
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
        <?php $send_message_to_non_friend= in_array('message_send_non_member', $uacos); ?>
        <?php if($send_message_to_non_friend): ?>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <label class="checkbox-control">
                        <?php echo $this->Form->checkbox('receive_message_from_non_friend', array('checked' => $cuser['receive_message_from_non_friend'])); ?>
                        <?php echo __('Receive message from non-friend')?>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        <?php endif; ?>
        <?php  ?>
        <!-- New hook -->
        <?php $this->getEventManager()->dispatch(new CakeEvent('Element.ajax.editProfile.Setting', $this, array('user' => $cuser))); ?>
        <!-- New hook -->
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-danger error-message" id="errorMessage" style="display:none"></div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        <div class="create-form-actions">
            <input id="save_profile" type="submit" class="btn btn-primary" value="<?php echo __('Save Changes')?>">
        </div>
    </div>
</div>