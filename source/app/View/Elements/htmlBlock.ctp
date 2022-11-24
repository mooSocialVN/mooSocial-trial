<?php
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
if(empty($title)) $title = "";
if(empty($html_block)) $html_block = "";
?>
<?php if(!empty($html_block)): ?>
<div class="box2 html_block">
    <?php if($title_enable): ?>
    <h3><?php echo $title;?></h3>
    <?php endif ?>
    <div class="box_content">
        <?php
            echo htmlspecialchars_decode($html_block);
        ?>
    </div>
</div>
<?php endif; ?>