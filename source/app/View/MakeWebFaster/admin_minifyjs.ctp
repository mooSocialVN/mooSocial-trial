<?php


$this->Html->addCrumb(__( 'Make the Web Faster'));
$this->Html->addCrumb(__( 'Minify Resources ( JavaScript )'), $url);

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "social_integration"));
$this->end();
?>

<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('SocialIntegration', 'Facebook');?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <p class="form-description"><?php echo __( 'You can now integrate mooSocial to Facebook. To do so, create an Application through the');?> <a target="_blank" href="http://www.facebook.com/developers/apps.php"><?php echo __( 'Facebook Developers');?></a> <?php echo __( 'page.');?></p>
                            <p><a target="_blank" href="https://www.moosocial.com/wiki/doku.php?id=admin_dashboard:system_admin:system_settings:integration_settings"><?php echo __( 'How to setup Facebook App') ?></a></p>
                            <?php echo $this->element('admin/setting');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>