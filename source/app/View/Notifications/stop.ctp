<script type="text/javascript">
    require(["jquery","mooNotification"], function($,mooNotification) {
        mooNotification.initNotification();
    });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal"><?php echo  __('Confirm') ?></div>
</div>
<div class="create_form">
    <form id="notificationForm" class="form-horizontal">
        <div class="modal-body">
            <div class="modal-form-content">
                <div class="form-content">
                    <?php echo $this->Form->hidden('item_type', array('value' => $item_type)); ?>
                    <?php echo $this->Form->hidden('item_id', array('value' => $item_id)); ?>
                    <div class="form-group">
                        <div class='col-md-12'>
                            <?php if ($notification_stop): ?>
                                <?php echo  __('Are you sure you want to getting notifications of this post?') ?>
                            <?php else: ?>
                                <?php echo  __('Are you sure you want to stop getting notifications of this post?') ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-alert">
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-modal_save" id="notificationButton">
                <?php if ($notification_stop): ?>
                    <?php echo  __('Turn On') ?>
                <?php else: ?>
                    <?php echo  __('Stop') ?>
                <?php endif; ?>
            </button>
        </div>
    </form>
</div>