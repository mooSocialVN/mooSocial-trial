<?php
$this->Html->addCrumb(__('Plugins Manager'), '/admin/plugins');
$this->Html->addCrumb(__('Tags Manager'), array('controller' => 'tags', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "tags"));
$this->end();
?>
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <div id="sample_1_filter" class="dataTables_filter pull-right"><label>
                            <form method="post" action="<?php echo  $this->request->base ?>/admin/tags">
                                <?php echo $this->Form->text('keyword', array('class' => 'form-control input-medium input-inline', 'placeholder' => __('Search tag') ) ); ?>
                                <?php echo $this->Form->submit('', array('style' => 'display:none')); ?>
                            </form>
                        </label></div>
                </div>
            </div>
        </div>
        <form method="post" action="<?php echo  $this->request->base ?>/admin/tags/delete" id="deleteForm">
            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                <tr>
                    <?php if ( $cuser['Role']['is_super'] ): ?>
                        <th width="30"><input type="checkbox" onclick="toggleCheckboxes2(this)"></th>
                    <?php endif; ?>
                    <th><?php echo $this->Paginator->sort('tag', __('Tag')); ?></th>
                    <th><?php echo $this->Paginator->sort('type', __('Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('type', __('Item')); ?></th>
                </tr>
                </thead>
                <tbody>

                <?php $count = 0;
                foreach ($tags as $tag): ?>
                    <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                        <?php if ( $cuser['Role']['is_super'] ): ?>
                            <td><input type="checkbox" name="tags[]" value="<?php echo $tag['Tag']['id']?>" class="check"></td>
                        <?php endif; ?>
                            <td><a target="_blank" href="<?php echo $this->request->webroot?>search/hashtags/<?php echo h($tag['Tag']['tag'])?>"><?php echo h($tag['Tag']['tag'])?></a></td>
                            <td>
                                <?php
                                list($plugin, $modelClass) = mooPluginSplit($tag['Tag']['type'], true);
                                echo $plugin;
                                ?>
                            </td>
                        <td>
                        <?php
                        $object = MooCore::getInstance()->getItemByType($tag['Tag']['type'],$tag['Tag']['target_id']);
                        ?>
                            <a target="_blank" href="<?php echo $object[key($object)]['moo_href']?>"><?php echo h($object[key($object)]['moo_title'])?></a>
                        </td>
                    </tr>
                <?php endforeach ?>

                </tbody>
            </table>
        </form>
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <button class="btn btn-gray" id="sample_editable_1_new" onclick="confirmSubmitForm('<?php echo __('Are you sure you want to delete these tags');?>', 'deleteForm')">
                            <?php echo  __('Delete');?>
                        </button>
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
    </div>