<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initEditCoverPicture();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initEditCoverPicture();
<?php $this->Html->scriptEnd(); ?> 
<?php endif; ?>

<?php $this->setCurrentStyle(4); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __('Cover Picture')?>
    </div>
</div>
<div class="create_form">
    <div class="modal-body">
        <div id="cover_wrapper" class="avatar_wrapper">
            <?php if ( !empty( $photo['Photo']['thumbnail'] ) ): ?>
            <?php echo $this->Moo->getImage($photo, array('prefix' => '1500', 'id' => 'cover-img'));?>
            <?php else: ?>
            <img data-default="1" src="<?php echo $this->Moo->defaultCoverUrl() ?>"  id="cover-img">
            <?php endif; ?>
        </div>

        <div class="Metronic-alerts alert alert-warning fade in"><?php echo __("Optimal size 1165x305px"); ?></div>

        <div id="select-1" class="ava-upload field-cover-upload" style="margin-top:10px;"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-modal_save save-cover"><span aria-hidden="true"><?php echo __('Save Cover Picture')?></span></button>
    </div>
</div>