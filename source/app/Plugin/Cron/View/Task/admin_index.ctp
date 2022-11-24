<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'),'/admin/home');
$this->Html->addCrumb(__('Tasks Manager'), array('controller' => 'task', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "cron"));
$this->end();
?>

<?php echo $this->Moo->renderMenu('Cron', __('Manage Tasks'));?>


<?php if (!$check_run):?>
    <div class="alert alert-danger">
		<?php echo __("Cron job has stopped working! Notification, email...do now work now. Click <a href='%s'>here</a> to restart or contact your hosting provider for support.",$this->request->base.'/admin/cron/task/clear');?>
	</div>
<?php endif;?>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i><?php echo __('Managed Tasks');?>
        </div>
    </div>
    <div class="portlet-body">

        <div class="">
            <?php if($tasks != null):?>
            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                    <tr>
                        <th><?php echo __('ID');?></th>
                        <th><?php echo __('Name');?></th>
                        <th><?php echo __('Timeout');?></th>
                        <th><?php echo __('Stats');?></th>
                        <th><?php echo __('Processes');?></th>
                        <th><?php echo __('Status');?></th>
                    </tr>
                </thead>
                <tbody>
                	<?php 
                	$count = 0;
                    foreach ($tasks as $task): $task = $task['Task']; 
                    ?>
                        <tr id="<?php echo $task['id']?>" class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                            <td class="reorder"><?php echo $task['id']?></td>
                            <td class="reorder"><?php echo $task['title']?></td>
                            <td class="reorder"><?php echo $task['timeout']?> <?php __('seconds');?></td>
                            <td class="reorder">
                                <?php echo  __('Succeeded:'); ?>
								<?php if( $task['success_count'] > 0 ): ?>
								<?php echo ($task['success_count']); ?>
								<?php echo   __('times, last');?>
								<?php echo $this->Moo->getTime( $task['success_last'], Configure::read('core.date_format'), $utz ); ?>
								<?php else: ?>
								<?php echo  __('never');?>
								<?php endif; ?>
								<br />
								
								<?php echo  __('Failed:');?>
								<?php if( $task['failure_count'] > 0 ): ?>								
								<?php echo ($task['failure_count']); ?>
                                <?php echo   __('times, last');?>
								<?php echo $this->Moo->getTime($task['failure_last'], Configure::read('core.date_format'), $utz ); ?>
								<?php else: ?>
                                <?php echo  __('never');?>
								<?php endif; ?>
								<br />
								
								<?php if( $task['started_count'] != $task['success_count'] + $task['failure_count'] ): ?>
								<?php if( $task['started_count'] > 0 ): ?>
								<?php echo  __('Started:');?>
								  <?php echo ($task['started_count']); ?>
                                      <?php echo   __('times, last');?>
								  <?php echo $this->Moo->getTime($task['started_last'], Configure::read('core.date_format'), $utz ); ?>
								<?php else: ?>
                                    <?php echo  __('never');?>
								<?php endif; ?>
								<br />
								<?php endif; ?>
								
								<?php if( $task['completed_count'] != $task['success_count'] + $task['failure_count'] ): ?>
								<?php echo  __('Completed:');?>
								<?php if( $task['completed_count'] > 0 ): ?>
								  <?php echo ($task['completed_count']); ?>
                                        <?php echo   __('times, last');?>
								  <?php echo $this->Moo->getTime($task['completed_last'], Configure::read('core.date_format'), $utz ); ?>
								<?php else: ?>
                                        <?php echo  __('never');?>
								<?php endif; ?>
								<br />
								<?php endif; ?>
                            </td>
                            <td>
                            	<?php if ($task['processes_info']):?>
                            		<?php echo $task['processes_info']['Processes']['pid'];?>
                            	<?php endif;?>
                            </td>
                            <td class="reorder text-center">
                                <?php if ( $task['enable'] ): ?>
                                    <a href="<?php echo $this->request->base.$url.'do_disable/'.$task['id']?>"><i class="fa fa-check-square-o " title="Disable"></i></a>&nbsp;
                                <?php else: ?>
                                    <a href="<?php echo $this->request->base.$url.'do_enable/'.$task['id']?>"><i class="fa fa-times-circle" title="Enable"></i></a>&nbsp;
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php echo $this->Paginator->first('First');?>&nbsp;
            <?php echo $this->Paginator->hasPage(2) ? $this->Paginator->prev(__('Prev')) : '';?>&nbsp;
            <?php echo $this->Paginator->numbers();?>&nbsp;
            <?php echo $this->Paginator->hasPage(2) ?  $this->Paginator->next(__('Next')) : '';?>&nbsp;
            <?php echo $this->Paginator->last('Last');?>
            <?php else:?>
                <?php echo __('No tasks found');?>
            <?php endif;?>
        </div>
    </div>
</div>
