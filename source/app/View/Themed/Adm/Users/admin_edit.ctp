<style>
#content {
	overflow: visible;
</style>

<?php
$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Users Manager'), array('controller' => 'users', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Edit'), array('controller' => 'users', 'action' => 'admin_edit'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "users"));
$this->end();
?>
<div class="portlet box">
    <div class="portlet-title">
        <div class="tools">
            <div class="btn-group pull-right">
                <a href="<?php echo $this->request->base?>/users/view/<?php echo $user['User']['id']?>" target="_blank" class="btn btn-gray" style="margin-right:5px;"><?php echo __('View Profile');?></a>

                <button data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" class="btn btn-fit-height btn-gray dropdown-toggle" type="button">
                   
                    <?php echo __('Actions');?>
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul role="menu" class="dropdown-menu pull-right">
                    <li><a href="<?php echo $this->request->base?>/admin/users/resend/<?php echo $user['User']['id']?>"><?php echo addslashes(__('Resend Validation Email'));?></a></li>
                    <li><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to remove all contents of this user?<br />This action cannot be undone!'));?>', '<?php echo $this->request->base?>/admin/users/delete_content/<?php echo $user['User']['id']?>')"><?php echo __('Remove All Contents');?></a></li>

                </ul>
            </div>
        </div>
    </div>
    <div class="portlet-body form">
<form action="<?php echo $this->request->base?>/admin/users/edit" id="edit_form" method="post" class="form-horizontal">
<?php echo $this->Form->hidden('id', array('value' => $user['User']['id'])); ?>
    <div class="form-body">
        <h4><?php echo __('Basic Information');?></h4>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo $this->Moo->getItemPhoto(array('User' => $user['User']),array("height" => "100px" ,"class" => "img_wrapper", 'prefix' => '100_square'))?><br /></label>
            <div class="col-md-9">
                <a class="btn btn-gray" href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to remove avatar of this user?'));?>', '<?php echo $this->request->base?>/admin/users/avatar/<?php echo $user['User']['id']?>')"><?php echo __('Remove Avatar');?></a><br />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Registered Date');?>:</label>
            <div class="col-md-9">
                <p class="form-control-static">
                    <?php echo $this->Moo->getTime($user['User']['created'], Configure::read('core.date_format'), $utz)?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Last Online');?>:</label>
            <div class="col-md-9">
                <p class="form-control-static">
                    <?php echo $this->Moo->getTime($user['User']['last_login'], Configure::read('core.date_format'), $utz)?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Stats');?>:</label>
            <div class="col-md-9">
                <p class="form-control-static">
                    <?php echo $user['User']['friend_count']?> <?php echo __('friends');?>, <?php echo $user['User']['photo_count']?> <?php echo __('photos');?>,
                    <?php echo $user['User']['blog_count']?> <?php echo __('blog entries');?>, <?php echo $user['User']['topic_count']?> <?php echo __('topics');?>, <?php echo $user['User']['video_count']?> <?php echo __('videos');?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Registered IP Address');?>:</label>
            <div class="col-md-9">
                <p class="form-control-static">
                    <?php echo $user['User']['ip_address']?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Role');?>:</label>
            <div class="col-md-4">
<?php
    $role_value = $user['User']['role_id'];
    $role_id = array_keys($roles);
    if(!in_array($user['User']['role_id'],$role_id))
        $role_value = 2;
?>
                    <?php echo $this->Form->select('role_id', $roles,
                        array( 'class' => 'form-control', 'value' => $role_value, 'disabled' => $cuser['id'] == ROOT_ADMIN_ID && $user['User']['id']  != ROOT_ADMIN_ID ? '' : 'disabled',
                            'empty' => false ) ); ?>
                
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Active');?>:</label>
            <div class="col-md-4">
                    <?php echo $this->Form->select('active', array( 0 => __('No'),
                            1 => __('Yes')),
                        array( 'class' => 'form-control','value' => $user['User']['active'], 'disabled' => $user['User']['id'] == ROOT_ADMIN_ID ? 'disabled' : '',
                            'empty' => false ) ); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Approved');?>:</label>
            <div class="col-md-4">
                    <?php echo $this->Form->select('approved', array( 0 => __('No'),
                            1 => __('Yes')),
                        array( 'class' => 'form-control','value' => $user['User']['approved'], 'disabled' => $user['User']['id'] == ROOT_ADMIN_ID ? 'disabled' : '',
                            'empty' => false ) ); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Confirmed');?>:</label>
            <div class="col-md-4">
                    <?php echo $this->Form->select('confirmed', array( 0 => __('No'),
                            1 => __('Yes')),
                        array( 'class' => 'form-control','value' => $user['User']['confirmed'], 'disabled' => $user['User']['id'] == ROOT_ADMIN_ID ? 'disabled' : '',
                            'empty' => false ) ); ?>

                
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Featured');?>:</label>
            <div class="col-md-4">
                    <?php echo $this->Form->select('featured', array( 0 => __('No'),
                            1 => __('Yes')),
                        array( 'class' => 'form-control','value' => $user['User']['featured'],
                            'empty' => false ) ); ?>
           
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Password');?>:</label>
            <div class="col-md-9">
                <p class="form-control-static">
                    <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "users",
                                            "action" => "admin_ajax_password",
                                            "plugin" => false,
                                            $user['User']['id']
                                            
                                        )),
             'title' => __('Change User Password'),
             'innerHtml'=> __('Change User Password'),
     ));
 ?>
                 
                </p>
            </div>
        </div>
        <?php echo $this->element('ajax/profile_edit', array('cuser' => $user['User'], 'role' => $user['Role']));?>
    </div>

</form>
    </div>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
<?php $this->Html->scriptEnd(); ?>