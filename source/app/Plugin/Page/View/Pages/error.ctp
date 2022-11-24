<?php if(!empty($error_msg)): ?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_content">
            <div id="flashMessage" class="alert alert-danger error-message"><?php echo $error_msg ?></div>
        </div>
    </div>
</div>
<?php endif; ?>