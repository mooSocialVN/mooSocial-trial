<div class="box2">
    <h3><?php echo __('Popular Tags')?></h3>
    <div class="box_content">
        <?php
        if (!empty($tags)):
            echo '<ul class="tags">';
            foreach ($tags as $tag): ?>
                <li><a href="<?php echo $this->request->base?>/search/hashtags/<?php echo h($tag['Tag']['tag'])?>"><?php echo h($tag['Tag']['tag'])?></a></li>
            <?php
            endforeach;
            echo '</ul>';
        else:
            echo '<div class="nothing_found">' . __('Nothing found') . '</div>';
        endif;
        ?>
    </div>
</div>

