<?php if (Configure::read('Event.event_enabled') == 1): ?>

<?php
if(!isset($events)){
    if($uid !== null){
        $events = $this->requestAction("events/upcomming/uid:".$uid);
    }else{
        $events = array();
    }
}
$eventHelper = MooCore::getInstance()->getHelper('Event_Event');
    if (count($events) > 0):
        foreach ($events as $event):
    ?>
        <div class="core-list-item <?php if( !empty($uid) && (($event['Event']['user_id'] == $uid ) || ( !empty($cuser) && $cuser['Role']['is_admin'] ) ) ): ?>core-is-owner<?php endif; ?>">
                <div class="core-item-warp">
                    <div class="core-item-figure">
                        <a class="core-item-thumb" href="<?php echo $this->request->base?>/events/view/<?php echo $event['Event']['id']?>/<?php echo seoUrl($event['Event']['title'])?>">
                            <img class="core-item-img" src="<?php echo $eventHelper->getImage($event, array('prefix' => '300_square'));?>">
                            <div class="core-item-time"><?php echo $this->Time->event_format($event['Event']['from'])?></div>
                        </a>
                    </div>
                    <div class="core-item-info">
                        <div class="core-item-head">
                            <a class="core-item-title" href="<?php echo $this->request->base?>/events/view/<?php echo $event['Event']['id']?>/<?php echo seoUrl($event['Event']['title'])?>">
                                <?php echo $event['Event']['title']?>
                            </a>
                            <?php if( !empty($uid) && (($event['Event']['user_id'] == $uid ) || ( !empty($cuser) && $cuser['Role']['is_admin'] ) ) ): ?>
                            <div class="list_option">
                                <div class="dropdown">
                                    <button id="dropdown-edit" data-target="#" data-toggle="dropdown" >
                                        <span class="material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                    </button>

                                    <ul role="menu" class="dropdown-menu" aria-labelledby="dropdown-edit" style="float: right;">
                                        <?php if ($event['User']['id'] == $uid || ( !empty($cuser) && $cuser['Role']['is_admin'] )): ?>
                                            <li style="border-top:none"><a href="<?php echo $this->request->base?>/events/create/<?php echo $event['Event']['id']?>"> <?php echo __( 'Edit Event')?></a></li>
                                        <?php endif; ?>
                                        <?php if ( ($event['Event']['user_id'] == $uid ) || ( !empty( $event['Event']['id'] ) && !empty($cuser) && $cuser['Role']['is_admin'] ) ): ?>
                                            <li style="border-top:none"><a href="javascript:void(0)" data-id="<?php echo $event['Event']['id']?>" class="deleteEvent" > <?php echo __( 'Delete Event')?></a></li>
                                            <li class="seperate" style="border-top:none"></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="core-item-date">
                            <?php if ($event['Event']['type'] == PRIVACY_PUBLIC): ?>
                                <?php echo __('Public')?>
                            <?php elseif ($event['Event']['type'] == PRIVACY_PRIVATE): ?>
                                <?php echo __('Private')?>
                            <?php endif; ?>
                            &middot; <span class="item-count"><?php echo __( '%s attending', $event['Event']['event_rsvp_count'])?></span>
                        </div>
                        <div class="core-item-list">
                            <div class="core-list-idx">
                                <div class="core-list-idx-l"><?php echo __('Time') ?></div>
                                <div class="core-list-idx-r">
                                    <?php echo $this->Time->event_format($event['Event']['from'])?> <?php echo $event['Event']['from_time']?> -
                                    <?php echo $this->Time->event_format($event['Event']['to'])?> <?php echo $event['Event']['to_time']?>
                                </div>
                            </div>
                            <!-- New hook -->
                            <?php $this->getEventManager()->dispatch(new CakeEvent('Plugin.View.Event.renderMoreInfo', $this, array('event' => $event, 'view_type' => 'event_list'))); ?>
                            <!-- New hook -->
                            <div class="core-list-idx">
                                <div class="core-list-idx-l"><?php echo __('Location') ?></div>
                                <div class="core-list-idx-r">
                                    <?php echo h($event['Event']['location'])?>
                                </div>
                            </div>
                            <?php if (!empty($event['Event']['address'])): ?>
                            <div class="core-list-idx">
                                <div class="core-list-idx-l"><?php echo __('Address') ?></div>
                                <div class="core-list-idx-r">
                                    <?php echo h($event['Event']['address'])?>
                                    (<a target="_blank" href="https://maps.google.com/maps?q=<?php echo urlencode($event['Event']['address'])?>"><?php echo __('View Map');?></a>)
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="core-extra-info">
                            <?php $this->Html->rating($event['Event']['id'],'events','Event'); ?>
                        </div>
                    </div>
                </div>
        </div>
    <?php
        endforeach;
    else:
        echo '<div class="no-more-results">' . __( 'No more results found') . '</div>';
    endif;

?>

<?php
if (!empty($more_result)):
?>

    <?php $this->Html->viewMore($more_url) ?>
<?php
endif;

?>

<?php endif; ?>
<section class="modal fade in" id="mapmodals">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo  $this->MooGMap->loadGoogleMap('',530,300,true); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</section><!-- /.modal -->

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooEvent"], function($,mooEvent) {
        mooEvent.initOnListing();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooEvent'), 'object' => array('$', 'mooEvent'))); ?>
mooEvent.initOnListing();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>