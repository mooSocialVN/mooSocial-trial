<?php if ($activity['User']['gender'] == 'Female'): ?>
<?php echo __('changed her profile picture');?>
<?php elseif($activity['User']['gender'] == 'Male'): ?>
<?php echo __('changed his profile picture');?>
<?php else: ?>
<?php echo __('changed profile picture');?>
<?php endif; ?>
