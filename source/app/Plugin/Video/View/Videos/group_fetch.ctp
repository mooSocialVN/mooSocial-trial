<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGroup"], function($, mooGroup) {
        mooGroup.initTabVideo();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooGroup'), 'object' => array('$', 'mooGroup'))); ?>
mooGroup.initTabVideo();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<!--<?php //if ( !empty( $video['Video']['id'] ) ): ?><div class='bar-content'><?php //endif; ?>-->
<div class="modal-body">
    <!--<div class='mo_breadcrumb'>
        <h1><?php /*echo __( 'Video Details')*/?></h1>
    </div>-->
    <div class="modal-form-content">
        <div class="form-content">
            <?php if (!empty($video['Video']['id'])): ?>
                <?php echo $this->Form->hidden('id', array('value' => $video['Video']['id'])); ?>
            <?php endif; ?>
            <?php echo $this->Form->hidden('source_id', array('value' => $video['Video']['source_id'])); ?>
            <?php echo $this->Form->hidden('thumb', array('value' => $video['Video']['thumb'])); ?>
            <?php echo $this->Form->hidden('privacy', array('value' => PRIVACY_EVERYONE)); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __( 'Video Title')?></label>
                <div class="col-sm-9">
                    <?php echo $this->Form->text('title', array('value' => $video['Video']['title'], 'class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __( 'Description')?></label>
                <div class="col-sm-9">
                    <?php echo $this->Form->textarea('description', array('value' => $video['Video']['description'], 'class' => 'form-control')); ?>
                </div>
            </div>
        </div>
        <div class="form-alert">
            <div class="alert alert-danger error-message" style="display:none"></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a href="javascript:void(0)" class="btn btn-modal_save saveVideo"><?php echo __( 'Save')?></a>
    <?php if ( !empty($video['Video']['id']) ): ?>
    <a href="javascript:void(0)" class="btn btn-modal_close cancelVideo" data-group-id="<?php echo $video['Video']['group_id']?>" data-id="<?php echo $video['Video']['id']?>"><?php echo __( 'Cancel')?></a>
    <a href="javascript:void(0)" class="btn btn-modal_delete deleteVideo" data-group-id="<?php echo $video['Video']['group_id']?>" data-id="<?php echo $video['Video']['id']?>"><?php echo __( 'Delete')?></a>
    <?php else: ?>
    <a href="javascript:void(0)" class="btn btn-modal_close" onclick="$('.modal').modal('hide');"> <?php echo __( 'Cancel')?></a>
    <?php endif; ?>
</div>
<!--<?php //if ( !empty( $video['Video']['id'] ) ): ?></div><?php //endif; ?>-->