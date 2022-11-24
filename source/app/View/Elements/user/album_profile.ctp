<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
$friendModel = MooCore::getInstance()->getModel('Friend');
$photoModel = MooCore::getInstance()->getModel('Photo_Photo');
?>

<?php if (Configure::read('Photo.photo_enabled')): ?>
    <?php if (!empty($albums)): ?>
        <div class="box2 bar-content-warp">
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo __('Album Photo')?></h3>
                </div>
            </div>
            <div class="box_content box_profile_album box-region-<?php echo $region ?>">
                <div class="photo-lists profile-photo-lists">
                    <?php foreach ($albums as $album): ?>
                        <?php
                        $covert = '';
                        if ($album['Album']['type'] == 'newsfeed' &&  $role_id != ROLE_ADMIN && $uid != $album['Album']['user_id'] && (!$uid || $friendModel->areFriends($uid,$album['Album']['user_id'])))
                        {
                            $photo = $photoModel->getPhotoCoverOfFeedAlbum($album['Album']['id']);
                            if ($photo)
                            {
                                $covert = $photoHelper->getImage($photo, array('prefix' => '150_square'));
                            }
                            else
                            {
                                $covert = $photoHelper->getAlbumCover('', array('prefix' => '150_square'));
                            }
                        }
                        else
                        {
                            $covert = $photoHelper->getAlbumCover($album['Album']['cover'], array('prefix' => '150_square'));
                        }
                        ?>
                        <div class="photo-item">
                            <div class="photo-item-warp">
                                <a class="layer_square" style="background-image:url(<?php echo $covert?>);" href="<?php echo $this->request->base?>/albums/view/<?php echo $album['Album']['id']?>"></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>