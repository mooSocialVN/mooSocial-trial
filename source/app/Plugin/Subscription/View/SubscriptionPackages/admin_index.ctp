<?php
echo $this->Html->css(array('jquery-ui', 'jquery.validate','footable.core.min','select2/select2'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui','jquery.validate.min', 'footable','global/select2/select2.min.js?'.Configure::read('core.version')), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Subscription'), '/admin/subscription/subscription_settings');

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "packages"));
$this->end();
$helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
?>


<div class="portlet-body">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('Subscription', __('Manage Packages'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <div class="note"><?php echo  __('The first Price Plan of the fist Package will be set as default if there wasn\'t any other packages set as default') ?></div>
                            <?php
                            echo $this->Form->create('SubscriptionPackage', array(
                                'class' => 'form-horizontal',
                                'url' => $url.'save_change/',
                                'id' => 'changeForm',
                            	'novalidate' => 'novalidate'
                            ));
                            ?>
                            <?php if($packages != null):?>
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                    <tr>
                                        <th width="300"><?php echo  __( 'Packages');?></th>
                                        <th width="130"><?php echo  __( 'Order Packages');?> (<a data-html="true"  href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __('Package with lower number will be listed first');?>" data-placement="top">?</a>)</th>
                                        <th width="100" class="text-center"><?php echo  __( 'User Role');?></th>
                                        <th width="200"><?php echo  __( 'Plans');?></th>
                                        <th width="130"><?php echo  __( 'Order Plans');?> (<a data-html="true"  href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __('Plans with lower number will be listed first within the package');?>" data-placement="top">?</a>)</th>                                        
                                        <th width="100" class="text-center"><?php echo  __( 'Enable');?></th>
                                        <th width="200"><?php echo  __( 'Show at');?></th>
                                        <th width="100"><?php echo  __( 'Action');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0;
                                    foreach ($packages as $package): 
                                        $group = $package['Role'];
                                        $price_plan = $package['SubscriptionPackagePlan'];
                                        $package = $package['SubscriptionPackage'];

                                    ?>
                                        <tr id="<?php echo $package['id']?>" class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                                            <td class="reorder">
                                                <h1><?php echo $package['name']?></h1>
                                                <div class="status">
                                                    <?php
                                                        echo $this->Form->hidden('default_package_'.$package['id'],array('name' => 'data[Package]['.$package['id'].'][default]','class' => 'default-hidden', 'value' => $package['default']));
                                                        echo $this->Form->hidden('recommend_package_'.$package['id'],array('name' => 'data[Package]['.$package['id'].'][recommended]','class' => 'recommended-hidden','value' => $package['recommended']));
                                                        $background_default = ( !empty($package['default'] ))? 'checked':'';
                                                        $background_recommended = ( !empty($package['recommended']) )? 'checked':'';
                                                    ?>
                                                        <div><span><?php echo  __('Default Package'); ?></span>&nbsp;<a class="default-package" href="#"><i class="fa fa-check-circle default <?php echo  $background_default ?>" title="<?php echo __('Default Package');?>"></i></a></div>
                                                        <div><span><?php echo  __('Recommended'); ?></span>&nbsp;<a class="recommended-package" href="#"><i class="fa fa-check-circle default <?php echo  $background_recommended ?>" title="<?php echo __('Recommended');?>"></i></a></div>
                                                </div>
                                            </td>
                                            <td class="reorder"><?php echo  $this->Form->input('ordering_'.$package['id'],array('name' => 'data[Package]['.$package['id'].'][ordering]', 'value' => $package['ordering'], 'label' => false, 'style' => 'width:70%')) ?></td>
                                            <td class="reorder"><?php echo  $group['name'] ?></td>
                                            <td class="reorder" colspan="4" style="padding:8px 0px;">
                                                <?php if(!empty($price_plan)): ?>
                                                    <table class="table table-striped table-hover" id="sample_2">
                                                        <?php foreach($price_plan as $plan): ?>
                                                        <?php $plan = $plan['SubscriptionPackagePlan']?>
                                                        <tr id="<?php echo $package['id']?>" class="gradeX">
                                                            <td width="200" class="reorder">
                                                            	<p><b><?php echo $plan['title']?></b></p>
                                                            	<p><small><?php echo $helper->getPlanDescription($plan,$currency['Currency']['currency_code']);?></small></p>
                                                            </td>
                                                            <td width="100" class="reorder"><?php echo  $this->Form->input('order_plan'.$plan['id'],array('name' => 'data[Package]['.$package['id'].'][Plan]['.$plan['id'].'][order]','value' => $plan['order'], 'label' => false,'style' => 'width:70%')); ?></td>                                                            
                                                            <td width="100" class="reorder text-center">
                                                                <?php //echo $this->request->base.$url.'plan_do_disable/'.$plan['id']?>
                                                                <?php if ( $plan['enable_plan'] ): ?>
                                                                    <a href="#" class="enable_plan"><i class="fa fa-check-circle default checked" title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                                    <?php echo  $this->Form->hidden('enable_plan_'.$plan['id'],array('name' => 'data[Package]['.$package['id'].'][Plan]['.$plan['id'].'][enable_plan]', 'class' => 'enable_hidden', 'value' => $plan['enable_plan'])); ?>
                                                                <?php else: ?>
                                                                    <a href="#" class="enable_plan"><i class="fa fa-check-circle default" title="<?php echo __('Enable');?>"></i></a>&nbsp;
                                                                    <?php echo  $this->Form->hidden('enable_plan_'.$plan['id'],array('name' => 'data[Package]['.$package['id'].'][Plan]['.$plan['id'].'][enable_plan]', 'class' => 'enable_hidden', 'value' => 0)); ?>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td width="200" class="reorder">
                                                                <?php echo  $this->Form->select('show_at_'.$plan['id'],array(1 => __('Registration'),2 => __('Manage Membership')),array('required','class' => 'show_at_select','style'=>'width:80%;','empty' => false, 'value' => explode(',',$plan['show_at']),'multiple' => 'multiple','name' => 'data[Package]['.$package['id'].'][Plan]['.$plan['id'].'][show_at]')); ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </table>
                                                <?php endif; ?>
                                            </td>
                                            <td class="reorder">
                                                <?php echo  $this->Html->link(__('Edit'),array('plugin' => 'subscription','controller' => 'subscription_packages','action' => 'create',$package['id'])) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <?php echo $this->Paginator->first('First');?>&nbsp;
                            <?php echo $this->Paginator->hasPage(2) ? $this->Paginator->prev(__('Prev')) : '';?>&nbsp;
                            <?php echo $this->Paginator->numbers();?>&nbsp;
                            <?php echo $this->Paginator->hasPage(2) ?  $this->Paginator->next(__('Next')) : '';?>&nbsp;
                            <?php echo $this->Paginator->last('Last');?>


                            <?php else:?>
                                <?php echo __( 'No packages found');?><br />
                            <?php endif;?>
                            <a class="btn yellow-gold" data-target="#plan-view" data-toggle="modal"><?php echo  __('Preview'); ?></a>
                            <button class="btn yellow-gold"><?php echo  __('Save Changes'); ?></button>
                            <?php $this->Form->end(); ?>
                            <a href="<?php echo $this->request->base.$url_create;?>" class="btn yellow-gold">
                                <?php echo __( 'Create New Package');?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="plan-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	    <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">�</span></button>
            <div class="title-modal"><?php echo __('Subscription Plans');?></div>
		</div>
	    <iframe id="iframe_preview" style="border: 0;" height="100%" width="100%" src="<?php echo  $this->request->base; ?>/subscription/subscription_packages/preview"></iframe>
  	</div>
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $(document).ready(function(){
        $.each($('.show_at_select'),function(){
            $(this).select2();
        })
        $('.default-package').on("click",function(e){
            e.preventDefault();
            var i = $(this).find('i');
            if(i.hasClass('checked'))
            {
                i.removeClass('checked');
                i.parents('.status').find('.default-hidden').val(0);
            }
            else
            {
                $('.default-package i').removeClass('checked');
                $('.default-hidden').val(0);
                i.addClass('checked');
                i.parents('.status').find('.default-hidden').val(1);
            }
        })
        $('.recommended-package').on("click",function(e){
            e.preventDefault();
            var i = $(this).find('i');
            if(i.hasClass('checked'))
            {
                i.removeClass('checked');
                i.parents('.status').find('.recommended-hidden').val(0);
            }
            else
            {
                i.addClass('checked');
                i.parents('.status').find('.recommended-hidden').val(1);
            }
        })
        $('.enable_plan').on("click",function(e){
            e.preventDefault();
            var i = $(this).find('i');
            if(i.hasClass('checked'))
            {
                i.removeClass('checked');
                i.parent('.enable_plan').siblings('.enable_hidden').val(0);
            }
            else
            {
                i.addClass('checked');
                i.parent('.enable_plan').siblings('.enable_hidden').val(1);
            }
        })
    })

    $(document).ready(function()
	{
	  window.values = $('#changeForm').serialize();
	  $.extend(jQuery.validator.messages, {
    	required: "<?php echo addslashes(__('This field is required.'));?>"
      });
    
	  $('#changeForm').validate({submitHandler: function(form) {
	     window.save_click = true;
	    form.submit();
	  }});
	 
	})
	window.save_click = false;
	function objectsAreSame(x, y) {
	   var objectsAreSame = true;
	   for(var propertyName in x) {
	      if(x[propertyName] !== y[propertyName]) {
	         objectsAreSame = false;
	         break;
	      }
	   }
	   return objectsAreSame;
	}
	window.onbeforeunload = function(e) {	
		var checked = false;
		var values = $('#changeForm').serialize();
		if (window.values != values)
			checked = true;

		if (checked && !window.save_click)
			return '<?php echo addslashes(__('You have unsaved changes!'));?>';
	}
	
	$('#plan-view').on('shown.bs.modal', function (e) {		
	  iframe_preview.contentDocument.defaultView.jQuery('#register_content .content').attr('style','');
	  iframe_preview.contentDocument.defaultView.jQuery('#manage_content .content').attr('style','');
	  max = 0;
	  iframe_preview.contentDocument.defaultView.jQuery('#register_content .content').each(function(e){
	  	if ($(this).height() > max)
	 		max = $(this).height();
	  });
	  
	  iframe_preview.contentDocument.defaultView.$('#register_content .content').each(function(e){
			$(this).css('height',parseInt($(this).css('padding-top').replace("px", "")) + parseInt($(this).css('padding-bottom').replace("px", "")) + max + 10);
	  });
	  
	  max = 0;
	  iframe_preview.contentDocument.defaultView.jQuery('#manage_content').show();
	  iframe_preview.contentDocument.defaultView.jQuery('#manage_content .content').each(function(e){
	    
	  	if ($(this).height() > max)
	 		max = $(this).height();
	  });
	  iframe_preview.contentDocument.defaultView.jQuery('#manage_content').hide();

	  iframe_preview.contentDocument.defaultView.$('#manage_content .content').each(function(e){
			$(this).css('height',parseInt($(this).css('padding-top').replace("px", "")) + parseInt($(this).css('padding-bottom').replace("px", "")) + max + 10);
	  });
	  
	  $('#iframe_preview').css('height',iframe_preview.contentDocument.defaultView.$('#content').height() + 40);
	})
<?php $this->Html->scriptEnd(); ?>
<style>
    a .checked{
        color:#00ff00;
    }
    .default{
        color: grey;
    }
</style>