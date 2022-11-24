<?php
echo $this->Html->css(array('codemirror'), null, array('inline' => false));
echo $this->Html->script(array('scripts.js',
    'codemirror/codemirror',
    'codemirror/javascript',
    'codemirror/css',
    'codemirror/clike',
    'codemirror/xml',
    'codemirror/php',
    'codemirror/htmlmixed',
    'codemirror/htmlembedded'), array('inline' => false));
$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Themes Manager'), array('controller' => 'themes', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Editor'), array('controller' => 'themes', 'action' => 'admin_editor',$theme['Theme']['id']));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "themes"));
$this->end();

?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
var editor;
var current_file;
var current_type;

function openFile(path, type, obj) {
jQuery('.current').removeClass('current');
jQuery(obj).parent().addClass('current');
jQuery(obj).spin('tiny');
jQuery.post('<?php echo  $this->request->base ?>/admin/themes/ajax_open_file', { key: '<?php echo  $theme['Theme']['key'] ?>', type: type, path: path }, function(data)
{
jQuery(obj).spin(false);
jQuery('#code').val(data);
jQuery('.CodeMirror').remove();
jQuery('#path').html(path);
jQuery('#path-box').removeClass('hide');
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

jQuery('#saveButton').removeClass('hide');
jQuery('#copyButton').removeClass('hide');
jQuery('#theme_info').hide();
});
}

function openFolder(path, type, obj) {

if ( jQuery(obj).next().length )
jQuery(obj).next().slideToggle();
else
{
jQuery(obj).spin('tiny');
jQuery.post('<?php echo  $this->request->base ?>/admin/themes/ajax_open_folder', { key: '<?php echo  $theme['Theme']['key'] ?>', type: type, path: path }, function(data)
{
jQuery(obj).spin(false);
jQuery(obj).after(data);
});
}
}

function saveFile() {
//disableButton('saveButton');
 jQuery("#saveButton").addClass('hide');
jQuery.post('<?php echo  $this->request->base ?>/admin/themes/ajax_save_file', { key: '<?php echo  $theme['Theme']['key'] ?>', path: current_file, type: current_type, content: editor.getValue() }, function(data)
{
// Show alert
// Set title
$($('#portlet-config  .modal-header .modal-title')[0]).html('Notification');
// Set content
$($('#portlet-config  .modal-body')[0]).html('Successful Saving.');
// OK callback
$('#portlet-config  .modal-footer .ok').click(function(){
    $('#portlet-config').modal('hide');
    jQuery("#saveButton").removeClass('hide');
});
$('#portlet-config').modal('show');
});
}

function showCopy() {
jQuery('#copy').removeClass('hide').slideDown();
}

function copyFile()
{
jQuery("#proceedButton").addClass('hide');
// Show alert
// Set title
$($('#portlet-config  .modal-header .modal-title')[0]).html('Notification');
// Set content
$($('#portlet-config  .modal-body')[0]).html('This will overwrite any existing file in the theme folder. Proceed?');
// OK callback
$('#portlet-config  .modal-footer .ok').click(function(){
$('#portlet-config').modal('hide');
// disableButton('proceedButton');
$.post('<?php echo  $this->request->base ?>/admin/themes/ajax_copy', { key: $('#theme').val(), path: current_file }, function(data) {
//enableButton('proceedButton');
    jQuery("#proceedButton").removeClass('hide');
if ( data == '' )
mooAlert('Template has been copied successfully');
});

});
$('#portlet-config').modal('show');
return false;

}

$(document).on('loaded.bs.modal', function (e) {
Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
$(e.target).removeData('bs.modal');
});

<?php $this->Html->scriptEnd(); ?>

<style>
    .CodeMirror-scroll {
        height: auto;
        overflow: auto;
        position: relative;
        width: 100%;
    }
</style>
<?php echo $this->element('admin/themenav', array("cmenu" => "css","theme_id"=>$theme['Theme']['id'])); ?>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($theme['Theme']['key'])): ?>
            <div id="theme_info" class="note note-warning">
                <h4 class="block"><?php echo  __('Theme Info');?></h4>

                <p>
                    <?php echo  __('This is the base theme of mooSocial. All themes inherits the template files from this theme. To
                    override a template file, select it on the left column and copy it to your theme.');?>
                </p>
            </div>
        <?php else: ?>
            <div id="theme_info" class="note note-warning">
                <h4 class="block"><?php echo __('Theme Info')?></h4>
                <ul class="list6 info">
                    <li><label><?php echo __('Name');?></label>: <?php echo  $info->name ?></li>
                    <li><label><?php echo __('Key');?></label>: <?php echo  $info->key ?></li>
                    <li><label><?php echo __('Version');?></label>: <?php echo  $info->version ?></li>
                    <li><label><?php echo __('Author');?></label>: <?php echo  $info->author ?></li>
                    <li><label><?php echo __('Website');?></label>: <?php echo  $info->website ?></li>
                    <li><label><?php echo __('Description');?></label>: <?php echo  $info->description ?></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?php if (!empty($css_files)): ?>
            <div class="portlet box">
                <div class="portlet-body">
                    <h4 class="block"><?php echo __('Stylesheets');?></h4>
                    <?php echo $this->element('misc/themed_files', array('files' => $css_files, 'type' => 'css')); ?>
                </div>
            </div>


        <?php endif; ?>
    </div>
    <div class="col-md-9">


        <div class="portlet  box">
            <div class="portlet-body">
                <h4 class="block"><?php echo  $theme['Theme']['name'] ?></h4>
                <div class="tools text-right">

                    <a href="javascript:void(0)" onclick="saveFile()" class="hide btn btn-action"
                       id="saveButton"><?php echo __('Save');?></a>
                    <?php if (empty($theme['Theme']['key'])): ?>
                        <a href="javascript:void(0)" onclick="showCopy()" class="hide btn btn-gray"
                           id="copyButton"><?php echo __('Copy');?></a>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

                            <?php if (empty($theme['Theme']['key'])): ?>
                                <div class="col-md-12 hide" id="copy">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo  __('Copy this template to');?></label>

                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <div class="input-icon">
                                                        <i class="fa fa-copy fa-fw"></i>
                                                        <?php echo $this->Form->select('theme', $installed_themes, array('class' => 'form-control', 'empty' => false)); ?>

                                                    </div>
												<span class="input-group-btn">

												<button type="button" onclick="copyFile()" class="btn btn-success"
                                                        id="proceedButton"><i class="fa fa-arrow-left fa-fw"></i>
                                                    <?php echo  __('Proceed');?>
                                                </button>
												</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-md-12">
                                <div class="alert alert-success hide" id="path-box">
                                    <ul class="fa-ul">
                                        <li>
                                            <i class="fa fa-file fa-lg fa-li"></i>

                                            <div id="path" style="margin-bottom: 10px"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="code" style="display:none"></textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



