<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooVideo"], function($,mooVideo) {
        mooVideo.initOnCreate();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooVideo'), 'object' => array('$', 'mooVideo'))); ?>
mooVideo.initOnCreate();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if($this->request->is('ajax')) $this->setCurrentStyle(4); ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __( 'Share New Video')?>
    </div>
</div>
<div class="create_form">
    <form id="createForm" class="form-horizontal">
        <div id="fetchForm">
            <div class="modal-body">
                <div class="modal-form-content">
                    <div class="form-content">
                        <?php if ( !empty( $this->request->data['group_id'] ) )
                            echo $this->Form->hidden('group_id', array('value' => $this->request->data['group_id']));
                        echo $this->Form->hidden('tags');
                        ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo __( 'Copy and paste the video url in the text field below')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"><?php echo __( 'Source')?></label>
                            <div class="col-sm-9">
                                <?php echo $this->Form->select( 'source',
                                    array( VIDEO_TYPE_YOUTUBE => 'YouTube', VIDEO_TYPE_VIMEO   => 'Vimeo' ),
                                    array( 'empty' => false, 'class' => 'form-control' )
                                );
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-sm-3 control-label"><?php echo __( 'URL')?></label>
                            <div class="col-sm-9">
                                <?php echo $this->Form->text('url', array('class' => 'form-control')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-alert">
                        <div class="alert alert-danger error-message" style="display:none;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-modal_save" id="fetchButton"><?php echo __( 'Fetch Video')?></a>
                <button type="button" class="btn btn-modal_close" data-dismiss="modal"><?php echo __('Close')?></button>
            </div>
        </div>
        <div id="videoForm"></div>
    </form>
</div>