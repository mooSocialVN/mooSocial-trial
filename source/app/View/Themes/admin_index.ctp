<script>
jQuery(document).ready(function(){
    initTabs('theme_index');
});
</script>

<?php
echo $this->element('admin/adminnav', array("cmenu" => "themes"));
?>
 
<div id="center">	
	<a href="<?php echo $this->request->base?>/admin/themes/ajax_create" class="overlay button button-action topButton" title="Create New Theme">Create New Theme</a>
	
	<h1>Themes Manager</h1>
	
	<div class="box1">
	    To customize the template files for your custom theme, click mooSocial Base Theme -> navigate to the template file you want to modify -> click Copy and select your theme. Click Go to make a copy of the template file in your theme folder. Now you can make changes to the file without affecting the base theme.
        Any changes made to the base theme will be overwritten when you upgrade the software.
        Changes in your custom theme will not be affected after upgrading. This means you don't have to redo your changes but if the base theme was changed in the new version, your custom theme will need to be updated (manually) as well.        
	</div>
	
	<h2>Base Theme</h2>
	<ul class="list6">
		<li><a href="<?php echo $this->request->base?>/admin/themes/editor">mooSocial</a></li>
	</ul>
	<br />
	
	<div id="theme_index">
        <div class="tabs-wrapper">
            <ul class="tabs">
                <li id="installed" class="active">Installed Themes</li>
                <li id="not_installed">Not Installed Themes</li> 
            </ul>
        </div>
        <div id="installed_content" class="tab" style="display:block">
            <table class="mooTable" cellpadding="0" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Key</th>
                    <th width="70">Actions</th>
                </tr>
                <?php foreach ($themes as $theme): ?>
                <tr>
                    <td><?php echo $theme['Theme']['id']?></td>
                    <td><a href="<?php echo $this->request->base?>/admin/themes/editor/<?php echo $theme['Theme']['id']?>"><?php echo h($theme['Theme']['name'])?></a></td>
                    <td><?php echo $theme['Theme']['key']?></td>
                    <td><a href="<?php echo $this->request->base?>/admin/themes/do_uninstall/<?php echo $theme['Theme']['id']?>"><i class="tip icon-trash icon-small" title="Uninstall"></i></a>&nbsp;
                        <a href="<?php echo $this->request->base?>/admin/themes/do_download/<?php echo $theme['Theme']['key']?>" target="_blank"><i class="tip icon-download-alt icon-small" title="Download"></i></a>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
        
        <div id="not_installed_content" class="tab">
            <ul class="list6">
            <?php foreach ($not_installed_themes as $theme): ?>
                <li><?php echo $theme?>
                   <div style="float:right">
                       <a href="<?php echo $this->request->base?>/admin/themes/do_install/<?php echo $theme?>">Install</a>
                   </div>    
                </li>
            <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>