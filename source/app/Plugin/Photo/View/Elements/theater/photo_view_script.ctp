<?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooPhoto'),'object'=>array('$','MooPhoto'))); ?>
// fix "history.pushstatse" bug
if( typeof mooPhrase === 'undefined') {
    window.location.reload(true);
}
var targetX, targetY;
var tagCounter = 0;
var tagging  = false;
var page = 2;
var photo_id = <?php echo $photo['Photo']['id']?>;
var photo_thumb = '<?php echo $photo['Photo']['thumbnail']?>';
var tag_uid = 0;
var loaded = false;
<?php if ( !empty( $this->request->named['uid'] ) ): ?>
tag_uid = <?php echo $this->request->named['uid']?>;
<?php endif; ?>

//$('body').addClass('lightbox_mode');

window.onpopstate = function(event) {
    if(event && event.state) {
            //displayPhoto(event.state.photo_id);
    }
};
MooPhoto.setPhotoId(photo_id);
function loadMoreThumbs()
{
    
    $('#photo_wrapper').spin('large');
    $.post('<?php echo $this->request->base?>/photos/ajax_fetch', {type: '<?php echo $type?>', target_id: <?php echo $target_id?>, page: page }, function(data)
    {
        $('#photo_wrapper').spin(false);
        if ( data != '' )
        {
            page++;
            $('#photo_thumbs ul').append(data);
            $('#photo_load_btn').parent().remove();
        }
    });
}

function showPhotoWrapper()
{
    if ( loaded )
        return;

    loaded = true;

    var preload = $('#preload').html();

    if ( preload != '' )
    {
        $('#preload').html('');
        element = $('<div>'+preload + '</div>');
        $('#photo-content #tag-wrapper').hide();
		
        $('#photo-content .photo_comments').html(element.find('.photo_comments').html());
        $('#photo_wrapper .info').html(element.find('.info').html());
        
        $('#photo-content #tag-wrapper').html(element.find('#tag-wrapper').html());        
        $('#photo-content #lb_description').html(element.find('#lb_description').html());
        $('#photo_wrapper').spin(false);
        
        //$('#photo-content').html(preload);
        $('#photo_thumbs .active').removeClass('active');
        $('#photo_thumb_' + photo_id).addClass('active');
        registerOverlay();
        $(".sharethis").hideshare({media: $('#photo_src').attr('src'), linkedin: false,link:window.location.href});

        if ( tagging )
            tagPhoto();
        
        MooPhoto.displayPhoto();
        $('#photo_src').css('visibility','visible');
    }

    $('#photo_wrapper').fadeIn();
}

function set_photo_as_cover(photo_id){
    $('#set_cover').spin('tiny');
    $.post('<?php echo $this->request->base?>/users/set_photo_as_cover', {photo_id: photo_id}, function(response)
    {
        var data = $.parseJSON(response);
        window.location = data.url;
    });
}

function set_photo_as_profile_picture(photo_id){
    $('#set_avatar').spin('tiny');
    $.post('<?php echo $this->request->base?>/users/set_photo_as_profile_picture', {photo_id: photo_id}, function(response)
    {
        var data = $.parseJSON(response);
        window.location = data.url;
    });
}

function showPhoto(id,no_click_thumb)
{
	if(typeof no_click_thumb == "undefined") 
		no_click_thumb = false;
	
	if (no_click_thumb)
	{
		MooPhoto.getThumblist().setCurrent($('#photo_thumb_' + id).index());
	}
    photo_id = id;
    $('#photo_wrapper').spin('large');
    var url = '';
    loaded = false;

    if ( tag_uid )
        url = id + '/uid:' + tag_uid;
    else
        url = id;
    var url_nocache = url + '/time/' + (new Date()).getTime();
    $('#preload').load( '<?php echo $this->request->base?>/photos/ajax_view_theater/' + url_nocache, {noCache: 0}, function(){
        //$('#photo_position').html($('#photo_thumb_' + id).attr('photo-position'))
    });
    //photo_id: photo_id
    window.history.pushState({photo_id: photo_id},"", '<?php echo $this->request->base?>/photos/view/' + url);


}

function submitTag( uid, tagValue )
{
    if ( uid != '' || $("#tag-name").val() != '' )
    {
        var style = 'left:' + targetX + 'px; top:' + targetY + 'px';
        $('#photo_wrapper').spin('large');
        $.post( '<?php echo $this->request->base?>/photos/ajax_tag', {photo_id: photo_id, uid: uid, value: $("#tag-name").val(), style: style}, function( data ){
            $('#photo_wrapper').spin(false);
            var json = $.parseJSON(data);

            if ( json.result == 1 )
            {
                if ( uid )
                    tagValue = '<a href="<?php echo $this->request->base?>/users/view/' + uid + '">' + tagValue + '</a>';
                else
                    tagValue = $("#tag-name").val();

                $("#tags").append('<span id="hotspot-item-' + tagCounter + '" onmouseover="showTag(' + tagCounter + ')" onmouseout="hideTag(' + tagCounter + ')">' + tagValue + '<a href="javascript:void(0)" onclick="removeTag(' + tagCounter + ', ' + json.id + ')"><i class="material-icons cross-icon-sm">clear</i></a></span>');
                $("#tag-wrapper").append('<div id="hotspot-' + tagCounter + '" class="hotspot" style="' + style + '"><span>' + tagValue + '</span></div>');

                //Adds a new hotspot to image
                closeTagInput();
                tagCounter++;
            }
            else
                mooAlert(json.message);
        });
    }
}
function closeTagInput() {
    $("#tag-target").fadeOut();
    $("#tag-input").fadeOut();
    $("#tag-name").val("");
}
function removeTag(i, tag_id) {
    $("#hotspot-item-"+i).fadeOut();
    $("#hotspot-"+i).fadeOut();
    $.post( '<?php echo $this->request->base?>/photos/ajax_remove_tag', {tag_id: tag_id} );
}
function showTag(i) {
    $("#hotspot-"+i).addClass("hotspothover");
}
function hideTag(i) {
    $("#hotspot-"+i).removeClass("hotspothover");
}
function tagPhoto() {
    tagging = true;
    $("#tag-wrapper img").css('cursor', 'crosshair');
    $("#tagPhoto").html('<a href="javascript:void(0)" onclick="doneTagging()"><?php echo __( 'Done Tagging')?></a>');

    $("#tag-wrapper img").click(function(e){
        if ( tagging )
        {
            //Determine area within element that mouse was clicked
            mouseX = e.pageX - $("#tag-wrapper").offset().left;
            mouseY = e.pageY - $("#tag-wrapper").offset().top;

            //Get height and width of #tag-target
            targetWidth = $("#tag-target").outerWidth();
            targetHeight = $("#tag-target").outerHeight();

            //Determine position for #tag-target
            targetX = mouseX-targetWidth/2;
            targetY = mouseY-targetHeight/2;

            //Determine position for #tag-input
            inputX = mouseX+targetWidth/2;
            inputY = mouseY-targetHeight/2;

            //Animate if second click, else position and fade in for first click
            if($("#tag-target").css("display")=="block")
            {
                $("#tag-target").animate({left: targetX, top: targetY}, 500);
                $("#tag-input").animate({left: inputX, top: inputY}, 500);
            } else {
                $("#tag-target").css({left: targetX, top: targetY}).fadeIn();
                $("#tag-input").css({left: inputX, top: inputY}).fadeIn();
            }

            //Give input focus
            $("#tag-name").focus();

            $("#friends_list").html( $("#friends").html() );
        }
    });

    //If cancel button is clicked
    $('#tag-cancel').click(function(){
        closeTagInput();
        return false;
    });

    //If enter button is clicked within #tag-input
    $("#tag-name").keyup(function(e) {
        if(e.keyCode == 13) submitTag(0, '');
    });

    //If submit button is clicked
    $('#tag-submit').click(function(){
        submitTag(0, '');
        return false;
    });
}
function doneTagging() {
    tagging = false;
    $("#tag-wrapper img").css('cursor', 'default');
    $("#tagPhoto").html('<a href="javascript:void(0)" onclick="tagPhoto()"><?php echo addslashes(__( 'Tag Photo'))?></a>');
    //$('#tag-wrapper img').unbind();
    $('#tag-name').unbind();
    $('#tag-submit').unbind();
    closeTagInput();
}

function deletePhoto(nextPhoto)
{
    nextPhoto = typeof nextPhoto !== 'undefined' ? nextPhoto : '0';
    mooConfirm('<?php echo addslashes(__( 'Are you sure you want to delete this photo ?'))?>','<?php echo $this->request->base?>/photos/ajax_remove/photo_id:'+ photo_id+'/next_photo:'+nextPhoto);
}
$(document).keydown(function(e) {
    if (!$('#theaterPhotoComment').is(':focus')){
        if(e.keyCode == 37){
            //ctrl + leftbutton pressed
            $("#photo_left_arrow_lg").trigger("click");
         }else if(e.keyCode == 39){
            //ctrl + rightbutton pressed
            $("#photo_right_arro_lgw").trigger("click");
         }
    }
});
$(document).ready(function(){
    $('#photo_thumbs ul li').click(function(){
        $('#photo_thumbs ul li').removeClass('active');
        $(this).addClass('active');
    });
    $('#photo_wrapper').spin()    
    $('#tag-wrapper').hide();
    $(".sharethis").hideshare({media: '<?php echo FULL_BASE_URL . $this->request->webroot .'uploads/photos/thumbnail/'. $photo['Photo']['id']. '/' .$photo['Photo']['thumbnail'];?>', linkedin: false});
	var id = <?php echo $photo['Photo']['id']; ?>;
    if ( tag_uid )
        url = id + '/uid:' + tag_uid;
    else
        url = id;

    window.current_state = window.location.href;
    window.history.pushState({photo_id: photo_id},"", '<?php echo $this->request->base?>/photos/view/' + url);

});

<?php $this->Html->scriptEnd(); ?>


