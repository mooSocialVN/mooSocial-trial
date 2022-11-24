<?php if (Configure::read('Event.event_enabled') == 1): ?>
<?php
if (empty($title))
    $title = "RSVP";
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;

?>
<?php if (isset($event['Event']['id'])): ?>
<div class="box2 bar-content-warp">
    <?php if($title_enable): ?>
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __($title)?></h3>
        </div>
    </div>
    <?php endif; ?>
    <div class="box_content event-box-content">
        <form id="rsvp_form" action="<?php echo  $this->request->base ?>/events/do_rsvp" method="post">
            <input type="hidden" name="event_id" value="<?php echo  $event['Event']['id'] ?>"> 
            <div class="event_rsvp_choose">
                <div class="form-group">
                    <label class="radio-control">
                        <?php echo  __( 'Yes') ?>
                        <input type="radio" name="rsvp" value="1" <?php if (!empty($my_rsvp) && $my_rsvp['EventRsvp']['rsvp'] == 1) echo 'checked'; ?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="radio-control">
                        <?php echo  __( 'No') ?>
                        <input type="radio" name="rsvp" value="2" <?php if (!empty($my_rsvp) && $my_rsvp['EventRsvp']['rsvp'] == 2) echo 'checked'; ?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="radio-control">
                        <?php echo  __( 'Maybe') ?>
                        <input type="radio" name="rsvp" value="3" <?php if (!empty($my_rsvp) && $my_rsvp['EventRsvp']['rsvp'] == 3) echo 'checked'; ?>>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block"><?php echo  __( 'Confirm RSVP') ?></button>
        </form>
        <div class="clear"></div>
    </div>
</div>
<?php if (!$uid && !$this->Session->read('event_invite_checksum')):?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
$('#rsvp_form').submit(function(e){
	e.preventDefault();
	mooUser.validateUser();
});
<?php $this->Html->scriptEnd(); ?>
<?php else:?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery'), 'object' => array('$'))); ?>
$('#rsvp_form').submit(function(e){
	if (!$("input[name='rsvp']:checked").val())
		e.preventDefault();
});
<?php $this->Html->scriptEnd(); ?>
<?php endif;?>
<?php endif; ?>
<?php endif; ?>