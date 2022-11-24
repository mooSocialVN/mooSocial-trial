<div class="bar-feed-warp">
    <div class="feed_breadcrumb">
        <h1 class="feed_breadcrumb_title"><?php echo __('Recent Activities')?></h1>
    </div>

    <?php $this->MooActivity->wall($profileActivities)?>
</div>