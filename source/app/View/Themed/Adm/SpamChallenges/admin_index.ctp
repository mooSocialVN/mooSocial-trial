<?php
$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Spam Challenges'), array('controller' => 'spam_challenges', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "spam_challenges"));
$this->end();

?>
<?php $this->Html->scriptStart(array('inline' => false)) ?>
$('#ajax').on('hide.bs.modal', function(e) {
    $(this).removeData('bs.modal');
});
<?php $this->Html->scriptEnd(); ?>

    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <button class="btn btn-gray" data-toggle="modal" data-target="#ajax" href="<?php echo $this->request->base?>/admin/spam_challenges/ajax_create">
                            <?php echo  __('Add New');?>
                        </button>
                    </div>

                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding-top: 5px;">
                    <div class="note note-info">

                        <p>

                            <?php echo  __('You can enable Spam Challenge to force user to answer a challenge question in order to register.');?> <br/>
                            <?php echo  __('To enable this feature, click System Settings -> Security -> Enable Spam Challenge'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                <tr>
                    <th width="20px"><?php echo __('ID');?></th>
                    <th><?php echo __('Question');?></th>
                    <th width="50px"><?php echo  __('Active');?></th>
                    <th width="50px"><?php echo  __('Actions');?></th>
                </tr>
                </thead>
                <tbody>

                <?php $count = 0;
                foreach ($challenges as $challenge): ?>
                    <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                        <td width="20px"><?php echo $challenge['SpamChallenge']['id']?></td>
                        <td><?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "spam_challenges",
                                            "action" => "admin_ajax_create",
                                            "plugin" => false,
                                            $challenge['SpamChallenge']['id']
                                          
                                        )),
             'title' => $challenge['SpamChallenge']['question'],
             'innerHtml'=> $challenge['SpamChallenge']['question'],
     ));
 ?>
                            </td>
                        <td width="50px"><?php echo ($challenge['SpamChallenge']['active']) ? __('Yes') : __('No')?></td>
                        <td width="50px"><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this challenge?'));?>', '<?php echo $this->request->base?>/admin/spam_challenges/delete/<?php echo $challenge['SpamChallenge']['id']?>')"><i class="icon-trash icon-small"></i></a></td>
                    </tr>
                <?php endforeach ?>

                </tbody>
            </table>


    </div>
<!--</div>
<a href="javascript:$('#modal .modal-body').load('remote.html',function(e){$('#modal').modal('show');});">Click me</a>