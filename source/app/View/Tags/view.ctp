<?php $this->setCurrentStyle(2);?>
<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
    <div class="bar-content">
	<?php echo $this->element('blocks/tags_block'); ?>
    </div>
<?php $this->end(); ?>

<div class="bar-content">
    <div class="content_center">
        <div class="mo_breadcrumb">
            <h1><?php echo __('Tag')?> "<?php echo $tag?>"</h1>
            <?php if ( !empty( $items ) ): ?>
            <ul class="list7 header-list">
                    <li><a href="<?php echo $this->request->webroot?>search/hashtags/<?php echo $tag?>" <?php if ( $order != 'like_count' ) echo 'class="current"'; ?>><?php echo __('Latest')?></a></li>
                    <li><a href="<?php echo $this->request->webroot?>search/hashtags/<?php echo $tag?>/popular" <?php if ( $order == 'like_count' ) echo 'class="current"'; ?>><?php echo __('Popular')?></a></li>
            </ul>
            <?php endif; ?>
        </div>
	<?php if ( !empty( $items ) ): ?>
	<ul class="list6 comment_wrapper list-mobile" id="list-content">
            <?php 
            foreach ($items as $item): 
                    if ( $unions == 1 )
                        $item[0] = array_merge( $item[0], $item['i'] );
                    $subject = MooCore::getInstance()->getItemByType($item[0]['moo_type'],$item[0]['id']);
                    if (key($subject)=='Album'){
                        $photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
                        $img = "<img style='width:140px;float:left' class='img_wrapper2' src='".$photoHelper->getAlbumCover($subject[key($subject)]['cover'], array('prefix' => '150_square'))."' />";
                    }else {
                        $img = $this->Moo->getImage(array(key($subject) => $subject[key($subject)]),array('prefix'=> '150_square','style'=>'width:140px;float:left','class'=>'img_wrapper2'));                    
                    }
                    
            ?>
            <li class="full_content p_m_10 ">	
            	<a  href="<?php echo $subject[key($subject)]['moo_href']?>"><?php echo $img; ?></a>            	
                <div class="tag_right">
                	<?php echo $this->Html->link($subject[key($subject)]['moo_title'],$subject[key($subject)]['moo_url']);?>    
                    <br />
                    <div class="comment_message date">
                            <?php echo __('Posted by')?> <?php echo $this->Html->link($subject['User']['moo_title'],$subject['User']['moo_url']);?> <?php echo $this->Moo->getTime($item[0]['created'], Configure::read('core.date_format'), $utz)?> .
                            <?php echo __n( '%s like', '%s likes', $item[0]['like_count'], $item[0]['like_count'] )?>
                    </div>
                </div>	
            </li>
            <?php endforeach; ?>
	</ul>
	<?php else: ?>
		<div class="full_content p_m_10" align="center"><?php echo __('Nothing found')?></div>
	<?php endif; ?>
    </div>
</div>