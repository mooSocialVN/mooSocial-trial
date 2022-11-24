<?php
    if(empty($class)){
        $class = 'alert alert-success';
    }
?>
<div id="<?php echo h($key) ?>Message" class="flash_message <?php echo h($class) ?>">
    <?php echo $message ?>
</div>
