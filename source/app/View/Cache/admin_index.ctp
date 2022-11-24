<?php
echo $this->Html->css(array('jquery-ui','pickadate', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui','pickadate/picker', 'pickadate/picker.date','footable'), array('inline' => false));
$this->Paginator->options(array('url' => $this->passedArgs));
$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Caches Manager'), array('controller' => 'cache', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "cache"));
$this->end();
?>

<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <form class="form-horizontal" id="form" method="post" enctype="multipart/form-data" action="">
			    <div class="form-body">
			    	<div class="form-group">
			            <label class="col-md-3 control-label">
			            	<?php echo __('Caching Type');?>			               
			            </label>
			            <div class="col-md-7">
			                <select class="form-control" name="engine" id="engine">
			                	<?php foreach ($caches as $key=>$cache): ?>
			                		<option <?php if ($key == $config['engine']) echo 'selected'?> value="<?php echo $key;?>">
			                			<?php echo $cache['name']?>
			                		</option>
			                	<?php endforeach;?>
							</select>
			            </div>			            
			         </div>
			         <?php foreach ($caches as $key=>$cache): ?>
		            	<?php if (isset($cache['params'])):?>
		            		<?php foreach ($cache['params'] as $name=>$param):?>
	            				<div class="form-group setting_all <?php echo $key?>">
						            <label class="col-md-3 control-label">
						            	<?php echo $param['label'];?>			               
						            </label>
						            <div class="col-md-7">
						            	<?php if ($param['type']== 'text'):?>
						            		<?php
						            		echo $this->Form->text($key.$name, array(
						                			'label' => '',
						            				'value'=> isset($config[$name]) && $key == $config['engine'] ? $config[$name]: '',
						                			'class' => 'form-control'
							                	));
						                	?>						                	
						                <?php elseif ($param['type']== 'checkbox'):?>
						                	<?php
						                		echo $this->Form->input($key.$name, array(
						                			'type' => 'checkbox',
						                			'checked' => isset($config[$name]) && $key == $config['engine']? $config[$name]: false,
						                			'label' => '',
							                	));
						                	?>
						                <?php endif;?>
						            </div>			            
						         </div>		            			
		            		<?php endforeach;?>
		            	<?php endif;?>
		            <?php endforeach;?>
				</div>
				<div class="form-actions">
			        <div class="row">
			        	<div class="col-md-offset-3 col-md-9">
			            	<input type="submit" class="btn btn-circle btn-action" value="<?php echo __('Save Settings')?>">
			            </div>
			        </div>
			    </div>
			</form>
			<div class="alert alert-danger error-message" style="display:none;margin-top:10px;">
    		</div>			
		</div>
	</div>
</div>	
<?php $this->Html->scriptStart(array('inline' => false)); ?>
function changeCache()
{
	$('.setting_all').hide();
	$('.' + $('#engine').val()).show();
}
var checked = false;
$( document ).ready(function() {
   	$('#engine').change(function(){
   		changeCache();
   	});
	changeCache();
	
	$("#form").submit(function(e){
		if ($('#engine').val() == "File")
		{
			return;
		}
		if (!checked)
		{
        	e.preventDefault();
        	params = {};
        	$('.' + $('#engine').val() + ' input').each(function(){
        		params[$(this).attr('name')] = $(this).val();
        	});
        	$.post("<?php echo  $this->request->base ?>/admin/cache/check_" + $('#engine').val().toLowerCase(), params, function (data) {
				try
				{
					var json = $.parseJSON(data);

					if (json.status == 1)
					{
						checked = true
						$("#form").trigger('submit');
					}
					else
					{
						$(".error-message").show();
						$(".error-message").html(json.message);
					}
				}
				catch(err) {
					$(".error-message").show();
					$(".error-message").html('<?php echo __('Error when connect');?>');
				}
            });
        }
    });
});
<?php $this->Html->scriptEnd(); ?>