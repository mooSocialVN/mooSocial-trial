<?php if (Configure::read('Event.event_enabled') == 1): ?>
<?php if (!empty($maybe)): ?>
    <?php if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true; ?>
    <div class="box2 maybe_attending_block">
    <?php if($title_enable): ?>
        <h3>
            <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "events",
                                            "action" => "showRsvp",
                                            "plugin" => 'event',
                                            $event['Event']['id'],
                                            RSVP_MAYBE,
                                        )),
             'title' => __('%s Maybe Attending', $maybe_count),
             'innerHtml'=> __( '%s Maybe Attending', $maybe_count),
     ));
      ?></h3>
           
    <?php endif; ?>
        <div class="box_content">
            <?php echo $this->element('blocks/users_sm_block', array('users' => $maybe)); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($awaiting)): ?>
    <?php if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true; ?>
    <div class="box2 waiting_attending_block">
    <?php if($title_enable): ?>
        <h3>
            <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "events",
                                            "action" => "showRsvp",
                                            "plugin" => 'event',
                                            $event['Event']['id'],
                                            RSVP_AWAITING,
                                        )),
             'title' => __( '%s Awaiting Response', $awaiting_count),
             'innerHtml'=> __( '%s Awaiting Response', $awaiting_count),
     ));
 ?>
             </h3>
    <?php endif; ?>
        <div class="box_content">
            <?php echo $this->element('blocks/users_sm_block', array('users' => $awaiting)); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($not_attending)): ?>
    <?php if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true; ?>
    <div class="box2 not_attending_block">
    <?php if($title_enable): ?>
        <h3>
            <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "events",
                                            "action" => "showRsvp",
                                            "plugin" => 'event',
                                            $event['Event']['id'],
                                            RSVP_NOT_ATTENDING,
                                        )),
             'title' => __( '%s Not Attending', $not_attending_count),
             'innerHtml'=> __( '%s Not Attending', $not_attending_count),
     ));
 ?>
            </h3>
    <?php endif; ?>
        <div class="box_content">
            <?php echo $this->element('blocks/users_sm_block', array('users' => $not_attending)); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($attending)): ?>
<?php if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true; ?>

    <div class="box2 attending_block">
        <?php if($title_enable): ?>
    <h3>
        <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "events",
                                            "action" => "showRsvp",
                                            "plugin" => 'event',
                                            $event['Event']['id'],
                                            RSVP_ATTENDING,
                                        )),
             'title' => __( '%s Attending', count($attending)),
             'innerHtml'=> __( '%s Attending', count($attending)),
     ));
 ?>
       </h3>
    <?php endif; ?>
    <div class="box_content">
        <?php echo $this->element( 'blocks/users_block', array( 'users' => $attending ) ); ?>
        <div class="text-right">
        </div>
    </div>
    
</div>
<?php endif; ?>
<?php endif; ?>