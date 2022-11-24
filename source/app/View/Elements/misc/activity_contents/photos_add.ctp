<?php $c = count($activity['Content']); ?>
<div class="list4 activity_content p_photos photo_addlist">
    
    <?php if($c == 1): ?>
        <?php foreach ( $activity['Content'] as $key => $photo ): ?>
            <div class="div_single">
                
                    <a href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?>#content">
                        <img class="single_img" src="<?php echo $this->request->webroot?><?php echo $photo['Photo']['path']?>" alt="" />
                    </a>	   
               
            </div>					
        <?php endforeach; ?>
    <?php elseif ($c==2): ?>
        <?php foreach ( $activity['Content'] as $key => $photo ): ?>
            <div class="col-xs-6">
                <div class="p_2">
                    <a class="layer_square" style="background-image:url(<?php echo $this->request->webroot?><?php echo $photo['Photo']['thumb']?>);" href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?>#content"></a>
                </div>
            </div>					
        <?php endforeach; ?>
    <?php elseif ($c==3): ?>
          <?php foreach ( $activity['Content'] as $key => $photo ): ?>
            <?php if($key == 0): ?>   
            <div class="PE">
                <div class="ej">
                    <a class="layer_square" href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?>#content">
                        <img src="<?php echo $this->request->webroot?><?php echo $photo['Photo']['path']?>" alt="" />
                    </a>	   
                </div>
            </div>
            <?php else: ?>
                <?php if($key == 1): ?>
                <div class="QE">
                <?php endif; ?> 
                    <div class="sp <?php if($key == 2): ?>eq<?php endif; ?>">
                        <a class="layer_square" href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?>#content">
                            <img src="<?php echo $this->request->webroot?><?php echo $photo['Photo']['thumb']?>" alt="" />
                        </a>	   
                    </div>
                <?php if($key == 1): ?>
                
                <?php endif; ?>   
            <?php endif; ?>
        <?php endforeach; ?>  
        </div>
    <?php elseif ($c==4): ?>   
        <?php foreach ( $activity['Content'] as $key => $photo ): ?>
           <?php if($key == 0): ?>   
            <div class="PE">
                <div class="ej1">
                    <a class="layer_square" href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?>#content">
                        <img src="<?php echo $this->request->webroot?><?php echo $photo['Photo']['path']?>" alt="" />
                    </a>	   
                </div>
            </div>
            <?php else: ?>
                <?php if($key == 1): ?>
                <div class="QE">
                <?php endif; ?> 
                    <div class="sp1 <?php if($key == 2): ?>eq1<?php endif; ?>">
                        <a class="layer_square" href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?>#content">
                            <img src="<?php echo $this->request->webroot?><?php echo $photo['Photo']['thumb']?>" alt="" />
                        </a>	   
                    </div>
            <?php endif; ?>
            
        <?php endforeach; ?> 
        </div>
    <?php endif; ?>
</div>
<div class="clear"></div>