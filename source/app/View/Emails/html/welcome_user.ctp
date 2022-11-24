<?php echo __('Hello %s, welcome to %s!', $name, Configure::read('core.site_name'))?><br /><br />

<?php echo __('Your account has been created.')?><br /><br />

<?php if (!$confirmed): ?>
<?php echo __('Please click the link below to validate your email')?><br />
<a href="<?php echo FULL_BASE_URL .$this->request->base;//FULL_BASE_URL . $request->base?>/users/do_confirm/<?php echo $code?>"><?php echo FULL_BASE_URL .$this->request->base;//FULL_BASE_URL . $request->base?>/users/do_confirm/<?php echo $code?></a>
<?php else: ?>
<?php echo __('You can login')?> <a href="<?php echo FULL_BASE_URL .$this->request->base;//FULL_BASE_URL . $request->base?>"><?php echo __('here')?></a>
<?php endif; ?>