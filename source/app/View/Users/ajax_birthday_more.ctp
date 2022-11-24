<?php if($this->request->is('ajax')) $this->setCurrentStyle(4);?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initBirthdayPopup();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initBirthdayPopup();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __("Today's Birthdays")?>
    </div>
</div>
<div class="modal-body">
    <div class="user-today-birthday">
        <div class="user-lists list-view user-like">
            <?php foreach ($birthday as $u): ?>
                <?php
                if ( !empty(  $u['User']['username'] ) ){
                    $url = $this->request->base . '/-' .  $u['User']['username'];
                } else{
                    $url = $this->request->base . '/users/view/'. $u['User']['id'];
                }
                $tz  = new DateTimeZone($utz);
                ?>
                <div class="user-list-item">
                    <div class="user-item-warp">
                        <div class="user-item-main">
                            <div class="user-item-figure">
                                <?php echo $this->Moo->getItemPhoto(array('User' => $u['User']),array('class' => 'user-item-picture', 'prefix' => '100_square'), array('class' => 'user-item-img'))?>
                            </div>
                            <div class="user-item-info">
                                <div class="user-item-holder">
                                    <div class="user-item-name">
                                        <a class="moocore_tooltip_link" href="<?php echo $url; ?>"><?php echo $u['User']['name']; ?></a>
                                    </div>
                                    <div class="user-item-send-message">
                                        <div class="user-item-send-form">
                                            <form id="wallForm_<?php echo  $u['User']['id']; ?>" class="">
                                                <?php
                                                echo $this->Form->hidden('target_id', array('value' => $u['User']['id']));
                                                echo $this->Form->hidden('type', array('value' => APP_USER));
                                                echo $this->Form->hidden('action', array('value' => 'wall_post'));
                                                echo $this->Form->hidden('wall_photo_id');
                                                echo $this->Form->hidden('privacy',array('value'=>1));
                                                echo $this->Form->hidden('params',array('value'=>'birthday_wish'));

                                                $text = __("Write on %s's timeline",$u['User']['name']);

                                                ?>
                                                <div class="birthday-wish">
                                                <?php if(empty($users_sent) || !in_array($u['User']['id'],$users_sent)): ?>
                                                    <div class="birthday-wish-l">
                                                        <?php echo $this->Form->text('message_'.$u['User']['id'], array('class' => 'form-control', 'placeholder' => $text,'name'=>"data[message]")); ?>
                                                    </div>
                                                    <div class="birthday-wish-r">
                                                        <a href="javascript:void(0)" data-id="<?php echo  $u['User']['id'] ?>" class="btn btn-primary postFriendWall birthday-post" id="status_btn_<?php echo  $u['User']['id'] ?>"><?php echo __('Send')?></a>
                                                    </div>
                                                <?php else: ?>
                                                    <div>
                                                        <?php echo __("Birthday wish is sent"); ?>
                                                    </div>
                                                <?php endif;?>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="user-item-send-private">
                                            <?php $this->MooPopup->tag(array(
                                                'href'=>$this->Html->url(array("controller" => "conversations", "action" => "ajax_send", "plugin" => false, $u['User']['id'])),
                                                'title' => __('Send a private message'),
                                                'innerHtml'=> __('Send a private message'),
                                                'class' => 'more-birthday-email'
                                            )); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>