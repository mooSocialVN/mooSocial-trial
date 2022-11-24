<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
$this->Html->addCrumb(__d("setting",'Storage System'), null);
$url = Router::url(array(
	'plugin'=>'storage',
	'controller' => 'storages',
	'action' => 'admin_index'));
$this->Html->addCrumb(__('Manage Storage Services'), $url);
$this->Html->addCrumb(__('Local Storage'), null);
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array('cmenu' => 'Storage System'));
$this->end();
?>

<div class="row">
	<div class="col-md-12" style="padding-top: 5px;">
		<div class="note note-info">
			<p>
				<?php echo __("Processing, Please Wait...");?>
			</p>
			<div class="progress progress-striped active">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
					<span class="sr-only"> 85% Complete </span>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$( document ).ready(function() {
		setTimeout(function(){ window.location = "<?php echo $url;?>"; }, 1000);
	});
<?php $this->Html->scriptEnd(); ?>