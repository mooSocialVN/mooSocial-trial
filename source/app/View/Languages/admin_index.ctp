<script>
jQuery(document).ready(function(){
    initTabs('language_index');
});
</script>

<?php
echo $this->element('admin/adminnav', array("cmenu" => "languages"));
?>
 
<div id="center">	
	<h1>Languages Manager</h1>
		
	<div id="language_index">
        <div class="tabs-wrapper">
            <ul class="tabs">
                <li id="installed" class="active">Installed Languages</li>
                <li id="not_installed">Not Installed Languages</li> 
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
                <?php foreach ($languages as $language): ?>
                <tr>
                    <td><?php echo $language['Language']['id']?></td>
                    <td><a href="<?php echo $this->request->base?>/admin/languages/ajax_edit/<?php echo $language['Language']['id']?>" class="overlay" title="Edit Language Name"><?php echo h($language['Language']['name'])?></a></td>
                    <td><?php echo $language['Language']['key']?></td>
                    <td><?php if ( $language['Language']['key'] != 'eng' ): ?>
                        <a href="<?php echo $this->request->base?>/admin/languages/do_uninstall/<?php echo $language['Language']['id']?>"><i class="tip icon-trash icon-small" title="Uninstall"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
        
        <div id="not_installed_content" class="tab">
            <ul class="list6">
            <?php foreach ($not_installed_languages as $language): ?>
                <li><?php echo $language?>
                   <div style="float:right">
                       <a href="<?php echo $this->request->base?>/admin/languages/do_install/<?php echo $language?>">Install</a>
                   </div>    
                </li>
            <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>