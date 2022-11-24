<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initEditProfilePicture();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initEditProfilePicture();
<?php $this->Html->scriptEnd(); ?> 
<?php endif; ?>

<?php $this->setCurrentStyle(4); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __('Profile Picture')?>
    </div>
</div>
<div class="create_form">
    <div class="modal-body">
        <div id="avatar_wrapper" class="avatar_jcrop">
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
        <div class="Metronic-alerts alert alert-warning fade in"><?php echo __("Optimal size 300x300px"); ?></div>
        <div id="select-0" class="ava-upload field-cover-upload"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-modal_save save-avatar"><span aria-hidden="true"><?php echo __('Save Thumbnail')?></span></button>
    </div>
</div>