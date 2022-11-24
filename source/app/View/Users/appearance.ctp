<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initOnUserProfile();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initOnUserProfile();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
    <?php echo $this->element('profilenav', array("cmenu" => "appearance"));?>
<?php $this->end(); ?>
<?php if($this->isEnableDarkMode()): ?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Appearance')?></h1>
            </div>
        </div>

        <div class="box_content profile-info-edit">
            <div class="create_form">
                <form id="form_edit_user" class="form-horizontal" action="<?php echo $this->request->base?>/users/appearance" method="post">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="hidden" name="data[dark_mode]" id="dark_mode_" value="0">
                            <div class="onoffswitch user-appearance">
                                <input id="dark_mode" class="onoffswitch-checkbox" type="checkbox" name="data[dark_mode]" value="1" <?php if($is_dark_mode): ?>checked<?php endif; ?>>
                                <label class="onoffswitch-label" for="dark_mode">
                                    <span class="onoffswitch-inner" data-check="<?php echo __('Dark') ?>" data-uncheck="<?php echo __('Light') ?>"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <div class="col-xs-12">
                            <label class="checkbox-control">
                                <?php //echo $this->Form->checkbox('dark_mode', array('checked' => $is_dark_mode)); ?>
                                <?php //echo __('Dark mode')?>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>-->
                    <div class="create-form-actions">
                        <input class="btn btn-primary" type="submit" value="<?php echo __('Save Changes'); ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>