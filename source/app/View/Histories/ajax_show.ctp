<script type="text/javascript">
    require(["jquery","mooBehavior"], function($, mooBehavior) {
        mooBehavior.initMoreResults();
    });
</script>

<?php if ($page == 1):?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
    <div class="title-modal">
        <?php echo __('Edit History') ?>
    </div>
</div>
<?php endif;?>

<?php if ($page == 1):?>
<div class="modal-body">
    <div id="list-content-history" class="edit-history-list">
    <?php endif;?>
    <?php
        foreach ($histories as $history){
            ?>
            <div class="edit-history-item">
                <div class="edit-history-warp">
                    <div class="edit-history-img">
                        <?php echo $this->Moo->getItemPhoto(array('User' => $history['User']), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                    </div>
                    <div class="edit-history-info">
                        <div class="edit-history-user">
                            <?php echo $this->Moo->getName($history['User'])?>
                        </div>
                        <div class="edit-history-time">
                            <?php echo $this->Moo->getTime( $history['CommentHistory']['created'], Configure::read('core.date_format'), $utz )?>
                        </div>
                        <div class="edit-history-content">
                            <?php echo $this->viewMore(h($history['CommentHistory']['content']));?>
                        </div>

                        <?php $this->getEventManager()->dispatch(new CakeEvent('View.Histories.afterShowCommentHistory', $this, array('history' => $history))); ?>

                        <?php if ($history['CommentHistory']['photo']):?>
                            <div class="edit-history-edited">
                                <?php
                                switch ($history['CommentHistory']['photo']) {
                                    case 1: echo __('Added photo attachment.');
                                        break;
                                    case 2: echo __('Replaced photo attachment.');
                                        break;
                                    case 3: echo __('Deleted photo attachment.');
                                        break;
                                }
                                ?>
                            </div>
                        <?php endif;?>
                        <?php if ($history['CommentHistory']['link']):?>
                            <div class="edit-history-edited">
                                <?php echo __('Added a link.'); ?>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <?php
        }
        if ($historiesCount > $page * RESULTS_LIMIT)
        {
            ?>
            <div>
                <?php $this->Html->viewMore($more_url, 'list-content-history'); ?>
            </div>
            <?php
        }
    ?>
    <?php if ($page == 1):?>
    </div>
</div>
<?php endif;?>