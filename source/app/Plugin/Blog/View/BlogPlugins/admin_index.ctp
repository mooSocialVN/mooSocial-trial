<?php
    echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
    echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
    $this->Html->addCrumb(__('Plugins Manager'), '/admin/plugins');
    $this->Html->addCrumb(__('Blogs Manager'), array('controller' => 'blog_plugins', 'action' => 'admin_index'));
    
    $this->startIfEmpty('sidebar-menu');
    echo $this->element('admin/adminnav', array('cmenu' => 'Blog'));
    $this->end();
?>
<?php echo $this->Moo->renderMenu('Blog', __('General'));?>

<?php
$this->Paginator->options(array('url' => $this->passedArgs));
?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $(document).ready(function(){
        $('.footable').footable();
    });
<?php $this->Html->scriptEnd(); ?>
<div class="portlet-body">
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <button class="btn btn-gray" id="sample_editable_1_new" onclick="confirmSubmitForm('<?php echo __('Are you sure you want to delete these blogs')?>', 'deleteForm')">
                        <?php echo  __('Delete');?>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div id="sample_1_filter" class="dataTables_filter"><label>
                        <form method="post" action="<?php echo $this->request->base?>/admin/blog/blog_plugins">
                            <?php echo $this->Form->text('keyword', array('class' => 'form-control input-medium input-inline', 'placeholder' => __('Search by title')));?>
                            <?php echo $this->Form->submit('', array( 'style' => 'display:none' ));?>
                        </form>
                    </label></div>
            </div>
        </div>
    </div>
    <form method="post" action="<?php echo $this->request->base?>/admin/blog/blog_plugins/delete" id="deleteForm">
        <?php echo  $this->Form->hidden('category'); ?>
        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
            <tr>
                <?php if ($cuser['Role']['is_super']): ?>

                    <th width="30"><input type="checkbox" onclick="toggleCheckboxes2(this)"></th>
                <?php endif; ?>
                <th><?php echo $this->Paginator->sort('id', __('ID')); ?></th>
                <th><?php echo $this->Paginator->sort('title', __('Title')); ?></th>
                <th data-hide="phone"><?php echo $this->Paginator->sort('User.name', __('Author')); ?></th>
                <th data-hide="phone"><?php echo $this->Paginator->sort('Category.name', __('Category')); ?></th>
                <th data-hide="phone"><?php echo $this->Paginator->sort('created', __('Date')); ?></th>

            </tr>
            </thead>
            <tbody>

            <?php $count = 0;
            foreach ($blogs as $blog): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                    <?php if ( $cuser['Role']['is_super'] ): ?>
                        <td><input type="checkbox" name="blogs[]" value="<?php echo $blog['Blog']['id']?>" class="check"></td>
                    <?php endif; ?>
                    <td><?php echo $blog['Blog']['id']?></td>
                    <td><a href="<?php echo $this->request->base?>/blog/blogs/create/<?php echo $blog['Blog']['id']?>" target="_blank"><?php echo $this->Text->truncate($blog['Blog']['title'], 100, array('eclipse' => '...')) ?></a></td>
                    <td><a href="<?php echo $this->request->base?>/admin/users/edit/<?php echo $blog['User']['id']?>"><?php echo $blog['User']['name']?></a></td>
                    <td><?php echo isset($categories[$blog['Category']['id']]) ? h($categories[$blog['Category']['id']]) : ''?></td>
                    <td><?php echo $this->Time->niceShort($blog['Blog']['created'])?></td>
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
                        <select class="form-control" onchange="doModeration(this.value, 'blogs')">
                            <option value=""><?php echo __( 'With selected...')?></option>
                            <option value="move"><?php echo __( 'Move to')?></option>
                            <option value="delete"><?php echo __( 'Delete')?></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->select('category_id', $categories, array( 'class'=>'form-control','onchange' => "confirmSubmitForm('".__('Are you sure you want to move these blogs')."', 'deleteForm')", 'style' => 'display:none' ) ); ?>
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