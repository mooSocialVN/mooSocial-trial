<div class="modal-header">
    <button onclick="return $(this).parents('.notify_content').find('#notificationDropdown').dropdown('toggle')" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __('Access Denied')?>
    </div>
</div>
<div class="modal-body">
    <div class="bar-content full_content p_m_10">
        <div class="content_center">
            <?php echo __('You do NOT have permission to access this page. Please contact your site administrator(s) request access.');?>
        </div>
    </div>
</div>