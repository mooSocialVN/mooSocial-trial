<?php
echo $this->Html->css(array('/menu/css/main'), null, array('inline' => false));
echo $this->Html->css(array('jquery-ui'), null, array('inline' => false));
$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Menu Manager'), array('controller' => 'manage', 'action' => 'admin_index'));
$this->Html->addCrumb(__( 'Menu Profile'), array('controller' => 'manage', 'action' => 'admin_profile'));
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "menu"));
$this->end();
?>
<style>
	.item-controls
	{
		border: 1px solid;
		width: 60px;
		text-align: center;
		cursor: pointer;
	}
	.item-controls.active
	{
		color:#2BC52C;
		border: 1px solid #2BC52C;
	}
	.menu-item-handle
	{
		cursor: move;
	}
</style>
<?php
$menus = $this->Moo->getMenuProfiles(false);
?>

<div>
	<div>
		<?php echo __('Drag to reorder');?>
	</div>
	<ul class="menu ui-sortable" id="menu-to-edit">
		<?php foreach ($menus as $menu):?>
			<li id="<?php echo $menu['name']?>" class="menu-item">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo $menu['text']?></span>
							<span data-id="<?php echo $menu['name'];?>" class="item-controls <?php echo $menu['enable'] ? 'active' : ''?>">
								<span class="item-type"><?php if ($menu['enable']) echo __('Active'); else echo __('Disable');?></span>					
							</span>
					</span>
					</dt>
				</dl>	
			</li>
		<?php endforeach;?>
	</ul>
</div>

<?php echo $this->Html->scriptStart(array('inline' => false)); ?>
$(document).ready(function(){
  	$('.item-controls').click(function(){
  		var e = $(this);
  		
  		$($('#portlet-config  .modal-header .modal-title')[0]).html('<?php echo __('Please Confirm');?>');
        // Set content
        var msg;
        if ($(this).hasClass('active'))
        {
        	msg = '<?php echo __('Do you want to disable this menu');?>';
        }
        else
        {
        	msg = '<?php echo __('Do you want to enable this menu');?>';
        }
        
        $($('#portlet-config  .modal-body')[0]).html(msg);
        // OK callback
        $('#portlet-config  .modal-footer .ok').unbind('click');
        $('#portlet-config  .modal-footer .ok').click(function(){
            $('#portlet-config').modal('hide');
            if (e.hasClass('active'))
            {
            	e.find('.item-type').html('<?php echo __('Disable');?>');
            }
            else
            {
            	e.find('.item-type').html('<?php echo __('Active');?>');
            }
            e.toggleClass('active');
            console.log(e.data('id'));
            $.ajax({
                url: '<?php echo $this->request->base.'/admin/menu/manage/profile_update';?>',
                type: 'POST',
                data: {
                    name: e.data('id')
                }
            }).done(function(a) {
            });
            
            
        });
        $('#portlet-config').modal('show');
  	});
  	
  	$( "#menu-to-edit" ).sortable( {
  		items: ".menu-item", 
		update: function(event, ui) {
			var list = jQuery('#menu-to-edit').sortable('toArray');
			jQuery.post('<?php echo $this->request->base?>/admin/menu/manage/profile_reorder', { fields: list });
		}
	});
});
<?php echo $this->Html->scriptEnd(); ?>