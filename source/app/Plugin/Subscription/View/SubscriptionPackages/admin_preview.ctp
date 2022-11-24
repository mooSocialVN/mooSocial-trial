<div class="modal-header">
    <h4><?php echo __('Subscription Plans')?></h4>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
</div>
<?php 
	$element = (Configure::read('Subscription.select_theme_subscription_packages') ? 'Subscription.theme_compare' : 'Subscription.theme_default');
?>
<div class="package_content" id="register_content">
	<?php echo $this->element($element,array('type'=>'register','columns'=>$columns_login,'compares'=>$compares_login));?>
</div>
<div class="package_content" id="manage_content" style="display:none;">
	<?php echo $this->element($element,array('type'=>'manage','columns'=>$columns_update,'compares'=>$compares_update));?>
</div>
<div style="text-align: right;padding: 10px;"><a style="display:none;" class="package_button" href="javascript:void(0);" id="register_button" onclick="showContent('register');"><?php echo __('Register');?></a><a class="package_button" id="manage_button" href="javascript:void(0);" onclick="showContent('manage');"><?php echo __('Manage membership');?></a></div>
<script>
function showContent(name)
{
	$('.package_content').hide();
	$('.package_button').show();
	
	$('#'+name+'_content').show();
	$('#'+name+'_button').hide();
}
</script>