<?php
    echo $this->Html->css(array('footable.core.min','/theme/adm/css/layout/css/modal.css'), null, array('inline' => false));
    echo $this->Html->script(array('footable'), array('inline' => false));

    $this->Html->addCrumb(__('Plugins Manager'), '/admin/plugins');
	$this->Html->addCrumb(__('Videos Manager'), array('controller' => 'video_plugins', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
    echo $this->element('admin/adminnav', array('cmenu' => 'Video'));
    $this->end();
?>
<?php echo $this->Moo->renderMenu('Video', __('General'));?>

<?php
$this->Paginator->options(array('url' => $this->passedArgs));
?>

<div class="portlet-body">
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group hide">
                    <button class="btn purple" id="sample_editable_1_new" onclick="confirmSubmitForm('Are you sure you want to delete these entries', 'deleteForm')">
                        Delete <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div id="sample_1_filter" class="dataTables_filter"><label>
                        <form method="post" action="<?php echo $this->request->base?>/admin/video/video_plugins">
                            <?php echo $this->Form->text('keyword', array('class' => 'form-control input-medium input-inline', 'placeholder' => __('Search by title') ) );?>
                            <?php echo $this->Form->submit('', array( 'style' => 'display:none' ));?>
                        </form>
                    </label></div>
            </div>
        </div>
    </div>
    <form method="post" action="<?php echo $this->request->base?>/admin/video/video_plugins/delete" id="deleteForm">
        <?php echo  $this->Form->hidden('category'); ?>
        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
            <tr>
                <?php if ( $cuser['Role']['is_super'] ): ?>
                    <th width="30"><input type="checkbox" onclick="toggleCheckboxes2(this)"></th>
                <?php endif; ?>
                <th><?php echo $this->Paginator->sort('id', __('ID')); ?></th>
                <th><?php echo $this->Paginator->sort('title', __('Title')); ?></th>
                <th data-hide="phone"><?php echo $this->Paginator->sort('User.name', __('Poster')); ?></th>
                <th data-hide="phone"><?php echo $this->Paginator->sort('Category.name', __('Category')); ?></th>
                <th data-hide="phone"><?php echo $this->Paginator->sort('Group.name', __('Group')); ?></th>

            </tr>
            </thead>
            <tbody>

            <?php $count = 0;
            foreach ($videos as $video): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                    <?php if ( $cuser['Role']['is_super'] ): ?>
                        <td><input type="checkbox" name="videos[]" value="<?php echo $video['Video']['id']?>" class="check"></td>
                    <?php endif; ?>
                    <td><?php echo $video['Video']['id']?></td>
                    
                    <td><a href="<?php echo  $this->request->base ?>/videos/view/<?php echo  $video['Video']['id'] ?>" target="_blank"><?php echo $this->Text->truncate($video['Video']['title'], 100, array('eclipse' => '...')) ?></a></td>
                    <td><a href="<?php echo  $this->request->base ?>/admin/users/edit/<?php echo  $video['User']['id'] ?>"><?php echo  ($video['User']['name']) ?></a></td>
                    <td><?php echo h($video['Category']['name'])?></td>
                    <td><?php echo $video['Group']['name']?></td>

                </tr>
            <?php endforeach ?>

            </tbody>
        </table>
    </form>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" onchange="doModeration(this.value, 'videos')">
                            <option value=""><?php echo __('With selected...');?></option>
                            <option value="move"><?php echo  __('Move to');?></option>
                            <option value="delete"><?php echo  __('Delete');?></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->select('category_id', $categories, array( 'class'=>'form-control','onchange' => "confirmSubmitForm('Are you sure you want to move these videos', 'deleteForm')", 'style' => 'display:none' ) ); ?>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-6">
            <div class="pagination pull-right">
                <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(); ?>
				<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?>
            </div>
        </div>
    </div>

</div>


    <section aria-hidden="true" aria-labelledby="myModalLabel" role="basic" id="videoModal" class="modal fade in" >
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </section>

<?php  $this->Html->scriptStart(array('inline' => false));   ?>
    $(document).ready(function(){
        $('.json-view').click(function(){
            mooAjax.post({
                'url' : $(this).attr('rel'),
            },function(response){
                $('#videoModal .modal-content').html(response.data);
            });
        });
        $('#fetchButton').click(function(){
            $('#fetchButton').spin('small');
            $("#videoForm .error-message").hide();
            disableButton('fetchButton');
            mooAjax("<?php echo $this->request->base?>/videos/aj_validate", 'post', $("#createForm").serialize(), function(data) {
                enableButton('fetchButton');
                if (data){
                    $("#fetchForm .error-message").html($.parseJSON(data).error);
                    $("#fetchForm .error-message").show();
                    $('#fetchButton').spin(false);
                }else{
                    mooAjax("<?php echo $this->request->base?>/videos/fetch", 'post', $("#createForm").serialize(), function(data) {
                        
                        enableButton('fetchButton');
                        $("#fetchForm").slideUp();
                        //$("#videoForm").html(data.data);
                        $("#videoForm").html(data);
                    });
                }
            });
            return false;
        });
    });
<?php $this->Html->scriptEnd();  ?>