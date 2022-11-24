<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Google Integration Setting'), $url);

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "social_integration"));
$this->end();
?>
<?php $return_id = 0;?>
<?php foreach ($settings as $key=>$setting):?>
	<?php
		if ($setting['Setting']['name'] == 'google_app_return_url')
		{
			$return_id = $setting['Setting']['id'];
		}
	?>
<?php endforeach;?>
<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('SocialIntegration', __('Google'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <p class="form-description"><?php echo __( 'You can now integrate mooSocial to Google. To do so, create an Application through the');?> <a target="_blank" href="https://console.developers.google.com"><?php echo __( 'Google Developers');?></a> <?php echo __( 'page.');?></p>
                            <p><a target="_blank" href="https://moosocial.com/knowledge-base/configure-google-and-facebook-login"><?php echo __( 'How to setup Google App') ?></a></p>
                            <?php echo $this->element('admin/setting');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php  $this->Html->scriptStart(array('inline' => false));   ?>
$(document).ready(function(){
    $('#text<?php echo $return_id?>').prop('readonly', true);
    $('#text<?php echo $return_id?>').val('<?php echo FULL_BASE_URL.$this->request->base;?>/social/auths/endpoint/google?hauth.done=Google');
});
<?php $this->Html->scriptEnd();  ?>