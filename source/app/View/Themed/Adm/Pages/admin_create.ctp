<?php
echo $this->Html->script(array('tinymce/tinymce.min'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Pages Manager'), array('controller' => 'pages', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Create New Page'), array('controller' => 'pages', 'action' => 'admin_create'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "pages"));
$this->end();
?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    
    $(document).ready(function(){
    
        tinymce.init({
            selector: "textarea",
            language : mooConfig.tinyMCE_language,
            theme: "modern",
            skin: 'light',
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "template paste textcolor"
            ],
            toolbar1: "styleselect | bold italic | bullist numlist outdent indent | forecolor backcolor emoticons | link unlink anchor image | preview fullscreen code",
            image_advtab: true,
            image_dimensions: false,
            height: 500,
            relative_urls : false,
            remove_script_host : true,
            document_base_url : '<?php echo FULL_BASE_URL . $this->request->root?>',
            directionality : mooConfig.site_directionality
        });
    
        $('#createButton').click(function(){
            var checked = false;
            $('#permission_list :checkbox').each(function(){
                if ($(this).is(':checked'))
                    checked = true;
            })

            if (!checked)
            {
                mooAlert('Please check at least one user role in the Permissions tab');
                return;
            }

            $('#page-body-textarea').val(tinyMCE.activeEditor.getContent());
            
            disableButton('createButton');
            $.post("<?php echo $this->request->base?>/admin/pages/ajax_save", $("#createForm").serialize(), function(data){
                enableButton('createButton');

                var json = $.parseJSON(data);

                if ( json.result == 1 )
                    window.location = '<?php echo $this->request->base?>/admin/pages/create/' + json.page_id;
                else
                    mooAlert(json.message);
            });
        });

        $('#alias').on('blur', function(){
            $('#alias').val( $('#alias').val().replace(/[^a-zA-Z0-9-_]/g, '_').toLowerCase() );
        });
    });
<?php $this->Html->scriptEnd(); ?>



<div class="portlet box">
    <div class="portlet-title">
       
        <div class="actions">
            <div class="portlet-input input-inline">
                <div class="input-icon right">
                    <?php if (!empty($page['Page']['id'])): ?>
                        <a href="<?php echo $this->request->base?>/pages/<?php echo $page['Page']['alias']?>" target="_blank" class="btn btn-gray">View Page</a>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body form">

    <form id="createForm" class="form-horizontal">
        <div class="form-body">

        <?php echo $this->Form->hidden('id', array('value' => $page['Page']['id'])); ?>


        <div class="form-group">
            <label class="col-md-3 control-label">Page Title</label>
            <div class="col-md-9">
                <?php echo $this->Form->text('title', array('placeholder'=>'Enter text','class'=>'form-control ','value' => $page['Page']['title'])); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Page Alias</label>
            <div class="col-md-9">

                <?php echo $this->Form->text('alias', array('placeholder'=>'Enter text','class'=>'form-control ','value' => $page['Page']['alias'])); ?>
                <span class="help-block">
                    The page url will be /pages/your-alias
                </span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Page Content</label>
            <div class="col-md-9">

                <?php echo $this->Form->textarea('content', array('value' => $page['Page']['content'], 'id' => 'page-body-textarea')); ?>

            </div>
        </div>

            <?php
            echo $this->Form->input('url', array(
                'class'=>'form-control ',
            'label' => array(
                'text' => 'Page URL :',
                "class" => "col-lg-3 control-label"),
            'data-options' => "required:true",
            'div' => array("class" => 'form-group'),
            'between' => '<div class="col-lg-9">',
            'after' => '</div>',
            'value' => $page['Page']['url']
            ));

            echo $this->Form->input('description', array(
                'class'=>'form-control ',
            'label' => array(
                'text' => 'Page Description (meta tag):',
                "class" => "col-lg-3 control-label"),
            'data-options' => "multiline:true",
            'div' => array("class" => 'form-group'),
            'between' => '<div class="col-lg-9">',
            'after' => '</div>',
            'value' => $page['Page']['description']
            //'style' => "height:60px"
            ));

            echo $this->Form->input('keywords', array(
                'class'=>'form-control ',
            'label' => array(
                'text' => 'Page Keywords (meta tag):',
                "class" => "col-lg-3 control-label"),
            'data-options' => "multiline:true",
            'div' => array("class" => 'form-group'),
            'between' => '<div class="col-lg-9">',
            'after' => '</div>',
            'value' => $page['Page']['keywords']
                //'style' => "height:60px"
            ));
            //echo $this->Form->end((array('label'=>'Save','div'=>array( 'id'=>'submit-new-page'))));
            ?>

        <hr>
        <h4>Settings</h4>
        <div class="form-group">
            <label class="col-md-3 control-label">Allow Comments</label>
            <div class="col-md-9">
                <div class="checkbox-list">
                    <label class="checkbox-inline">
                        <?php echo $this->Form->checkbox('comments', array('checked' => $params['comments'])); ?>
                    </label>


                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Show in Main Menu</label>
            <div class="col-md-9">
                <div class="checkbox-list">
                    <label class="checkbox-inline">
                        <?php echo $this->Form->checkbox('menu', array('checked' => $page['Page']['menu'])); ?>
                    </label>


                </div>
            </div>
        </div>
        <hr>

        <h4>Permissions</h4>
        <?php echo $this->element('admin/permissions', array('permission' => $page['Page']['permission'])); ?>
    </div>
    </form>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button id="createButton" class="btn btn-circle btn-action">Save Page</button>

                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="alert alert-danger error-message" style="display:none;margin-top:10px"></div>
                </div>
            </div>
        </div>

        <!-- END FORM-->
    </div>
</div>


