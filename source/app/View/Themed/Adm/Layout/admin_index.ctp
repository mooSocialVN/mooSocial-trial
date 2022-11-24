<?php
$i = 0;
$current_lang = Configure::read('Config.language');
foreach($site_langs as $key => $value)
{
    if($key == $current_lang):?>
        <script>var current_lang = "<?php echo $key;  ?>"</script>
<?php
        break;
    endif;
    $i++;
}
?>
<?php
echo $this->Html->script(array('tinymce/tinymce.min'), array('inline' => false));
echo $this->Html->css(array('jquery-nestable/jquery.nestable.css'), null, array('inline' => false));
echo $this->Html->script(array('admin/controller/layout.js'), array('inline' => false));

$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Themes Manager'), array('controller' => 'themes', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Layout Editor'), array('controller' => 'layout', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "themes"));
$this->end();
?>
<?php $this->start('page-toolbar'); ?>

<?php $this->end('page-toolbar'); ?>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
                mooPhrase.add("select_new_column", '<?php echo __('Select a new column layout for this page.');?>');
                mooPhrase.add("reset_default", '<?php echo __('Reset to default');?>');
                mooPhrase.add("edit_page_info", '<?php echo __('SEO Settings.');?>');

        MooLayout.setUrl({
            'admin_editpageinfo_pageId': "<?php echo $this->Html->url(array('controller' => 'layout','action' => 'admin_editpageinfo','pageId','ext' => 'json'));?>",
            'admin_editpageinfo':"<?php echo $this->Html->url(array('action' => 'admin_editpageinfo', 'ext' => 'json')); ?>",
            'admin_getpages':"<?php echo $this->Html->url(array('controller' => 'layout','action' => 'admin_getpages','ext' => 'json'));?>",
            'admin_getContents_pageId':"<?php echo $this->Html->url(array('controller' => 'layout','action' => 'admin_getContents','pageId','ext' => 'json'));?>",
            'admin_saveColumn':"<?php echo $this->Html->url(array('controller' => 'Layout','action' => 'admin_saveColumn'));?>",
            'admin_index_pageCreateId':"<?php echo  $this->Html->url(array('controller' => 'Layout','action' => 'admin_index','pageCreateId')); ?>",
            'admin_savePage':"<?php echo $this->Html->url(array('controller' => 'layout','action' => 'admin_savePage'));?>",
            'admin_createPage':"<?php echo $this->Html->url(array('controller' => 'layout','action' => 'admin_createPage','ext' => 'json'),TRUE);?>",
            'admin_deletePage':"<?php echo $this->Html->url(array('controller' => 'layout','action' => 'admin_deletePage','pageId','ext' => 'json'));?>",
            //'admin_deletePage':"<?php echo $this->Html->url(array('controller' => 'pages','action' => 'admin_delete','pageId'));?>",
            'admin_deleteComponent':"<?php echo $this->Html->url(array('action' => 'admin_deleteComponent','componentId'));?>",
            'admin_getPageStyle':"<?php echo $this->Html->url(array('action' => 'admin_getpagestyle','pageId'));?>",
            'admin_getContentInfo_contentId_blockId':"<?php echo $this->Html->url(array('action' => 'admin_getcontentinfo','contentId','blockId','ext'=>'json'));?>",
            'admin_filter':"<?php echo $this->Html->url(array('action' => 'admin_filter'));?>"

        });
        MooLayout.setCurrentPage(parseInt("<?php echo isset($currentPage)?$currentPage:$landingPage; ?>"));
        MooLayout.setLandingPage(parseInt("<?php echo $landingPage; ?>"));

        $(document).ready(function(){
            
            tinymce.init({
                selector: "textarea",
                language : mooConfig.tinyMCE_language,
                theme: "modern",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "template paste textcolor"
                ],
                toolbar1: "styleselect | bold italic | bullist numlist outdent indent | forecolor backcolor emoticons | link unlink anchor image | preview fullscreen code",
                image_advtab: true,
                height: 500,
                relative_urls : false,
                remove_script_host : true,
                document_base_url : '<?php echo FULL_BASE_URL . $this->request->root?>',
                image_dimensions: false,
                directionality : mooConfig.site_directionality
            });
        
            $('#ajax').on('click','#createButton',function(){
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

                $('#page-body').val(tinyMCE.activeEditor.getContent());
                disableButton('createButton');
                $.post("<?php echo $this->request->base?>/admin/pages/ajax_save", $("#createForm").serialize(), function(data){
                    enableButton('createButton');
                    var json = $.parseJSON(data);

                    if ( json.result == 1 )
                        window.location = '<?php echo $this->request->base?>/admin/layout/index/' + json.page_id;
                    else
                        mooAlert(json.message);
                });
            });

            $('#alias').on('blur', function(){
            $('#alias').val( $('#alias').val().replace(/[^a-zA-Z0-9-_]/g, '_').toLowerCase() );
            });
        })

<?php $this->Html->scriptEnd(); ?>
<style>
    .show-grid [class^="col-"] {
        /*background-color: rgba(86, 61, 124, 0.15);*/
        border: 1px solid rgba(86, 61, 124, 0.2);
        padding-bottom: 10px;
        padding-top: 10px;
        padding:6px;
    }
    .show-grid.noth-section [class^="col-"]{
        margin-bottom: 6px;
    }
    .show-grid.south-section [class^="col-"]{
        margin-top: 6px;
    }
    .show-grid.middle-section #moo-west{
        border-right:none;
    }
    .show-grid.middle-section #moo-east{
        border-left:none;
    }
    .show-grid.middle-section #moo-center{
/*        border-left: none;
        border-right: none;*/
        padding: 0 6px;
    }
    .dd-handle{
        margin-top:0;
    }
    .show-grid.middle-section #moo-center .dd-list{
        padding: 6px;
        min-height: 400px;
    }
    .dd-list > li + li .dd-handle{
        margin-top: 5px;
    }
    .show-grid-edit-column-header-footer [class^="col-"] {
        background-color: rgba(86, 61, 124, 0.15);
        border: 1px solid rgba(86, 61, 124, 0.2);

    }
    .show-grid-edit-column-content [class^="col-"] {
        /*background-color: rgba(86, 61, 124, 0.15);*/
        border: 1px solid rgba(86, 61, 124, 0.2);

    }
    .pd10{
        padding: 10px;
    }
    .pd20r{
       padding-right:20px;
    }
    .pd20l{
        padding-left:20px;
    }
    .mg5b{
       margin-bottom:5px;
    }
    .mh100{
        min-height: 100px;
    }
    .mh140{
        min-height: 140px;
    }
    .mh300{
        min-height: 300px;
    }
    .mh400{
        min-height: 400px;
    }
    .mh500{
        min-height: 500px;
    }
    .mh10{
        min-height: 20px;
    }
    .mh35{
        min-height: 105px;
    }
    .hover , .choosen{
        border: 3px solid #36D7AC;
    }
</style>



<div class="portlet box " id="block-placement"><!--purple-wisteria-->
    <div class="portlet-body" >
        <div class="row">
            <div class="col-md-9">
                <div class="layout-action-section">
                    <div class="pull-left">
                        <div class="page-toolbar">
                            <div class="btn-group pull-left ">


                                <a id="moo-create-new-page" style="margin-right:2px;" href="<?php echo  $this->request->base ?>/admin/page/page_plugins/create" target="_blank"
                                   class="btn btn-gray">
                                    <?php echo  __('Create New Page');?>
                                </a>
                                <?php if(!empty($pageType) && $pageType !== 'core'): ?>
                                <a id="moo-delete-page" style="margin-right:2px;" class="btn btn-gray" title="Delete" href="javascript:void(0)">
                                    <?php echo  __('Delete Page');?>
                                </a>
                                <?php endif; ?>

                                <a id="moo-save-change" style="margin-right:2px;" title="Save Change" class="btn btn-action">
                                    <?php echo  __('Save Changes');?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">

                        <div class="actions" style="float:right;position:relative">
                            <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#" class="btn btn-default editing">
                                Editing <i class="material-icons">more_vert</i>
                            </a>
                            <ul id="moo-menu-editing" class=" dropdown-menu">
                                <?php
                                foreach($aPageHF as $PageHF):?>
                                    <li>
                                        <a href="<?php echo  $this->request->base; ?>/admin/layout/index/<?php echo $PageHF['Page']['id']; ?>" data-value="<?php echo $PageHF['Page']['id']; ?>" data-uri="<?php echo $PageHF['Page']['uri']; ?>" data-type="<?php echo $PageHF['Page']['type']; ?>"><?php echo $PageHF['Page']['title']; ?></a>
                                    </li>
                                <?php endforeach; ?>
                                <li class="divider">
                                </li>
                                <?php foreach($aPages as $aPage):?>
                                    <li>
                                        <a href="<?php echo  $this->request->base; ?>/admin/layout/index/<?php echo $aPage['Page']['id']; ?>" data-value="<?php echo $aPage['Page']['id']; ?>" data-uri="<?php echo $aPage['Page']['uri']; ?>" data-type="<?php echo $aPage['Page']['type']; ?>"><?php echo $aPage['Page']['title']; ?></a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                            <a id ="moo-edit-page-info"class="btn btn-gray easy-pie-chart-reload" href="javascript:;">
                                <?php echo  __('SEO Settings');?></a>
                            <a id="moo-edit-columns" class="btn btn-gray easy-pie-chart-reload" href="javascript:;">
                                <?php echo  __('Edit Columns');?> </a>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div style="clear:both">
                    <div class="">
                        <div class="show-grid block-header" style="padding-top:5px;">
                            <div style="display: 'none'" class="col-md-12 mh100 moo-container current" id="moo-header">
                                <ul class="no-order" style="list-style: outside none none; padding: 0px; margin:0px;">
                                    <li class="ui-sortable-placeholder dd-item" data-display-name="invisiblecontent"><div style="background-color: #C4C4C4" class="dd-handle content_fixed"><span><?php echo __('Main Menu')  ?></span> <a class="edit-block" href="javascript:void(0)"></a> </div></li>
                                </ul>
                                <ol class="dd-list">
                                </ol>
                            </div>
                            <div class="header-section normal col-md-12 mh100 text-center">
                                <h1><?php echo  __('Header');?></h1>
                            </div>
                        </div>

                        <div class="main-content-area" style="clear: both;">
                            <div class="normal">
                                <input type="hidden" name="removeComponent" id="removeComponent" value="" />
                                <div class="show-grid noth-section">
                                    <div class="col-md-12 mh100 moo-container" id="moo-north"><ol class="dd-list"></ol></div>
                                </div>
                                <div class="show-grid middle-section">
                                    <div class="col-md-3 mh300 moo-container " id="moo-west"><ol class="dd-list "></ol></div>
                                    <div class="col-md-6 mh300 moo-container " id="moo-center">
                                            <ol class="dd-list "></ol>               
                                    </div>
                                    <div class="col-md-3 mh300 moo-container " id="moo-east"><ol class="dd-list "></ol>
                                    </div>
                                </div>
                                <div class="show-grid south-section">
                                    <div class="col-md-12 mh100 moo-container " id="moo-south"><ol class="dd-list "></ol></div>
                                </div>
                            </div>
                            <div class="current" style="display:'none'">
                                <div class="" style="padding:5px 0;">
                                    <div class="main_contain_section" class="col-md-12 mh100 text-center">
                                        <h1><?php echo  __('Main content area'); ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="show-grid block-footer" style="clear: both;">
                            <div style="display: none" class="col-md-12 mh100 moo-container current" id="moo-footer"><ol class="dd-list"></ol></div>
                            <div class="footer-section normal col-md-12 mh100 text-center">
                                <h1><?php echo  __('Footer');?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="portlet box">
                    <div class="portlet-title">
                        <div class="caption">
                            <span style="color:#000000"><?php echo  __('Available Blocks');?></span>
                        </div>
                        <div class="actions">
                            <div class="btn-group filter">
                                <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#" class="btn btn-sm btn-default">
                                    <?php echo  __('Filter By');?> <i class="fa fa-angle-down"></i>
                                </a>
                                <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                                        <label><div class="checker"><span class="checked"><input type="checkbox" checked=""></span></div> All</label>
                                    <?php foreach($aGroups as $group): ?>
                                        <label><div class="checker"><span class=""><input type="checkbox"></span></div> <?php echo  $group['CoreBlock']['group'];  ?></label>
                                    <?php endforeach; ?>
                                        <a class="btn btn-m green filter-now" href="javascript:void(0)">
                                                <?php echo  __('Submit');?><i class="fa fa-filter "></i>
                                            </a>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="" >
                        <div class="scroller" style="height:500px" data-rail-visible="1" data-rail-color="#7CACFA" data-handle-color="#a1b2bd">
                            <div id="nestable_list_2" class="dd">
                                <ol class="dd-list">
                                    <?php
                                    $display = '';
                                    foreach($aBlocks as $aBlock) :
                                        if($aBlock['CoreBlock']['restricted'] != ''){
                                            $display = "style='display:none' data-uri='".$aBlock['CoreBlock']['restricted']."'";


                                        }

                                        $this->Html->scriptStart(array('inline' => false));
                                        echo "MooLayout.register(".$aBlock['CoreBlock']['id'].",".$aBlock['CoreBlock']['params'].",'".$aBlock['CoreBlock']['path_view']."',\"".$aBlock['CoreBlock']['name']."\");";
                                        $this->Html->scriptEnd();
                                        ?>
                                        <li data-id="<?php echo  $aBlock['CoreBlock']['id']?>" class="dd-item"<?php echo  $display; ?>>
                                            <div class="dd-handle">
                                               <?php echo  $aBlock['CoreBlock']['name'];?>
                                            </div>
                                        </li>
                                        <?php $display = ''; ?>
                                    <?php endforeach; ?>



                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="moo-format-columns" class="row hide">
<div class="row">
<div class="col-md-12 mh140">
<div class="row mg5b">
    <div class="col-md-3  pd20r pd20l">
        <div data-id="1" class="row block" >
            <div class="col-md-12 ">
                <div class="row   show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-3 mh35 "></div>
                    <div class="col-md-6 mh35 "></div>
                    <div class="col-md-3 mh35 "></div>
                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="2" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-3 mh35 "></div>
                    <div class="col-md-9 mh35 "></div>

                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="3" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-9 mh35 "></div>
                    <div class="col-md-3 mh35 "></div>

                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="4"  class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh35 "></div>


                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mg5b">
    <div class="col-md-3 pd20r pd20l">
        <div data-id="5" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-3 mh35 "></div>
                    <div class="col-md-6 mh35 "></div>
                    <div class="col-md-3 mh35 "></div>
                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="6" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-3 mh35 "></div>
                    <div class="col-md-9 mh35 "></div>

                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="7" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-9 mh35 "></div>
                    <div class="col-md-3 mh35 "></div>

                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="8" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh35 "></div>


                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 pd20r pd20l">
        <div data-id="9" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-3 mh35 "></div>
                    <div class="col-md-6 mh35 "></div>
                    <div class="col-md-3 mh35 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="10" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-3 mh35 "></div>
                    <div class="col-md-9 mh35 "></div>

                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="11" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-9 mh35 "></div>
                    <div class="col-md-3 mh35 "></div>

                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 pd20r">
        <div data-id="12" class="row block">
            <div class="col-md-12 ">
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh35 "></div>


                </div>
                <div class="row show-grid-edit-column-content">
                    <div class="col-md-12 mh10 "></div>
                </div>
                <div class="row show-grid-edit-column-header-footer">
                    <div class="col-md-12 mh10 "></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>



<div id="edit-page-info" class="modal fade" title="SEO Settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#PageAdminEditpageinfoForm')[0].reset();"><?php echo  __('Close');?></button>
                <button type="button" class="btn btn-primary" id="save_edit_page_info"><?php echo  __('Save changes');?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="ajax-page-translate" role="basic" aria-hidden="true">
	<div class="page-loading page-loading-boxed">
		<span>
			&nbsp;&nbsp;Loading...</span>
	</div>
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>


<div id="edit-component-info" class="modal fade" title="Edit Component Info" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo  __('Close');?></button>
                <button type="button" class="btn btn-primary" id="save_edit_component_info"><?php echo  __('Save changes');?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div aria-hidden="true" role="basic" id="ajax-translate2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="portlet-config2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                Widget settings form goes here
            </div>
            <div class="modal-footer">
                <!-- Config -->
                <button class="btn blue ok" type="button"><?php echo  __('OK');?></button>
                <button data-dismiss="modal" class="btn default" type="button"><?php echo  __('Close');?></button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

