<?php
echo $this->Html->script(array('tinymce/tinymce.min'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Pages Manager'), array('controller' => 'page_plugins', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Create New Page'), array('controller' => 'page_plugins', 'action' => 'admin_create'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "Page"));
$this->end();
?>

<?php echo $this->Moo->renderMenu('Page', __('General'));?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    
    $(document).ready(function(){
        
        tinymce.init({
            selector: "textarea",
            language : mooConfig.tinyMCE_language,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor"
            ],
            toolbar1: "styleselect | bold italic | bullist numlist outdent indent | forecolor backcolor emoticons | link unlink anchor media | preview fullscreen code",
            image_advtab: true,
            image_dimensions: false,
            height: 500,
            relative_urls : false,
            remove_script_host : false,
            extended_valid_elements : "script[*]",
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

            mooAjax.post({
                    url : "<?php echo $this->request->base?>/admin/page/page_plugins/save",
                    data: jQuery("#createForm").serialize()
                }, function(data){
                    enableButton('createButton');
                    var json = $.parseJSON(data);
                    if ( json.result == 1 )
                    {
                        if ($('#language').length > 0)
                            window.location = '<?php echo $this->request->base?>/admin/page/page_plugins/create/' + json.page_id + '/' + $('#language').val();
                        else
                            window.location = '<?php echo $this->request->base?>/admin/page/page_plugins/create/' + json.page_id;
                    }
                    else
                    {
                        mooAlert(json.message);
                    }
            });
           
        });

        $('#alias').on('blur', function(){
            $('#alias').val( $('#alias').val().replace(/[^a-zA-Z0-9-_]/g, '_').toLowerCase() );
        });

        $('#language').change(function(e){
            window.location.href = "<?php echo $this->request->base;?>/admin/page/page_plugins/create/<?php echo $page['Page']['id'];?>/" +$('#language').val();
        });
    });
<?php $this->Html->scriptEnd(); ?>



<div class="portlet box">
    <div class="portlet-title">
       
        <div class="actions">
            <div class="portlet-input input-inline">
                <div class="input-icon right">
                    <?php if (!empty($page['Page']['id'])): ?>
                        <?php $this->Html->link(__('View Page'),$this->request->base.'/pages/'.$page['Page']['alias'],array('target' => "_blank", 'class' => "btn btn-gray")); ?>
                        <a href="<?php echo $this->request->base?>/pages/<?php echo $page['Page']['alias']?>" target="_blank" class="btn btn-gray"><?php echo __('View Page');?></a>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body form">

    <form id="createForm" class="form-horizontal">
        <div class="form-body">

        <?php echo $this->Form->hidden('id', array('value' => $page['Page']['id'])); ?>

        <?php if ($page['Page']['id']): ?>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __('Language Pack');?>(<a data-html="true" href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __('Select a language to translate for page title and page content only'); ?>" data-placement="top">?</a>)</label>
                <div class="col-md-9">
                    <?php echo $this->Form->select('language', $languages, array('class'=>'form-control','value'=>$language,'empty'=>false)); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Page Title');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('title', array('placeholder'=>__('Enter text'),'class'=>'form-control ','value' => $page['Page']['title'])); ?>
                <span class="help-block blue"><?php echo __('Title tag');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Page Alias');?></label>
            <div class="col-md-9">

                <?php echo $this->Form->text('alias', array('placeholder'=>__('Enter text'),'class'=>'form-control ','value' => $page['Page']['alias'])); ?>
                <span class="help-block">
                    <?php echo __('The page url will be /pages/your-alias');?>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Page Content');?></label>
            <div class="col-md-9">

                <?php echo $this->Form->textarea('content', array('value' => $page['Page']['content'], 'id' => 'page-body-textarea')); ?>

            </div>
        </div>

            <?php
            /*echo $this->Form->input('url', array(
                'class'=>'form-control ',
            'label' => array(
                'text' => 'Page URL :',
                "class" => "col-lg-3 control-label"),
            'data-options' => "required:true",
            'div' => array("class" => 'form-group'),
            'between' => '<div class="col-lg-9">',
            'after' => '<span class="help-block">The URL may only contain alphanumeric characters and dashes - any other characters will be stripped.</span></div>',
            'value' => $page['Page']['url']
            ));*/

            echo $this->Form->input('description', array(
                'class'=>'form-control ',
            'label' => array(
                'text' => __('Page Description (meta tag):'),
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
                'text' => __('Page Keywords (meta tag):'),
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
        <h4><?php echo __('Settings');?></h4>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Allow Comments');?></label>
            <div class="col-md-9">
                <div class="checkbox-list">
                    <label class="checkbox-inline">
                        <?php echo $this->Form->checkbox('comments', array('checked' => @$params['comments'])); ?>
                    </label>


                </div>
            </div>
        </div>

        <?php if (empty($page['Page']['id'])): ?>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Blocks inherit');?></label>
            <div class="col-md-9">

                <?php echo $this->Form->select('inherit', $all_pages); ?>
                <span class="help-block">
                    <?php echo __('Inherit blocks from another page. (Only inherit available blocks and non restricted blocks)');?>
                </span>
            </div>
        </div>
        <?php endif; ?>
        <hr>

        <h4><?php echo __('Permissions');?></h4>
        <?php echo $this->element('admin/permissions', array('permission' => $page['Page']['permission'])); ?>
    </div>
    </form>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button id="createButton" class="btn btn-circle btn-action"><?php echo __('Save Page');?></button>

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


