<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __('Change Language')?>
    </div>
</div>

<div class="modal-body">
    <ul class="list-group">
    <?php
    foreach ($site_langs as $lang_key => $lang):
        ?>
        <li><a href="<?php echo $this->request->base?>/home/do_language/<?php echo $lang_key?>"><?php echo $lang?></a></li>
    <?php
    endforeach;
    ?>
    </ul>
</div>