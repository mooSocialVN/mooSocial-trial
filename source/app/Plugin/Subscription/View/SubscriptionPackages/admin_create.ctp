<?php
echo $this->Html->script(array('admin/layout/scripts/option.js?'.Configure::read('core.version'),'jquery.validate.min','global/select2/select2.min.js?'.Configure::read('core.version')), array('inline' => false));
echo $this->Html->css(array('select2/select2','jquery.validate'), null, array('inline' => false));
echo $this->Html->script(array('tinymce/tinymce.min'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Managed Packages'), $url);
$this->Html->addCrumb(empty($package['id']) ? __( 'Create Package') :  __( 'Edit Package'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "packages"));
$this->end();

?>
<style type="text/css">
.check_duration
{
	color:red;
}
</style>
<?php $isEdit = (!empty($pricingPlan))?false:true; ?>
<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('Subscription', __('Manage Packages'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <?php
                                echo $this->Form->create('SubscriptionPackage', array(
                                    'class' => 'form-horizontal',
                                    'url' => $url.'save/',
                                	'novalidate' => 'novalidate'                                   
                                ));
                            ?>
                                <div class="form-body">
                                    <?php echo $this->Form->hidden('id', array('value' => $package['id'])); ?>
                                    <?php echo $this->Form->hidden('check_change', array('id' =>'check_change')); ?>
                                    <?php echo $this->Form->hidden('delete_plan_id'); ?>
                                    <h4><?php echo  __('Package')  ?></h4>
                                    <?php if ($package['id']):?>
	                                    <div class="form-group">
							                <label class="col-md-3 control-label"><?php echo __('Language Pack');?>(<a data-html="true" href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __('Select a language to translate for page title and page content only'); ?>" data-placement="top">?</a>)</label>
							                <div class="col-md-6">
							                    <?php echo $this->Form->select('language', $languages, array('id'=>'language','class'=>'form-control language','value'=>$language,'empty'=>false)); ?>
							                </div>
							            </div>
						            <?php endif;?>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __( 'Name');?></label>
                                        <div class="col-md-6">
                                            <?php
                                                echo $this->Form->input('name', array(
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'value' => $package['name']
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __( 'Description');?></label>
                                        <div class="col-md-6">
                                            <?php
                                                echo $this->Form->textarea('description', array(
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'value' => $package['description']
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __( 'User Role');?></label>
                                        <div class="col-md-4">
                                            <?php
                                                echo $this->Form->input('role_id', array(
                                                    'options' => $cbGroup,
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'empty' => '--Select--',
                                                    'value' => $package['role_id'],
                                                    'disabled' => !$isEdit,
                                                ));
                                            ?>
                                            <?php echo __( "The member will be upgraded to this level upon subscribing to this plan.");?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __( 'Make Default Package');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Make the top plan of this package as a default selection');?>" data-placement="top">?</a>)</label>
                                        <div class="col-md-4">
                                            <?php
                                            echo $this->Form->input('default', array(
                                                'type' => 'checkbox',
                                                'label' => false,
                                                'checked' => $package['default'],
                                            ));
                                            ?>                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __( 'Recommend Package');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __("a 'Recommended' sticker will be shown on this package in comparison popup if selected");?>" data-placement="top">?</a>)</label>
                                        <div class="col-md-4">
                                            <?php
                                            echo $this->Form->input('recommended', array(
                                                'type' => 'checkbox',
                                                'label' => false,
                                                'checked' => $package['recommended'],
                                            ));
                                            ?>
                                        </div>
                                    </div>

                                    <div id="all-pricing-plan" style="overflow: hidden">
                                        <div class="pricing-plan">
                                            <div class="head-info" style="overflow: hidden">
                                                <h4 class="col-md-8"><?php echo  __('Plan Type') ?> 1</h4>
                                                <a class="col-md-4 pull-right delete-plan margin-top-10 margin-bottom-10" href="#"><?php echo  __('Delete Plan') ?></a>
                                            </div>
                                            <div class="form-group pricing-plan-select">
                                                <label class="col-md-3 control-label"><?php echo __( 'Plan Type');?>(<a data-html="true" class="tooltips" data-original-title="<?php echo __('Plan Type');?>" data-placement="top">?</a>)</label>
                                                <div class="col-md-2">
                                                    <?php
                                                    $planOption = array(SUBSCRIPTION_ONE_TIME=> __('One Time'),SUBSCRIPTION_RECURRING => __('Recurring'), SUBSCRIPTION_TRIAL_RECURRING => __('Trial + Recurring'), SUBSCRIPTION_TRIAL_ONE_TIME => __('Trial + One Time') );
                                                    echo $this->Form->input('type', array(
                                                        'options' => $planOption,
                                                        'class' => 'form-control select-plan',
                                                        'label' => false,
                                                        'empty' => false,
                                                        'value' => SUBSCRIPTION_ONE_TIME,
                                                        'name' => 'data[PricingPlan][][type]'
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="plan-detail"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-4">
                                                <a id="add_price_plan" href="#"><i class="fa fa-plus"></i> <?php echo  __('Add another pricing plan')?></a>
                                        </div>
                                    </div>


                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button id="createButton" class="btn btn-circle btn-action"><i class="icon-save"></i> <?php echo __( 'Save Changes');?></button>
                                            <?php if($isEdit && $package['id']): ?>
                                            <button onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this package? All plan on this package will be remove too'));?>','<?php echo  $this->request->base.'/admin/subscription/subscription_packages/delete/'.$package['id']; ?>'); return false;" class="btn btn-circle btn-action"> <?php echo __( 'Delete Package');?></button>
                                            <?php endif; ?>
                                            <a href="<?php echo $this->base?>/admin/subscription/subscription_packages" class="btn btn-circle default"><?php echo __('Back');?></a>
                                        </div>

                                    </div>
                                </div>
                            <?php echo $this->Form->end();?>

                                    <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
    var json;
    var firstPricingPlan;
    var number = 1;
    var edit = <?php echo  (!empty($pricingPlan)?1:0); ?> ;
    var count_plan;
    var pricingPlan;
    var deletedPlan = [];
    jQuery(window).load(function(){
        get_pricing_plan();
        firstPricingPlan = $('#all-pricing-plan .pricing-plan').clone();
    })
    function get_pricing_plan()
    {
        $.post(mooConfig.url.base+'/admin/subscription/subscription_packages/pricing_plan',null, function(response){
            try
            {
                json = jQuery.parseJSON(response);
                if(!edit)
                {
                	$('#SubscriptionPackageType').find('option').each(function(){
						if ($(this).attr('value') == 4)
						{
							$(this).remove();
						}
					});
                    load_pricing_plan();
                }
                else{
                    //get quantity of pricing plans;
                    count_plan = <?php echo  (!empty($pricingPlan))?count($pricingPlan):0; ?>;
                    pricingPlan = <?php echo  (!empty($pricingPlan))?json_encode($pricingPlan):0; ?>;
                    load_edit_pricing_plan();

                }
                window.values = $($("#SubscriptionPackageAdminCreateForm")[0].elements).not("#language").serialize();
            }
            catch(err)
            {
                json = '';
            }
        });
    }
    function load_pricing_plan(div,value, is_edit)
    {
        var plan_detail;
        var divType = typeof(div);
        var valueType = typeof(value);
        if(divType !== 'undefined')
            plan_detail = div.find('.plan-detail');
        else
            plan_detail = $('.plan-detail');
        if(json != '')
        {
            if(divType === 'undefined' && valueType === 'undefined')
                plan_detail.html(decodeHtml(json.oneTime));
            else{
                switch(value){
                    case <?php echo SUBSCRIPTION_ONE_TIME;?>:
                        plan_detail.html(decodeHtml(json.oneTime));
                        break;
                    case <?php echo SUBSCRIPTION_RECURRING;?>:
                        plan_detail.html(decodeHtml(json.recurring));
                        if (is_edit === undefined)
                        {
                        	tmp = number - 1;
                        	plan_detail.find('#plan_type' + tmp).find('option').each(function(){
								$(this).removeAttr('disabled');
								if ($(this).attr('value') != 1 && $(this).attr('value') != 5)
								{
									$(this).attr('disabled','disabled');
								}
							});
                        }
                        
                        break;
                    case <?php echo SUBSCRIPTION_TRIAL_RECURRING;?>:
                        plan_detail.html(decodeHtml(json.trialRecurring));
                        if (is_edit === undefined)
                        {
                        	tmp = number - 1;
                        	plan_detail.find('#plan_type' + tmp).find('option').each(function(){
								$(this).removeAttr('disabled');
								if ($(this).attr('value') != 1 && $(this).attr('value') != 5)
								{
									$(this).attr('disabled','disabled');
								}
							});
                        }
                        
                        break;
                    case <?php echo SUBSCRIPTION_TRIAL_ONE_TIME;?>:
                        plan_detail.html(decodeHtml(json.trialOneTime));
                        break;
                    default:
                        plan_detail.html(decodeHtml(json.oneTime));
                }
            }
            //init multi select
            multiShowInit('show_at'+(number-1));
        }
        
        $('.tooltips').tooltip(); 
    }
    function decodeHtml(html){
        var txt = document.createElement("textarea");
        txt.innerHTML = html;
        var result = txt.value.replace(/PricingPlanNum/g,'data[PricingPlan]['+(number-1)+']');
        var result = result.replace(/NUMID/g,(number-1));
        return result;
    }

    function load_edit_pricing_plan()
    {
        var editPricingPlan;
        for(var i = 0; i < count_plan; i++ )
        {
            editPricingPlan = firstPricingPlan.clone();
            editPricingPlan.find('.pricing-plan-select select').attr('id','PackageType'+number)
            editPricingPlan.find('.pricing-plan-select select').attr('name','data[PricingPlan]['+(number-1)+'][type]')
            editPricingPlan.find('.pricing-plan-select select').attr('disabled',true);
            editPricingPlan.find('h4').html('<?php echo  addslashes(__('Plan Type')) ?> '+number);
            editPricingPlan.find('.delete-plan').attr('data-id',pricingPlan[i].id);
            editPricingPlan.find('#PackageType'+number).val(pricingPlan[i].type);
            editPricingPlan.prepend('<input type="hidden" name="data[PricingPlan]['+(number-1)+'][id]" value="'+pricingPlan[i].id+'"/>');

            if(i == 0)
                $('#all-pricing-plan .pricing-plan').remove();
            $('#all-pricing-plan').append(editPricingPlan);
            var div = $('#all-pricing-plan .pricing-plan').last();
            load_pricing_plan(div,parseInt(pricingPlan[i].type),true);
            load_value_plan(div,pricingPlan[i]);
            if (div.find('.check_duration').length > 0)
            	div.find('.check_duration').removeClass('check_duration'); 
            number++;
        }
        number--;
        
        $('.tooltips').tooltip(); 
    }

    function load_value_plan(div, oPricing){
        var convert = {"day" : 1 ,'week' : 2, 'month' : 3, 'year' : 4, 'forever' : 5}
        var edited = ["title", "show_at", "enable_plan","android_product_id","ios_product_id"];
        $.each(oPricing,function(key, value){
            if(convert.hasOwnProperty(value))
                div.find('#'+key+(number-1)).val(convert[value]);
            else if(key == 'show_at'){
                div.find('#'+key+(number-1)).val(value.split(','));
                multiShowInit(key+(number-1));
            }
            else if(key == 'enable_plan'){
                div.find('#'+key+(number-1)).attr('checked',value);
                div.find('#'+key+(number-1)).val(value);
            }
            else
                div.find('#'+key+(number-1)).val(value);
            if (edited.indexOf(key) == -1)
            	div.find('#'+key+(number-1)).attr('disabled',true)
        })
    }
    function viewExample()
    {
        if(!jQuery('#subExample').is(':visible'))
        {
            jQuery('#subExample').show();
        }
        else
        {
            jQuery('#subExample').hide();
        }
    }

    function multiShowInit(id)
    {
        $("#"+id+"").select2();
    }

    jQuery(document).on('change', '.select-plan', function(){
        div = $(this).parents('.pricing-plan');
        load_pricing_plan(div,parseInt(jQuery(this).val()));
    })
    jQuery('#add_price_plan').click(function(e){
        e.preventDefault();
        number++;
        var lastPricingPlan;
        firstPricingPlan.find('.pricing-plan-select select').attr('id','PackageType'+(number-1))
        firstPricingPlan.find('.pricing-plan-select select').find('option').each(function(){
			if ($(this).attr('value') == 4)
			{
				$(this).remove();
			}
		});
        firstPricingPlan.find('.pricing-plan-select select').attr('name','data[PricingPlan]['+(number-1)+'][type]')
        firstPricingPlan.find('h4').html('<?php echo  addslashes(__('Plan Type')) ?> '+number);
        $('#all-pricing-plan').append(firstPricingPlan);
        lastPricingPlan = $('#all-pricing-plan .pricing-plan').last();
        firstPricingPlan = lastPricingPlan.clone();
        load_pricing_plan(lastPricingPlan,1);
    })
    jQuery('#all-pricing-plan').on('click','.delete-plan',function(e){
        //e.preventDefault();
        if(typeof($(this).attr('data-id')) !== 'undefined'){
            var data_id = $(this).attr('data-id');
            var thisDiv = $(this);
            mooConfirmBox('<?php echo addslashes(__('Are you sure you want to delete this plan?'));?>',function(){
            	number--;
                deletedPlan.push(data_id);
                $('#SubscriptionPackageDeletePlanId').val(deletedPlan);
                thisDiv.parents('.pricing-plan').remove();
                
                refeshHeader();
            });
        }
        else
        {
            $(this).parents('.pricing-plan').remove();
            refeshHeader();
            number--;
        }
        return false;
    });
    function refeshHeader()
    {
    	var index = 1;
    	$('.head-info').each(function(e){
    		$(this).find('h4').html('<?php echo  addslashes(__('Plan Type')) ?> '+index);    		
    		index++;
    	});
    }
    $.extend(jQuery.validator.messages, {
    	required: "<?php echo addslashes(__('This field is required.'));?>"
    });

    $(document).ready(function()
	{
	
		$('#language').change(function(e){
            window.location.href = "<?php echo $this->request->base;?>/admin/subscription/subscription_packages/create/<?php echo $package['id'];?>/" +$('#language').val();
        });
        
        tinymce.init({
            selector: "textarea",
            language : mooConfig.tinyMCE_language,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code",
                "insertdatetime nonbreaking save table contextmenu directionality",
                "emoticons template textcolor"
            ],
            toolbar1: "fontselect | fontsizeselect | styleselect | bold italic | outdent indent | forecolor backcolor emoticons | image link unlink anchor | preview code",
            image_advtab: true,
            image_dimensions: false,
            theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
            height: 300,
            relative_urls : false,
            remove_script_host : false,
            document_base_url : '<?php echo FULL_BASE_URL . $this->request->root?>',
            convert_urls: false,
            setup: function(editor) {
                editor.on('change', function(e) {
                    $('#check_change').val(1);
                });
            },
            directionality : mooConfig.site_directionality
        });

	    window.save_click = false;
	    $("#SubscriptionPackageAdminCreateForm").validate({submitHandler: function(form) {
	    	checked = true;
	    	$('.check_duration').each(function(){
	    		tmp = $(this);
	    		tmp.hide();
	    		
	    		type = tmp.parents('.form-group').find('select');
	    		if (type.val() != 5)
	    		{
	    			value = tmp.parents('.plan-detail').prev().find('select').val();
	    			
	    			compare1 = tmp.prev().val();
	    			compare1 = parseInt(compare1);
	    			compare2 = tmp.parents('.form-group').prev().find('input').val();
	    			compare2 = parseInt(compare2);
	    			if (value == <?php echo SUBSCRIPTION_TRIAL_RECURRING;?>)
	    			{
		    			if (compare1 < compare2)
		    			{
		    				tmp.show();
		    				checked = false;
		    			}
	    			}
	    			else
	    			{
	    				if (compare1 <= compare2)
		    			{
		    				tmp.show();
		    				checked = false;
		    			}
	    			}
	    		}
	    	});
	    	if (checked)
	    	{
	     		window.save_click = true;
		    	form.submit();
		    	return true;
		    }
		    return false;
	  	}});
	});
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
	
	$('#portlet-config').on('hidden.bs.modal', function (e) {
	  window.save_click = false;
	})
	window.onbeforeunload = function(e) {	
		var checked = false;
		var values = $($("#SubscriptionPackageAdminCreateForm")[0].elements).not("#language").serialize();;
		if (window.values != values)
			checked = true;

		if (checked && !window.save_click)
			return '<?php echo addslashes(__('You have unsaved changes!'));?>';
	}
	var typeChange = function(e)
	{
		current = $(e);
		tmp = $(e).parents('.form-group').next().find('select');
		tmp.val(current.val());
		
		tmp.find('option').each(function(){
			$(this).removeAttr('disabled');
			if ($(this).attr('value') != current.val() && $(this).attr('value') != 5)
			{
				$(this).attr('disabled','disabled');
			}
		});
	}
    
<?php $this->Html->scriptEnd(); ?>