<div class="modal-header">
    <h4 class="modal-title"><?php echo __('Notification detail');?></h4>
</div>
<div class="modal-body report-detail">
<?php echo $this->Moo->getName( $notification['User'] )?> <?php echo $notification['AdminNotification']['text']?>
<p>"<?php echo $this->Moo->formatText($notification['AdminNotification']['message'])?>"</p>
<div align="center">
    <a href="<?php echo $notification['AdminNotification']['url']?>" class="btn blue"><?php echo __('View');?></a>
</div> 
</div>