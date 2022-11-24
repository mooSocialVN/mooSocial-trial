<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initOnUserIndex();
        <?php if ( !empty( $values ) || !empty($online_filter) ): ?>
        $('#searchPeople').trigger('click');
        <?php endif; ?>
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initOnUserIndex();
<?php if ( !empty( $values ) || !empty($online_filter) ): ?>
$('#searchPeople').trigger('click');
<?php endif; ?>
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->start('west'); ?>




<div class="box2">
    <h3><?php echo __('Search')?></h3>
    <div class="box_content">
        <form id="filters">
            <ul class="list6">
                <li><label><?php echo __('Name')?></label><?php echo $this->Form->text('name');?></li>
                <li><label><?php echo __('Email')?></label><?php echo $this->Form->text('email');?></li>
                <li><label><?php echo __('Gender')?></label>
                    <?php echo $this->Form->select('gender', $this->Moo->getGenderList(), array( 'multiple' => 'multiple', 'class' => 'multi'));?>
                </li>
                <?php echo $this->element( 'custom_fields' ); ?>
                <li><label for="picture"><?php echo __('Profile Picture')?></label> <?php echo $this->Form->checkbox('picture');?> </li>
                <li><label for="online"><?php echo __('Online Users')?></label>
                    <?php
                    if ( !empty( $online_filter ) )
                        echo $this->Form->checkbox('online', array( 'checked' => true ));
                    else
                        echo $this->Form->checkbox('online');
                    ?>
                </li>
                <li style="margin-top:20px"><input type="button" value="<?php echo __('Search')?>" id="searchPeople" class="button button-action"></li>
            </ul>
        </form>
    </div>
</div>
<?php $this->end(); ?>


<h1><?php echo __('People')?></h1>
<?php

echo $this->currentUri();
?>
