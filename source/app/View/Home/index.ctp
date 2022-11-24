<?php if(!empty($tab)): ?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooTab"], function($, mooTab) {
        mooTab.initHomeTabs("<?php echo $tab; ?>");
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooTab'), 'object' => array('$', 'mooTab'))); ?>
mooTab.initHomeTabs("<?php echo $tab; ?>");
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php endif; ?>

<?php
if ( empty($uid) && Configure::read('core.force_login') ):
    $guest_message = Configure::read('core.guest_message');
    if ( !empty($guest_message) ): ?>
    <div class="box1 guest_msg"><?php echo nl2br(Configure::read('core.guest_message'))?></div>
<?php
    endif;
else:
?>
<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
        <?php if ($uid && (!Configure::check('core.show_left_menu_home') || Configure::read('core.show_left_menu_home'))): ?>
        	<?php echo $this->element('home/sidebar_menu') ?>
        <?php endif;?>

    <?php echo html_entity_decode( Configure::read('core.homepage_code') )?>
<?php $this->end(); ?>
<?php endif; ?>