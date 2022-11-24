<?php foreach ($requests as $request): ?>
    <div id="request_<?php echo $request['GroupUser']['id']?>" class="user-list-item">
        <div class="user-item-warp">
            <div class="user-item-main">
                <div class="user-item-figure">
                    <?php echo $this->Moo->getItemPhoto(array('User' => $request['User']), array( 'prefix' => '200_square', 'class' => 'user-item-picture'), array('class' => 'user-item-img'))?>
                </div>
                <div class="user-item-info">
                    <div class="user-item-holder">
                        <div class="user-item-name">
                            <?php echo $this->Moo->getName($request['User'])?>
                        </div>
                        <div class="user-item-date">
                            <?php echo $this->Moo->getTime( $request['GroupUser']['created'], Configure::read('core.date_format'), $utz )?>
                        </div>
                        <div class="user-message">

                        </div>
                    </div>
                    <div class="user-item-action">
                        <a class="btn btn-primary btn-xs btn-cs btn-user-act delete_people_join_group" href="javascript:void(0)" onclick="respondRequest(<?php echo $request['GroupUser']['id']?>, 1)" title="<?php __('Delete');?>">
                            <span class="btn-cs-main">
                                <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span>
                                <span class="btn-text"><?php echo __( 'Accept')?></span>
                            </span>
                        </a>
                        <a class="btn btn-primary btn-xs btn-cs btn-user-act delete_people_join_group" href="javascript:void(0)" onclick="respondRequest(<?php echo $request['GroupUser']['id']?>, 0)" title="<?php __('Delete');?>">
                            <span class="btn-cs-main">
                                <span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span>
                                <span class="btn-text"><?php echo __( 'Delete')?></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if (!empty($more_requests)):?>
    <?php $this->Html->viewMore($more_url,'list-request') ?>
<?php endif; ?>

<?php if($this->request->is('ajax')): ?>
    <script type="text/javascript">
        require(["jquery","mooBehavior"], function($,mooBehavior) {
            mooBehavior.initMoreResults();
        });
    </script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooBehavior'), 'object' => array('$', 'mooBehavior'))); ?>
    mooBehavior.initMoreResults();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>