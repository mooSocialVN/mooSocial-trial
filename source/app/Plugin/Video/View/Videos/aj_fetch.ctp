<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooVideo"], function($, mooVideo) {
        mooVideo.initAfterFetch();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooVideo'), 'object' => array('$', 'mooVideo'))); ?>
mooVideo.initAfterFetch();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php
$tags_value = '';
if (!empty($tags)) $tags_value = implode(', ', $tags);
?>
<?php if ( !empty( $video['Video']['id'] ) ): ?>

<?php if($this->request->is('ajax')): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __( 'Edit Video')?>
    </div>
</div>
<?php endif; ?>

<div class="create_form">
    <form id="createForm" class="form-horizontal">
        <?php endif; ?>
        <div class="modal-body">
            <div class="modal-form-content">
                <div class="form-content">
                    <?php echo $this->Form->hidden('id', array('value' => $video['Video']['id'])); ?>
                    <?php echo $this->Form->hidden('source_id', array('value' => $video['Video']['source_id'])); ?>
                    <?php echo $this->Form->hidden('thumb', array('value' => $video['Video']['thumb'])); ?>
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label"><?php echo __( 'Video Title')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->text('title', array('value' => html_entity_decode($video['Video']['title']), 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <?php if(empty($isGroup)): ?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Category')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->select( 'category_id', $categories, array( 'value' => $video['Video']['category_id'], 'class' => 'form-control' ) ); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Description')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->textarea('description', array('value' => $video['Video']['description'], 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <?php if(empty($isGroup)): ?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Tags')?> <a href="javascript:void(0)" class="tip" title="<?php echo __( 'Separated by commas or space')?>" style="display: none;">(?)</a></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->text('tags', array('value' => $tags_value, 'class' => 'form-control')); ?>
                            <span class="help-block"><?php echo __( 'Separated by commas or space')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Privacy')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->select( 'privacy',
                                array( PRIVACY_EVERYONE => __( 'Everyone'),
                                    PRIVACY_FRIENDS  => __( 'Friends Only'),
                                    PRIVACY_ME 	  => __( 'Only Me')
                                ),
                                array(
                                    'value' => $video['Video']['privacy'],
                                    'empty' => false,
                                    'class' => 'form-control'
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="form-alert">
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type='button' class='btn btn-modal_save' id="saveBtn"><?php echo __( 'Save Video')?></button>
            <?php if ( !empty( $video['Video']['id'] ) ): ?>
            <a class="btn btn-modal_delete deleteVideo" href="javascript:void(0)" data-id="<?php echo $video['Video']['id'] ?>"><?php echo __( 'Delete Video')?></a>
            <?php endif; ?>
            <button type="button" class="btn btn-modal_close" data-dismiss="modal"><?php echo __('Close')?></button>
        </div>
        <?php if ( !empty( $video['Video']['id'] ) ): ?>
    </form>
</div>
<?php endif; ?>