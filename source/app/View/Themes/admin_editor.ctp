<?php
echo $this->Html->css(array( 'codemirror' ), null, array('inline' => false));
echo $this->Html->script(array('codemirror/codemirror',
							   'codemirror/javascript',
							   'codemirror/css',
							   'codemirror/clike',
							   'codemirror/xml',
							   'codemirror/php',
							   'codemirror/htmlmixed',
							   'codemirror/htmlembedded'), array('inline' => false));
?>

<script>
var editor;
var current_file;
var current_type;

function openFile(path, type, obj) {
	jQuery('.current').removeClass('current');
	jQuery(obj).parent().addClass('current');
	jQuery(obj).spin('tiny');
	jQuery.post('<?php echo $this->request->base?>/admin/themes/ajax_open_file', { key: '<?php echo $theme['Theme']['key']?>', type: type, path: path }, function(data)
	{
		jQuery(obj).spin(false);
		jQuery('#code').val(data);
		jQuery('.CodeMirror').remove();
		jQuery('#path').html(path);
		
		var mode = 'application/x-httpd-php';
		if ( type == 'css' )
			mode = 'text/css';
		
		editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		    lineNumbers: true,
		    matchBrackets: true,
		    mode: mode,
		    indentUnit: 4,
		    indentWithTabs: true
	  	});
	  	
	  	current_file = path;
		current_type = type;
	  	
	  	jQuery('#saveButton').show();
	  	jQuery('#copyButton').show();			
		jQuery('#theme_info').hide();
	});	
}

function openFolder(path, type, obj) {
	
	if ( jQuery(obj).next().length )
		jQuery(obj).next().slideToggle();
	else
	{	
		jQuery(obj).spin('tiny');
		jQuery.post('<?php echo $this->request->base?>/admin/themes/ajax_open_folder', { key: '<?php echo $theme['Theme']['key']?>', type: type, path: path }, function(data)
		{
			jQuery(obj).spin(false);
			jQuery(obj).after(data);
		});	
	}
}

function saveFile() {
	disableButton('saveButton');
	jQuery.post('<?php echo $this->request->base?>/admin/themes/ajax_save_file', { key: '<?php echo $theme['Theme']['key']?>', path: current_file, type: current_type, content: editor.getValue() }, function(data)
	{
		enableButton('saveButton');		
	});	
}

function showCopy() {
	jQuery('#copy').slideDown();		
}

function copyFile()
{
	$.fn.SimpleModal({
        btn_ok: '<?php echo addslashes(__('OK'))?>',
        callback: function(){
            disableButton('proceedButton');
            $.post('<?php echo $this->request->base?>/admin/themes/ajax_copy', { key: $('#theme').val(), path: current_file }, function(data) {
                enableButton('proceedButton');
                
                if ( data == '' )
                    mooAlert('Template has been copied successfully');        
            }); 
        },
        title: '<?php echo addslashes(__('Please Confirm'))?>',
        contents: "This will overwrite any existing file in the theme folder. Proceed?",
        model: 'confirm', hideFooter: false, closeButton: false        
    }).showModal();
    return false;
}
</script>

<style>
#files_browser {
    margin: 5px 0;
}
#files_browser ul ul {
	margin: 0 0 0 7px;
}
#files_browser li a {
	padding: 4px 8px !important;
	font-size: 11px;
}
</style>

<div id="leftnav">
	<div id="files_browser"> 
		<?php if ( !empty($css_files) ): ?>
		<strong>Stylesheets</strong>
		<?php echo $this->element('misc/themed_files', array('files' => $css_files, 'type' => 'css')); ?>
		<?php endif; ?>
		
		<strong>Views</strong>
		<?php echo $this->element('misc/themed_files', array('files' => $view_files, 'type' => 'view')); ?>
	</div>
</div>

<div id="center">		
	<a href="<?php echo $this->request->base?>/admin/themes" class="topButton button"><i class="icon-mail-reply"></i>  Back</a>
	<a href="javascript:void(0)" onclick="saveFile()" style="display: none" id="saveButton" class="topButton button button-action"><i class="icon-save"></i> Save</a>
	<?php if ( empty( $theme['Theme']['key'] ) ): ?>
	<a href="javascript:void(0)" onclick="showCopy()" style="display: none" id="copyButton" class="topButton button button-primary"><i class="icon-copy"></i> Copy</a>
	<?php endif; ?>
	
	<h1><?php echo $theme['Theme']['name']?></h1>
	
	<div id="path" style="margin-bottom: 10px"></div>	
	
	<?php if ( empty( $theme['Theme']['key'] ) ): ?>
	<div class="box1" id="copy" style="display:none">
		Copy this template to
		<?php echo $this->Form->select('theme', $installed_themes, array('empty' => false)); ?>
		<a href="#" onclick="copyFile()" class="button button-action" id="proceedButton"><i class="icon-ok"></i> Proceed</a>
	</div>	 
	<div id="theme_info">
		<h2>Theme Info</h2>
		This is the base theme of mooSocial. All themes inherits the template files from this theme. To override a template file, select it on the left column and copy it to your theme.
	</div>
	<?php else: ?>
	<div id="theme_info">
		<h2>Theme Info</h2>
		<ul class="list6 info">
			<li><label>Name</label><?php echo $info->name?></li>
			<li><label>Key</label><?php echo $info->key?></li>
			<li><label>Version</label><?php echo $info->version?></li>
			<li><label>Author</label><?php echo $info->author?></li>
			<li><label>Website</label><?php echo $info->website?></li>
			<li><label>Description</label><?php echo $info->description?></li>
		</ul>
	</div>
	<?php endif; ?>
	<textarea id="code" style="display:none"></textarea>
</div>
