<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<div class="bar-content ">
    <div class="content_center">
        <div class="mo_breadcrumb">
            <h1 class="visible-xs visible-sm"><?php echo $groupname?></h1>
             <?php if ( !empty( $is_member ) ): ?> 
            <a href="javascript:void(0)" onclick="loadPage('photos', '<?php echo $this->request->base?>/photos/ajax_upload/group/<?php echo $target_id?>')" class="topButton button button-action button-mobi-top" ><?php echo __('Upload Photos')?></a>
            <?php endif; ?>
        </div>
       
        <div class="clear"></div>
        <div class="full_content p_m_10">
            
            <div class="<?php if ( !empty( $is_member ) ): ?> p_top_15<?php endif; ?>">
                <ul class='no-liststyle'>
            <?php echo $this->element( 'lists/photos_list', array( 'type' => 'Group_Group' ) ); ?>
                </ul>
            </div>
        </div>
    </div>
</div>