<?php $this->setCurrentStyle(4);?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_content inner404">
            <h1 class="inner_header_title"><?php echo __('<span>OOPS!</span> This page cannot be found')?></h1>
            <div class="inner_text"><?php echo __('Get back on track')?></div>
            <a class="btn btn-danger" href="<?php echo  $this->request->base; ?>/"><?php echo __('Go back home page')?></a>
            <div class="page-not-found-img">
                <img src="<?php echo $this->request->webroot?>img/page_not_found_1.png" />
            </div>
        </div>
    </div>
</div>