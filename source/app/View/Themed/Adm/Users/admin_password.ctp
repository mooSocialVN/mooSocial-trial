<?php echo $this->element('adminnav', array("cmenu" => "users"));?>

<form action="<?php echo $this->request->base?>/admin/users/password" method="post">
<?php echo $this->Form->hidden('id', array('value' => $id)); ?>
<div id="center">   
    <div style="float:right">
        <a href="<?php echo $this->request->base?>/admin/users/edit/<?php echo $id?>" class="butLink topButton button-blue">Edit Profile</a>
    </div>
    <h1>Change User's Password</h1>  
    
    <ul class="list6">
        <li><label><?php echo __('New Password')?></label><?php echo $this->Form->password('password'); ?></li>
        <li><label><?php echo __('Verify Password')?></label><?php echo $this->Form->password('password2'); ?></li>
    </ul>
    <div align="center" style="margin-top:10px"><input type="submit" value="<?php echo __('Change Password');?>"></div>
</div>
</form>