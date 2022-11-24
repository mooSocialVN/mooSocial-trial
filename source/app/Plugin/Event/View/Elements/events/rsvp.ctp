<?php if (Configure::read('Event.event_enabled') == 1): ?>
<?php
if (empty($title))
    $title = "RSVP";
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;

?>
<?php if (isset($event['Event']['id'])): ?>
<div class="box2">
    <?php if($title_enable): ?>
        <h3><?php echo  __( $title) ?></h3>
    <?php endif; ?>    <div class="box_content event-box-content">
        <form action="<?php echo  $this->request->base ?>/events/do_rsvp" method="post">
            <input type="hidden" name="event_id" value="<?php echo  $event['Event']['id'] ?>"> 
            <div class="event_rsvp_choose">
                <div>
                    <input type="radio" name="rsvp" value="1" <?php if (!empty($my_rsvp) && $my_rsvp['EventRsvp']['rsvp'] == 1) echo 'checked'; ?>> <?php echo  __( 'Yes') ?> 
                </div>
                <div>
                    <input type="radio" name="rsvp" value="2" <?php if (!empty($my_rsvp) && $my_rsvp['EventRsvp']['rsvp'] == 2) echo 'checked'; ?>> <?php echo  __( 'No') ?> 
                </div>
                <div>
                    <input type="radio" name="rsvp" value="3" <?php if (!empty($my_rsvp) && $my_rsvp['EventRsvp']['rsvp'] == 3) echo 'checked'; ?>> <?php echo  __( 'Maybe') ?>
                </div>
            </div>
            <input type="submit" class="col-md-12 btn btn-action" value="<?php echo  __( 'Confirm RSVP') ?>">
        </form>
        <div class="clear"></div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>