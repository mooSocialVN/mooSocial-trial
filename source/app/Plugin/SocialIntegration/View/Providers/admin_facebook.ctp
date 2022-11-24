<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Facebook Integration Setting'), $url);

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "social_integration"));
$this->end();
?>
<?php $return_id = 0;?>
<?php foreach ($settings as $key=>$setting):?>
	<?php
		if ($setting['Setting']['name'] == 'facebook_app_return_url')
		{
			$return_id = $setting['Setting']['id'];
		}
	?>
<?php endforeach;?>
<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('SocialIntegration', __('Facebook'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                        	<?php
							if (version_compare(phpversion(), '5.4.0', '<')) {
							    ?>
							    <div class="alert alert-danger" role="alert"><?php echo __("You're using php %s. Please upgrade to 5.4 or above before enable this feature.",phpversion());?></div>
							    <?php 
							}
							?>
                            <p class="form-description"><?php echo __( 'You can now integrate mooSocial to Facebook. To do so, create an Application through the');?> <a target="_blank" href="http://www.facebook.com/developers/apps.php"><?php echo __( 'Facebook Developers');?></a> <?php echo __( 'page.');?></p>
                            <p><a target="_blank" href="https://moosocial.com/knowledge-base/configure-google-and-facebook-login"><?php echo __( 'How to setup Facebook App') ?></a></p>
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
    $('#text<?php echo $return_id?>').val('<?php echo FULL_BASE_URL.$this->request->base;?>/social/auths/endpoint/facebook/');
});
<?php $this->Html->scriptEnd();  ?>