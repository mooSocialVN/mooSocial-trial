<?php echo $this->Html->css(array('cropper.min'), null, array('inline' => false));?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooUser'), 'object' => array('$', 'mooUser'))); ?>
    mooUser.initOnProfilePicture();
<?php $this->Html->scriptEnd(); ?>
    
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo  __('Profile Picture') ?></h1>
            </div>
        </div>
        <div class="box_content box_user_avatar">
            <div class="create_form">
                <div class="ava_content">
                    <div id="avatar_wrapper" class="avatar_wrapper">
                        <img <?php echo empty($cuser['avatar']) ? 'data-default="1"' : '';?> src="<?php echo $this->Moo->getImageUrl(array('User' => $cuser), array('prefix' => '600'))?>"  id="av-img2">
                    </div>
                    <?php if($this->Storage->isLocalStorage()):?>
                        <div class="avatar-rotate" style="<?php echo empty($cuser['avatar']) ? 'display:none' : '';?>">
                            <a href="#" id="rotate_right" data-mode="left" aria-haspopup="true" role="button" aria-expanded="false" class="rotate_avatar" title="<?php echo __('Rotate Left');?>">
                                <span class="material-icons moo-icon moo-icon-rotate_left notranslate">rotate_left</span>
                            </a>
                            <a href="#" id="rotate_right" data-mode="right" aria-haspopup="true" role="button" aria-expanded="false" class="rotate_avatar" title="<?php echo __('Rotate Right');?>">
                                <span class="material-icons moo-icon moo-icon-rotate_right notranslate">rotate_right</span>
                            </a>
                        </div>
                    <?php endif;?>
                    <div class="avatar-field-group">
                        <div class="Metronic-alerts alert alert-warning fade in ava-upload" style="margin-bottom: 10px;"><?php echo __("Optimal size 300x300px"); ?></div>

                        <div class="form-group">
                            <div id="select-0" class="ava-upload field-avatar-upload"></div>
                        </div>

                        <div class="avatar_action">
                            <button id="save-avatar" data-url="<?php echo $this->Moo->getProfileUrl( $cuser )?>" type="button" class="btn btn-primary save-avatar"><span aria-hidden="true"><?php echo  __('Save Thumbnail') ?></span></button>
                            <a id="submit-avatar" href="<?php echo $this->request->base; ?>/users/view/<?php echo $cuser['id']; ?>"; type="button" class="btn btn-success submit-avatar hide"><span aria-hidden="true"><?php echo  __('Submit') ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
