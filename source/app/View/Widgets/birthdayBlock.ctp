<?php

if ( !( empty($uid) && Configure::read('core.force_login') ) ):

    if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
    $new_utz = str_replace('/','-',$utz);
    ?>
    <?php if ( !empty( $birthday ) ): ?>
    <div class="box2 bar-content-warp">
        <?php if($title_enable): ?>
            <?php if(empty($title)) $title = __("Today's Birthdays");?>
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title">
                    <?php echo $title;?>
                </h3>
            </div>
        </div>
        <?php endif; ?>
        <div class="box_content box-region-<?php echo $region ?>">
            <?php if ( !empty( $birthday ) ): ?>
                <div class="info-birthday">
                   <div class="birthday-item">
                        <?php
                        $this->MooPopup->tag(array(
                            'href'=>$this->Html->url(array(
                                "controller" => "users",
                                "action" => "ajax_birthday_more",
                                "plugin" => false,
                                'utz:' . $new_utz
                            )),
                             'title' => '',
                             'innerHtml'=> __("%s's",$birthday[0]['User']['name']),
                             'data-dismiss' => 'modal',
                             'target' => 'langModal'
                         ));
                        ?>

                        <?php if(count($birthday)>1):?>
                            <?php if(count($birthday)==2): ?>
                                <?php echo __('&'); ?>  <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "users",
                                            "action" => "ajax_birthday_more",
                                            "plugin" => false,
                                            'utz:' . $new_utz,

                                        )),
             'title' => '',
             'innerHtml'=> __("%s's birthday is today!",$birthday[1]['User']['name']),
          'data-dismiss' => 'false',
          'target' => 'langModal',
     ));
 ?>
                            <?php else: ?>
                                <?php echo __('&'); ?>  <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "users",
                                            "action" => "ajax_birthday_more",
                                            "plugin" => false,
                                            'utz:' . $new_utz,

                                        )),
             'title' => '',
             'innerHtml'=> count($birthday) -1 . " " . __("others birthday is today!"),
          'data-dismiss' => 'false',
          'target' => 'langModal',
     ));
 ?>
                            <?php endif; ?>
                        <?php else:?>
                            <?php echo __("birthday is today!"); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>
<?php
endif;
?>
