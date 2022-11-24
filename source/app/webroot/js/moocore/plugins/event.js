/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooFileUploader', 'mooAlert', 'mooBehavior', 'mooAjax', 'mooButton', 'mooPhrase', 'mooGlobal',
            'picker_date', 'picker_time', 'spinner','typeahead','bloodhound' ,'tagsinput'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooEvent = factory();
    }
}(this, function ($, mooFileUploader, mooAlert, mooBehavior, mooAjax, mooButton, mooPhrase, mooGlobal) {

    // app/Plugin/Event/View/Events/create.ctp
    var initOnCreate = function () {

        var uploader = new mooFileUploader.fineUploader({
            element: $('#select-0')[0],
            multiple: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions: mooConfig.photoExt,
                sizeLimit: mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/event/event_upload/avatar"
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function (id, fileName, response) {
                    $('#photo').val(response.filename);
                    $('#item-avatar').attr('src', response.thumb);
                    $('#item-avatar').show();
                    $('#photo').val(response.file_path);
                }
            }
        });

        $(".datepicker").pickadate({
            monthsFull: [mooPhrase.__('january'), mooPhrase.__('february'), mooPhrase.__('march'), mooPhrase.__('april'), mooPhrase.__('may'), mooPhrase.__('june'), mooPhrase.__('july'), mooPhrase.__('august'), mooPhrase.__('september'), mooPhrase.__('october'), mooPhrase.__('november'), mooPhrase.__('december')],
            monthsShort: [mooPhrase.__('jan'), mooPhrase.__('feb'), mooPhrase.__('mar'), mooPhrase.__('apr'), mooPhrase.__('may'), mooPhrase.__('jun'), mooPhrase.__('jul'), mooPhrase.__('aug'), mooPhrase.__('sep'), mooPhrase.__('oct'), mooPhrase.__('nov'), mooPhrase.__('dec')],
            weekdaysFull: [mooPhrase.__('sunday'), mooPhrase.__('monday'), mooPhrase.__('tuesday'), mooPhrase.__('wednesday'), mooPhrase.__('thursday'), mooPhrase.__('friday'), mooPhrase.__('saturday')],
            weekdaysShort: [mooPhrase.__('sun'), mooPhrase.__('mon'), mooPhrase.__('tue'), mooPhrase.__('wed'), mooPhrase.__('thu'), mooPhrase.__('fri'), mooPhrase.__('sat')],
            today: mooPhrase.__('today'),
            clear: mooPhrase.__('clear'),
            format: 'yyyy-mm-dd',
            close: false,
            onClose: function () {
                if ($('#to').val() != '' && ($('#from').val() > $('#to').val()))
                {
                    mooAlert.alert(mooPhrase.__('to_date_must_be_greater_than_from_date'));
                    $('#to').val('');
                }
                if ($('#to').val() != '' && ($('#from').val() >= $('#to').val()))
                {
                    var fromTime = parseInt($('#from_time_root .picker__list-item--selected').attr('data-pick'));
                    var toTime = parseInt($('#to_time_root .picker__list-item--selected').attr('data-pick'));
                    if ($('#to_time').val() != '' && toTime <= fromTime) {
                        mooAlert.alert(mooPhrase.__('to_time_must_be_greater_than_from_time'));
                        $('#to').val('');
                        $('#to_time').val('');
                    }
                }
            }
        });

        $(".timepicker").pickatime({
            clear: mooPhrase.__('clear'),
            format: mooConfig.time_format == '24' ? 'H:i' :  'h:i A', // FIXED_JS <?php echo (Configure::read('core.time_format') == '24') ? 'H:i' : 'h:i A'?>
            onClose: function (time) {
                if ($('#to').val() != '' && ($('#from').val() >= $('#to').val()))
                {
                    var fromTime = parseInt($('#from_time_root .picker__list-item--selected').attr('data-pick'));
                    var toTime = parseInt($('#to_time_root .picker__list-item--selected').attr('data-pick'));
                    if ($('#to_time').val() != '' && toTime <= fromTime) {
                        mooAlert.alert(mooPhrase.__('to_time_must_be_greater_than_from_time'));
                        $('#to').val('');
                        $('#to_time').val('');
                    }
                }
            }
        });


        $('#saveBtn').unbind('click');
        $('#saveBtn').click(function () {
            $(this).addClass('disabled');
            if (tinyMCE.activeEditor !== null) {
                $('#editor').val(tinyMCE.activeEditor.getContent());
            }
            mooBehavior.createItem('events', true);
        });
        
        // bind action to button delete
        deleteEvent();
    }
    
    // app/Plugin/Event/View/Events/view.ctp
    var initOnView = function(){
        // bind action to button delete
        deleteEvent();
        
        inviteMore();
        
        mooBehavior.registerEventThumb();
    }
    
    // app/Plugin/Event/View/Elements/lists/events_list.ctp
    var  initOnListing = function(){
        mooBehavior.initMoreResults();
        
        // bind action to button delete
        deleteEvent();
    }
    
    // app/Plugin/Event/View/Events/invite.ctp
    var initOnInvitePopup = function(){
        // init invite script
        inviteScript();
    }
    
    var inviteScript = function(){
    	var friends_userTagging = new Bloodhound({
            datumTokenizer:function(d){
                return Bloodhound.tokenizers.whitespace(d.name);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: mooConfig.url.base + '/users/friends.json',
                cache: false,
                filter: function(list) {

                    return $.map(list.data, function(obj) {
                        return obj;
                    });
                }
            },
            
            identify: function(obj) { return obj.id; },
		});
		
		friends_userTagging.initialize();


    	 $('#friends').tagsinput({
             freeInput: false,
             itemValue: 'id',
             itemText: 'name',
             typeaheadjs: {
                 name: 'friends_userTagging',
                 displayKey: 'name',
                 highlight: true,
                 limit:10,
                 source: friends_userTagging.ttAdapter(),
                 templates:{
                     notFound:[
                         '<div class="empty-message">',
                         	mooPhrase.__('no_results'),
                         '</div>'
                     ].join(' '),
                     suggestion: function(data){
	                     if($('#friends').val() != '')
	                     {
	                         var ids = $('#friends').val().split(',');
	                         if(ids.indexOf(data.id) != -1 )
	                         {
	                             return '<div class="empty-message" style="display:none">'+mooPhrase.__('no_results')+'</div>';
	                         }
	                     }
                         return [
                             '<div class="suggestion-item">',
                                 '<img alt src="'+data.avatar+'"/>',
                                 '<span class="text">'+data.name+'</span>',
                             '</div>',
                         ].join('')
                     }
                 }
             }
         });
        
        $('#sendButton').unbind('click');
        $('#sendButton').click(function(){
           
            $('#sendButton').spin('small');
            mooButton.disableButton('sendButton');
            $(".error-message").hide();
            mooAjax.post({
                url : mooConfig.url.base + '/events/sendInvite',
                data: $("#sendInvite").serialize()
            }, function(data){
                mooButton.enableButton('sendButton');
                $('#sendButton').spin(false);
                var json = $.parseJSON(data);
                if ( json.result == 1 )
                {
                    $('#sendButton').hide();
                    $('#simple-modal-body').html(json.msg);
                }
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }
            });
            return false;

        });
        
        $('#invite_type_event').change(function(){
			$('#invite_friend').hide();
			$('#invite_email').hide();
			if ($('#invite_type_event').val() == '1')
			{
				$('#invite_friend').show();
			}
			else
			{
				$('#invite_email').show();
			}
		});
    }
    
    var deleteEvent = function(){
        $('.deleteEvent').unbind('click');
        $('.deleteEvent').click(function(){
           
           var data = $(this).data();
           var deleteUrl = mooConfig.url.base + '/events/do_delete/' + data.id;
           mooAlert.confirm(mooPhrase.__('are_you_sure_you_want_to_remove_this_event'), deleteUrl);
        });
    }
    
    var inviteMore = function()
    {
        $('.inviteMore').unbind('click');
        $('.inviteMore').click(function(){
            
            var data = $(this).data();
            $('#langModal .modal-content').html('');
            $('#langModal .modal-content').spin('small');	
            $('#langModal .modal-content').load(data.url, function(){
                $('#langModal .modal-content').spin(false);
                $('#langModal').modal('show');
            });
        });
        
    }

    return {
        initOnCreate : initOnCreate,
        initOnView : initOnView,
        initOnListing : initOnListing,
        initOnInvitePopup : initOnInvitePopup
    }

}));