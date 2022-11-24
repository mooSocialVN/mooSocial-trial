<?php
echo $this->Html->css(array('footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('footable'), array('inline' => false));

$this->Html->addCrumb('Content Manager');
$this->Html->addCrumb('Albums Manager', array('controller' => 'albums', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "albums"));
$this->end();

$this->Paginator->options(array('url' => $this->passedArgs));
?>

<script>
    $(document).ready(function () {
        $('.footable').footable();
    });
</script>

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

                        <form method="post" action="<?php echo  $this->request->base ?>/admin/photo/albums">
                            <?php echo $this->Form->text('keyword', array('class' => 'form-control input-medium input-inline', 'placeholder' => 'Search by title')); ?>
                            <?php echo $this->Form->submit('', array('style' => 'display:none')); ?>
                        </form>
                    </label></div>
            </div>
        </div>
    </div>
    <form method="post" action="<?php echo  $this->request->base ?>/admin/photo/albums/delete" id="deleteForm">
        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
                <tr>
                    <?php if ($cuser['Role']['is_super']): ?>
                        <th width="30"><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                    <?php endif; ?>
                    <th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
                    <th><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                    <th data-hide="phone"><?php echo $this->Paginator->sort('User.name', 'Creator'); ?></th>
                    <th data-hide="phone"><?php echo $this->Paginator->sort('Category.name', 'Category'); ?></th>
                    <th data-hide="phone"><?php echo $this->Paginator->sort('created', 'Date'); ?></th>

                </tr>
            </thead>
            <tbody>

                <?php $count = 0;
                foreach ($albums as $album):
                    ?>
                    <tr class="gradeX <?php ( ++$count % 2 ? "odd" : "even") ?>">
                        <?php if ($cuser['Role']['is_super']): ?>
                            <td><input type="checkbox" name="albums[]" value="<?php echo  $album['Album']['id'] ?>" class="check"></td>
    <?php endif; ?>
                        <td><?php echo  $album['Album']['id'] ?></td>
                        <td><a href="<?php echo  $this->request->base ?>/albums/edit/<?php echo  $album['Album']['id'] ?>" target="_blank"><?php echo  ($album['Album']['moo_title']) ?></a></td>
                        <td><a href="<?php echo  $this->request->base ?>/admin/users/edit/<?php echo  $album['User']['id'] ?>"><?php echo  ($album['User']['name']) ?></a></td>
                        <td><?php echo  $album['Category']['name'] ?></td>
                        <td><?php echo  $this->Time->niceShort($album['Album']['created']) ?></td>
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
                        <select class="form-control" onchange="doModeration(this.value, 'albums')">
                            <option value="">With selected...</option>
                            <option value="move">Move to</option>
                            <option value="delete">Delete</option>
                        </select>
                    </div>
                    <div class="col-md-6">
<?php echo $this->Form->select('category_id', $categories, array('class' => 'form-control', 'onchange' => "confirmSubmitForm('Are you sure you want to move these albums', 'deleteForm')", 'style' => 'display:none')); ?>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-6">
            <div class="pagination" style="float: right;">
                <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(); ?>
				<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?>
            </div>
        </div>
    </div>

</div>