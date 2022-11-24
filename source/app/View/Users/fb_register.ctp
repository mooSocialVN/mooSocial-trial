<?php if($this->Auth->user('id') === null): ?>
<h1><?php echo __('Register with your Facebook account')?></h1>
<div style="text-align: center">
	<fb:registration 
	  fields='<?php echo $fields?>'
	  redirect-uri="<?php echo FULL_BASE_URL . $this->request->base?>/users/do_fb_register"
	  width="785">
	</fb:registration>
</div>
<?php endif; ?>