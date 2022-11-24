<script type="text/javascript">
    $('#friendTaggedBtn').click(function(){
       $.post("<?php echo $this->request->base?>/friends/tagged_save", jQuery("#friendTagged").serialize(), function(data){
            window.location.reload();
        }); 
    });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __('Tag Friends') ?>
    </div>
</div>
<form id="friendTagged">
    <input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>" />
    <div class="modal-body">
        <div class="tagged_user_lists">
            <?php foreach ($friendList as $user_id): ?>
                <?php $user = $this->MooPeople->get($user_id);?>
                <div class="tagged_user_item">
                    <div class="tagged_user_warp">
                        <label class="checkbox-control">
                            <input type="checkbox" <?php if(in_array($user_id, $userTagged)) echo 'checked'; ?> name="friends[]" value="<?php echo $user_id ?>" />
                            <span class="tagged_user_holder">
                                <span class="tagged_user_img">
                                    <?php echo $this->Moo->getImage($user, array('prefix' => '50_square', 'class' => 'user_avatar')) ?>
                                </span>
                                <span class="tagged_user_info"><?php echo $user['User']['name']; //$this->Moo->getName($user['User']) ?></span>
                            </span>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-modal_close"><?php echo __('Cancel') ?></a>
        <a href="javascript:void(0)" id="friendTaggedBtn" class="btn btn-modal_save"><?php echo __('Submit') ?></a>
    </div>
</form>