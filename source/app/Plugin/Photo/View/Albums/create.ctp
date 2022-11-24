<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooPhoto"], function($,mooPhoto) {
        mooPhoto.initOnCreateAlbum();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooPhoto'), 'object' => array('$', 'mooPhoto'))); ?>
mooPhoto.initOnCreateAlbum();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php
$tags_value = '';
if (!empty($tags)) $tags_value = implode(', ', $tags);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php if (isset($album['Album']['id']) && $album['Album']['id']):?>
        <?php echo __( 'Edit Album')?>
        <?php else: ?>
        <?php echo __( 'Create New Album')?>
        <?php endif; ?>
</div>
</div>

<div class="modal-body">
    <div class="create_form">
        <form id="createForm" class="form-horizontal">
            <div class="modal-form-content">
                <div class="form-content">
                    <?php echo $this->Form->hidden('id', array('value' => $album['Album']['id'])); ?>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Album Title')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->text('title', array('value' => html_entity_decode($album['Album']['title']), 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Category')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->select( 'category_id', $categories, array( 'value' => $album['Album']['category_id'], 'class' => 'form-control' ) ); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Description')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->textarea('description', array('value' => $album['Album']['description'], 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Tags')?> <a href="javascript:void(0)" class="tip" title="<?php echo __( 'Separated by commas or space')?>">(?)</a></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->text('tags', array('value' => $tags_value, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo __( 'Privacy')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->select('privacy', array( PRIVACY_EVERYONE => __( 'Everyone'),
                                PRIVACY_FRIENDS  => __( 'Friends Only'),
                                PRIVACY_ME 	  => __( 'Only Me')
                            ), array(
                                'value' => $album['Album']['privacy'],
                                'empty' => false,
                                'class' => 'form-control'
                            ) );
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-alert">
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal-footer">
    <button type='button' class='btn btn-modal_save' id="saveBtn"><?php echo __( 'Save Album')?></button>
    <button type="button" class="btn btn-modal_close" data-dismiss="modal">Close</button>
</div>