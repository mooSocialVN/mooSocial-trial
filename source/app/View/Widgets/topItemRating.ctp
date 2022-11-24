<?php
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
if(empty($num_item_show)) $num_item_show = 10;
if(empty($title)) $title = "Top Rating Item";
?>
<?php if(!empty($ratings)): ?>
    <div class="box2">
        <?php if($title_enable): ?>
            <h3><?php echo $title;?></h3>
        <?php endif ?>
        <div class="box_content">
            <?php
            if (!empty($ratings)):
                echo '<ul class="top-item-rating blog-content-list">';
                foreach ($ratings as $item): ?>
                    <?php
                    $name = Inflector::classify($item['Rating']['type']);
                    if($name == 'Profile') $name = 'User';
                    ?>
                    <li class="full_content p_m_10">
                        <?php if($name == 'User'): ?>
                            <?php echo $this->Moo->getItemPhoto(array($name => $item[$name]), array( 'prefix' => '50_square'), array('class' => 'img_wrapper2 user_avatar_large'))?>
                        <?php elseif($name == 'Album'): ?>
                               <img src="<?php echo $pluginHelper->getAlbumCover($item['Album']['cover'], array('prefix' => '75_square'));?>" class="img_wrapper2 user_avatar_large" />
                        <?php else: ?>
                            <?php
                                $helperName = !empty($item['plugin'])? $item['plugin'].$name : $name;
                                $pluginHelper = MooCore::getInstance()->getHelper($helperName);
                                if(!empty($pluginHelper) && method_exists($pluginHelper,'getImage')):
                            ?>
                                    <a href="<?php echo $item['link']; ?>" prefix="50_square">
                                        <img src="<?php echo $pluginHelper->getImage(array($name => $item[$name]), array('prefix' => '75_square'))?>" class="img_wrapper2 user_avatar_large" />
                                    </a>
                                <?php else: ?>
                                    <?php echo $this->Moo->getItemPhoto(array($name => $item[$name]), array( 'prefix' => '50_square'), array('class' => 'img_wrapper2 user_avatar_large'))?>
                                <?php endif; ?>
                        <?php endif; ?>
                        <?php if(!empty($item['name'])): ?>
                            <div class="rating-info" style="margin-left: 70px;">
                                <a href="<?php echo $this->request->base.'/'.$item['link'] ?>"><?php echo h($item['name'])?></a>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php
                endforeach;
                echo '</ul>';
            else:
                echo '<div class="nothing_found">' . __('Nothing found') . '</div>';
            endif;
            ?>
        </div>
    </div>
<?php endif; ?>