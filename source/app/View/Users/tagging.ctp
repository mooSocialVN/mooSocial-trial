<?php if ($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __('User Tagging'); ?>
    </div>
</div>
<div class="modal-body">
    <div class="user-lists list-view user-like" id="list-content2">

        <?php echo $this->element('lists/users_list_bit'); ?>
        
    </div>
</div>
