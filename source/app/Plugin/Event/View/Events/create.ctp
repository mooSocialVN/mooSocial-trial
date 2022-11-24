<?php $this->setCurrentStyle(4);?>
<?php
$eventHelper = MooCore::getInstance()->getHelper('Event_Event');
?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery','mooEvent'), 'object' => array('$', 'mooEvent'))); ?>
mooEvent.initOnCreate();
<?php $this->Html->scriptEnd(); ?>

<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php if (empty($event['Event']['id'])) echo __( 'Add New Event'); else echo __( 'Edit Event');?></h1>
            </div>
        </div>

        <div class="box_content">
            <div class="create_form">
                <form id="createForm" class="form-horizontal">
                    <?php
                    if (!empty($event['Event']['id'])){
                        echo $this->Form->hidden('id', array('value' => $event['Event']['id']));
                        echo $this->Form->hidden('photo', array('value' => $event['Event']['photo']));
                    }else{
                        echo $this->Form->hidden('photo', array('value' => ''));
                    }
                    ?>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Event Title')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('title', array('value' => html_entity_decode($event['Event']['title']), 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Category')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->select( 'category_id', $categories, array( 'value' => $event['Event']['category_id'], 'class' => 'form-control' ) ); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Location')?> <a href="javascript:void(0)" class="tip" title="<?php echo __( 'e.g. Aluminum Hall, Carleton University')?>">(?)</a></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('location', array('value' => $event['Event']['location'], 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Address')?> <a href="javascript:void(0)" class="tip" title="<?php echo __( 'Enter the full address (including city, state, country) of the location.<br />This will render a Google map on your event page (optional)')?>">(?)</a></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('address', array('value' => $event['Event']['address'], 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'From Date')?></label>
                        <div class="col-sm-10">
                            <div class="form-row row">
                                <div class='col-xs-6'>
                                    <?php echo $this->Form->text('from', array('class' => 'form-control datepicker', 'value' => $event['Event']['from'] , 'placeholder' => __('Date') )); ?>
                                </div>
                                <div class='col-xs-6'>
                                    <?php echo $this->Form->text('from_time', array('value' => $event['Event']['from_time'], 'class' => 'form-control timepicker' , 'placeholder' => __('Time'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'To Date')?></label>
                        <div class="col-sm-10">
                            <div class="form-row row">
                                <div class='col-xs-6'>
                                    <?php echo $this->Form->text('to', array('class' => 'form-control datepicker', 'value' => $event['Event']['to']  , 'placeholder' => __('Date') )  ); ?>
                                </div>
                                <div class='col-xs-6'>
                                    <?php echo $this->Form->text('to_time', array('value' => $event['Event']['to_time'], 'class' => 'form-control timepicker' , 'placeholder' => __('Time'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Timezone')?></label>
                        <div class="col-sm-10">
                            <?php $currentTimezone = !empty($event['Event']['timezone']) ? $event['Event']['timezone'] : $cuser['timezone']; ?>
                            <?php echo $this->Form->select('timezone', $this->Moo->getTimeZones(), array('empty' => false, 'value' => $currentTimezone, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Information')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->tinyMCE('description', array('id' => 'editor' ,'escape'=>false,'value' => $event['Event']['description'], 'width' => '100%'), $this); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Event Type')?> <a href="javascript:void(0)" class="tip" title="<?php echo __( 'Public: anyone can view and RSVP<br />Private: only invited guests can view and RSVP')?>">(?)</a></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->select('type', array(
                                PRIVACY_PUBLIC  => __( 'Public'),
                                PRIVACY_PRIVATE => __( 'Private')
                            ),
                                array( 'value' => $event['Event']['type'], 'empty' => false, 'class' => 'form-control' )
                            );
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Photo')?></label>
                        <div class="col-sm-10">
                            <div id="select-0" class="control-upload"></div>
                            <div class="control-upload-review">
                            <?php if (!empty($event['Event']['photo'])): ?>
                                <img width="150" id="item-avatar" class="img_wrapper" src="<?php echo  $eventHelper->getImage($event, array('prefix' => '150_square')) ?>" />
                            <?php else: ?>
                                <img width="150" id="item-avatar" class="img_wrapper" style="display: none;" src="" />
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- New hook -->
                    <?php $this->getEventManager()->dispatch(new CakeEvent('Plugin.View.Event.create.renderMoreOptions', $this, array('event' => $event))); ?>
                    <!-- New hook -->
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="create-form-actions">
                                <button type='button' id='saveBtn' class='btn btn-primary'><?php echo __('Save'); ?></button>
                                <?php if ( !empty( $event['Event']['id'] ) ): ?>
                                    <a class="btn btn-default" href="<?php echo $this->request->base?>/events/view/<?php echo $event['Event']['id']?>"><?php echo __( 'Cancel')?></a>
                                <?php endif; ?>
                                <?php if ( ($event['Event']['user_id'] == $uid ) || ( !empty( $event['Event']['id'] ) && !empty($cuser['Role']['is_admin']) ) ): ?>
                                    <a class="btn btn-danger deleteEvent" href="javascript:void(0)" data-id="<?php echo $event['Event']['id']?>"><?php echo __( 'Delete')?></a>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-danger error-message" id="errorMessage" style="display: none;"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>