<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
?>

<script>
jQuery(document).ready(function(){
	jQuery( ".mooTable" ).sortable( {
        items: "tr:not(.tbl_head)", 
        handle: ".reorder",
        update: function(event, ui) {
            var list = jQuery('.mooTable').sortable('toArray');
            jQuery.post('<?php echo $this->request->base?>/admin/plugins/ajax_reorder', { plugins: list });
        }
    });
	
	initTabs('plugin_index');
	$('.footable').footable();
});
</script>

<?php
echo $this->element('admin/adminnav', array("cmenu" => "plugins"));
?>

<div id="center">	
	<h1>Plugins Manager</h1>
	
	<div id="plugin_index">
    	<div class="tabs-wrapper">
    		<ul class="tabs">
    			<li id="installed" class="active">Installed Plugins</li>
    			<li id="not_installed">Not Installed Plugins</li>	
    		</ul>
    	</div>
    	<div id="installed_content" class="tab" style="display:block">
    		<table class="mooTable footable" cellpadding="0" cellspacing="0">
    			<thead>
    			<tr class="tbl_head">
    				<th>ID</th>
    				<th>Name</th>
    				<th>Key</th>
    				<th data-hide="phone">Version</th>    				
    				<th data-hide="phone">Menu</th>
    				<th data-hide="phone">Enabled</th>
    				<th data-hide="phone">Actions</th>
    			</tr>
    			</thead>
    			<tbody>
    			<?php foreach ($plugins as $plugin): ?>
    			<tr id="<?php echo $plugin['Plugin']['id']?>">
    				<td><?php echo $plugin['Plugin']['id']?></td>
    				<td><i class="<?php echo $plugin['Plugin']['icon_class']?> icon-small"></i> <a href="<?php echo $this->request->base?>/admin/plugins/ajax_view/<?php echo $plugin['Plugin']['id']?>" class="overlay" title="<?php echo h($plugin['Plugin']['name'])?> Plugin"><?php echo h($plugin['Plugin']['name'])?></a></td>
    				<td class="reorder"><?php echo $plugin['Plugin']['key']?></td>
    				<td class="reorder"><?php echo $plugin['Plugin']['version']?></td>
    				<td class="reorder"><?php echo ($plugin['Plugin']['menu'])?'Yes':'No'?></td>
    				<td class="reorder"><?php echo ($plugin['Plugin']['enabled'])?'Yes':'No'?></td>
    				<td><?php if ( $plugin['Plugin']['enabled'] ): ?>
    				    <a href="<?php echo $this->request->base?>/admin/plugins/do_disable/<?php echo $plugin['Plugin']['id']?>"><i class="tip icon-remove icon-small" title="Disable"></i></a>&nbsp;
    				    <?php else: ?>
    				    <a href="<?php echo $this->request->base?>/admin/plugins/do_enable/<?php echo $plugin['Plugin']['id']?>"><i class="tip icon-check icon-small" title="Enable"></i></a>&nbsp;
    				    <?php endif; ?>
    				    <?php if ( !$plugin['Plugin']['core'] ): ?>
    				    <a href="<?php echo $this->request->base?>/admin/plugins/do_uninstall/<?php echo $plugin['Plugin']['id']?>"><i class="tip icon-trash icon-small" title="Uninstall"></i></a>&nbsp;
    	                <a href="<?php echo $this->request->base?>/admin/plugins/do_download/<?php echo $plugin['Plugin']['key']?>" target="_blank"><i class="tip icon-download-alt icon-small" title="Download"></i></a>
    	                <?php endif; ?>
    	            </td>
    			</tr>
    			<?php endforeach ?>
    			</tbody>
    		</table>
    	</div>
    	
    	<div id="not_installed_content" class="tab">
    		<ul class="list6">
    		<?php foreach ($not_installed_plugins as $plugin): ?>
    			<li><?php echo $plugin?>
    	           <div style="float:right">
    	               <a href="<?php echo $this->request->base?>/admin/plugins/do_install/<?php echo $plugin?>">Install</a>
    	           </div>    
    			</li>
    		<?php endforeach ?>
    		</ul>
    	</div>
    </div>
</div>