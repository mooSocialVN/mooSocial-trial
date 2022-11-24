<div class="tabbable-custom">
    <ul class="nav nav-tabs list7 chart-tabs">
        <li <?php if ($cmenu == 'setting') echo 'class="active"'; ?>>
            <a href="<?php echo $this->request->base?>/admin/themes/setting/<?php echo $theme_id ?>"><?php echo  __('Theme Settings');?></a>
        </li>  
        <li <?php if ($cmenu == 'css') echo 'class="active"'; ?>>
            <a href="<?php echo $this->request->base?>/admin/themes/editor/<?php echo $theme_id ?>"><?php echo  __('Css');?></a>
        </li>
        <li <?php if ($cmenu == 'elements') echo 'class="active"'; ?>>
            <a href="<?php echo $this->request->base?>/admin/themes/elements/<?php echo $theme_id ?>"><?php echo  __('Elements');?></a>
        </li>
    </ul>
</div>    

