<?php if($this->request->is('ajax')) $this->setCurrentStyle(4);?>

<?php if ($target_id): ?>
    <?php if($this->request->is('ajax')): ?>
    <script type="text/javascript">
        require(["jquery","mooGroup"], function($, mooGroup) {
            mooGroup.initTabPhoto2();
        });
    </script>
    <?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooGroup'), 'object' => array('$', 'mooGroup'))); ?>
    mooGroup.initTabPhoto2();
    <?php $this->Html->scriptEnd(); ?>
    <?php endif; ?>

    <?php if($html_content_type == 'modal'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <div class="title-modal">
            <?php echo __( 'Upload Photos')?>
        </div>
    </div>
    <div class="create_form share-video-section">
        <form id="uploadPhotoForm" action="<?php echo $this->request->base?>/photos/do_activity/<?php echo $type?>" method="post">
            <div class="modal-body">
                <div id="photos_upload"></div>
                <div id="photo_review"></div>
                <input type="hidden" name="new_photos" id="new_photos">
                <input type="hidden" name="target_id" value="<?php echo $target_id?>">
                <input type="hidden" name="type" value="<?php echo $type?>">
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-modal_save" id="triggerUpload"><?php echo __( 'Upload Queued Files')?></a>
                <button type="button" class="btn btn-modal_save" id="nextStep" style="display:none;">
                    <span id="loadingSpin" class="btn-icon-spin"></span>
                    <?php echo __( 'Save Photos')?>
                </button>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div class="bar-content">
        <div class="box2 bar-content-warp">
            <div class="box_header">
                <div class="box_header_main">
                    <h1 class="box_header_title"><?php echo __( 'Upload Photos')?></h1>
                    <div class="box_action"></div>
                </div>
            </div>
            <div class="box_content">
                <div class="create_form share-video-section">
                    <form id="uploadPhotoForm" action="<?php echo $this->request->base?>/photos/do_activity/<?php echo $type?>" method="post">
                        <div class="form-group">
                            <div id="photos_upload"></div>
                        </div>
                        <div id="photo_review"></div>
                        <input type="hidden" name="new_photos" id="new_photos">
                        <input type="hidden" name="target_id" value="<?php echo $target_id?>">
                        <input type="hidden" name="type" value="<?php echo $type?>">
                        <a href="#" class="btn btn-success" id="triggerUpload"><?php echo __( 'Upload Queued Files')?></a>
                        <button type="button" class="btn btn-primary" id="nextStep" style="display:none;">
                            <span id="loadingSpin" class="btn-icon-spin"></span>
                            <?php echo __( 'Save Photos')?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>