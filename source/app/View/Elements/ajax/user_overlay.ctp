<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<?php if ( $page == 1 ): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php if ($rsvp_type == RSVP_AWAITING): ?>
            <?php echo __( "%s Awaiting Response", count($users))?>
        <?php elseif ($rsvp_type == RSVP_ATTENDING): ?>
            <?php echo __( "%s Attending", count($users))?>
        <?php elseif ($rsvp_type == RSVP_NOT_ATTENDING): ?>
            <?php echo __( "%s Not Attending", count($users))?>
        <?php elseif ($rsvp_type == RSVP_MAYBE): ?>
            <?php echo __( "%s Maybe Attending", count($users))?>
        <?php endif; ?>
    </div>
</div>
<div class="modal-body">
<ul class="list1 users_list" id="list-content2">
<?php endif; ?>

<?php echo $this->element('lists/users_list_bit'); ?>

<?php if (count($users) >= RESULTS_LIMIT):?>

    <?php $this->Html->viewMore($more_url,'list-content2') ?>
<?php endif; ?>

<?php if ( $page == 1 ): ?>
</ul>
</div>
<?php endif; ?>