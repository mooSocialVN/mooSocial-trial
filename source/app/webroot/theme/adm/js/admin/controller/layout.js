
$(function () {
    MooLayout.init();
    function addParam(container){
        var a = container.find('li :last a');
        
    }

    $("a[data-target=#myModal]").click(function(ev) {
        ev.preventDefault();
        var target = $(this).attr("href");

        // load the url and show modal on success
        $("#myModal .modal-body").load(target, function() {
            $("#myModal").modal("show");
        });
    });
});
var MooLayout = function () {
    var currentPage,pageContent,avaiablePages,avaiableBlocks,column_layout,container,block_editing,currentPageUri,landingPage,currentCustomEl,translate;
    var url = {};
    var blocks = {};
    var droppedWidget;
    var handleFilter = function () {
        $('.dropdown-checkboxes').on('click','div', function () {

            if($(this).parent().text().trim() == 'All'){
                if($(this).children().attr('class')==''){
                    $('.dropdown-checkboxes label:not(:first) div span').removeClass('checked');
                }
            }else{
                $('.dropdown-checkboxes label:first div span').removeClass('checked');
            }
            var span_checked = $(this).find('span');
            if(span_checked.hasClass('checked')){
                span_checked.removeClass('checked');
            }else{
                span_checked.addClass('checked');
            }

        });
        $('.filter-now').click(function(){
            $('.filter a').dropdown('toggle');
            var filter_group = $('.filter').find('span[class="checked"]');

            var params ='';
            for(var i =0; i<filter_group.length;i++){
                params+=($(filter_group[i]).parents('label').text().trim())+',';
            }
            params = params.substr(0,params.length-1);

            $.post(url.admin_filter,{'value':params},function(data){
                if(data != ''){
                    $("#nestable_list_2 .dd-list").html(data);
                    $('#nestable_list_2').find('li[data-uri]').css({display:'none'});
                    $('#nestable_list_2').find('li[data-uri*="'+currentPageUri+'"]').css({'display':'block'});
                    initDragDrop();
                }
            });
        });
    }

    var initDragDrop = function(dropEl,regionId){
        var connectWith;
        if(typeof(regionId) === 'undefined')
            regionId = '';

        if(typeof (dropEl) === 'undefined' || dropEl == null){
            $(".dd-list li").draggable({
                appendTo: "#block-placement",
                containment: 'window',
                scroll: false,
                revert: "invalid",
                cursorAt: { bottom: 0 },
                helper: "clone"
            });
            connectWith = regionId+' .tabs-container';
            dropEl = '.moo-container';
        }
        else
        {
            connectWith = regionId+'.moo-container, '+regionId+' .tabs-container'
        }
        $(dropEl).droppable({
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            accept: ":not(.ui-sortable-helper)",
            greedy:true,
            drop: function (event, ui) {
                avaiableBlocks = ui.draggable.data('id');
                    $(this).find(".placeholder").remove();
                    droppedWidget = $(ui.draggable.clone()).appendTo($(this).find('.dd-list')[0]);
                    $($(this).find('.dd-list')[0]).find('li:last div').css({'background-color': '#CDECFF'});
                    $($(this).find('.dd-list')[0]).find('li:last').attr('data-display-name',blocks[avaiableBlocks][1]);
                    $($(this).find('.dd-list')[0]).find('li:last').attr('data-id','0');
                    var text = $($(this).find('.dd-list')[0]).find('li:last div').html();
                    $($(this).find('.dd-list')[0]).find('li:last div').html('<span>'+text+'</span>')
                    $($(this).find('.dd-list')[0]).find('li:last div').append(' <i class="fa fa-times pull-right delete-element" style="cursor:pointer; margin-top:3px;"></i> <a href="javascript:void(0)" class="edit-block pull-right" data-block-id="'+avaiableBlocks+'"><i class="fa fa-pencil"></i></a>');
                    var a = $($($(this).find('.dd-list')[0]).find('li:last div').find('a')[0]);


                $.each( blocks[avaiableBlocks][0], function( key, value ) {
                    if(value.name == 'title')
                        a.attr('data-input'+key+'-value', blocks[avaiableBlocks][2]);
                    else if(typeof(value.value) === 'object')//this is an object
                    {
                        var firstVal = Object.keys(value.value)[0];
                        a.attr('data-input'+key+'-value',value.value[firstVal]);
                    }
                    else
                        a.attr('data-input'+key+'-value',value.value);
                    a.attr('data-input'+key+'-name',value.name);
                    
                });
                showEditContent(avaiableBlocks,$(this).find('.dd-list')[0]);
            }
        }).sortable({
            items: "li:not(.ui-sortable-placeholder)",
            connectWith: connectWith,
            receive:function(event, ui){
                if((ui.item.attr('data-display-name') == 'tabsWidget') || (ui.sender.hasClass('moo-container') && !ui.sender.is($(event.target).parents('.moo-container'))))
                {
                    $(ui.sender).sortable('cancel');
                }
                else
                {

                    var tabsLi = $(event.target).children('.dd-list').children('li');
                    if(tabsLi.length >0)
                    {
                        $(event.target).find(".ui-sortable-placeholder").remove();
                        var i = 0; //used as flag to find out if element added or not
                        tabsLi.each(function(key, value)
                        {
                            if($(value).offset().top >= ui.offset.top)  //compare
                            {
                                i = 1;
                                $(ui.item).insertBefore($(value));
                                return false; //break loop
                            }
                        })
                        if(i != 1)
                        {
                            $(event.target).children('.dd-list').append(ui.item);
                        }
                    }
                    else
                    {
                        $(event.target).children('.dd-list').append(ui.item);
                    }
                }
            },
            stop: function(event,ui){//used to fix the location of li
                if(($(event.target).hasClass('tabs-container')) && $(event.target).children('li').length > 0)
                {
                    $(event.target).children('.dd-list').append(ui.item);
                    $(event.target).remove('li:last');
                }
            },
            sort: function (event, ui) {
                // gets added unintentionally by droppable interacting with sortable
                // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
                $(this).removeClass("ui-state-default");
            }
        }).disableSelection();
    }
    var initPageInfo=function(){

        // Step 1 - detect current page - using currentPage - check it not empty
        if ( currentPage == 0 ){
            
            return;
        }
        // Step 2 - define url and data for initPageInfo
        var short_url = url.admin_editpageinfo_pageId//"<?php echo $this->Html->url(array('controller' => 'Layout','action' => 'admin_editpageinfo','pageId','ext' => 'json'));?>";

        short_url = short_url.replace('pageId',currentPage);
       
        $.getJSON(short_url,function(data){
            

            // Set title
            $('#edit-page-info .modal-header .modal-title').html(mooPhrase.__('edit_page_info'));
            // Set content

            $('#edit-page-info .modal-body').html(data.data);
            $('#edit-page-info').modal('hide');
            $('#edit-component-info').modal('hide');

        }).fail(function(){
            
        });
        var currentDataValue = $('#moo-menu-editing li a[data-value='+currentPage+']');
        $('.editing').html(currentDataValue.text()+' <i class="fa fa-angle-down"></i>');
        $('#nestable_list_2').find('li[data-uri*="'+currentDataValue.data('uri')+'"]').css({'display':'block'});
        currentPageUri = currentDataValue.data('uri');
        if(currentDataValue.data('type') == 'core'){
            $('#moo-delete-page').css({'display':'none'});
        }
        else{$('#moo-delete-page').css({'display':'block'});}
        if(currentPageUri == 'site.header' || currentPageUri == 'site.footer'){
           $('.main-content-area .current').css({display:'block'});
           $('.main-content-area .normal').css({display:'none'});
           if(currentPageUri == 'site.header'){
               $('.block-header .normal').css({display:'none'});
               $('.block-header .current').css({display:'block'});
               $('.block-footer .normal').css({display:'block'});
               $('.block-footer .current').css({display:'none'});
           }
           if(currentPageUri == 'site.footer'){
               $('.block-header .normal').css({display:'block'});
               $('.block-header .current').css({display:'none'});
               $('.block-footer .normal').css({display:'none'});
               $('.block-footer .current').css({display:'block'});
           }
        }else{
            $('.main-content-area .current').css({display:'none'});
            $('.main-content-area .normal').css({display:'block'});
            $('.block-header .normal').css({display:'block'});
            $('.block-header .current').css({display:'none'});
            $('.block-footer .normal').css({display:'block'});
            $('.block-footer .current').css({display:'none'});
        }

    }
    var initPages = function(){
        // Step 1 - detect current page - using currentPage - check it not empty
        if ( currentPage == 0 ){
            
            return;
        }
        // Step 2 - define url and data for initPages
        var short_url = url.admin_getpages;

        $.getJSON(short_url,function(data){
            
            // Step 3

            $('#edit_menu_page .l-btn-text').html($('.menu-item[data-value="'+currentPage+'"] .menu-text').html());

        }).fail(function(){
           
        });
    }
    var initColumns = function(style){
        // reset
        $('#moo-north').removeClass().addClass('col-md-12 mh100 moo-container ui-droppable ui-sortable').show();
        $('#moo-south').removeClass().addClass('col-md-12 mh100 moo-container  ui-droppable ui-sortable').show();
        $('#moo-west').removeClass().addClass('col-md-3 mh300 moo-container  ui-droppable ui-sortable').show();
        $('#moo-center').removeClass().addClass('col-md-6 mh300 moo-container  ui-droppable ui-sortable').show();
        $('#moo-east').removeClass().addClass('col-md-3 mh300 moo-container  ui-droppable ui-sortable').show();
        switch(style){
            case 1:
                $('#moo-north').hide();
                $('#moo-south').hide();
                $('#moo-west').removeClass('mh300').addClass('mh500');
                $('#moo-center').removeClass('mh300').addClass('mh500');
                $('#moo-east').removeClass('mh300').addClass('mh500');
                break;
            case 2:
                $('#moo-north').hide();
                $('#moo-south').hide();
                $('#moo-west').removeClass('mh300').addClass('mh500');
                $('#moo-center').removeClass().addClass('col-md-9 mh500 moo-container ui-droppable ui-sortable');
                $('#moo-east').hide();
                break;
            case 3:
                $('#moo-north').hide();
                $('#moo-south').hide();
                $('#moo-west').hide();
                $('#moo-center').removeClass().addClass('col-md-9 mh500 moo-container ui-droppable ui-sortable');
                $('#moo-east').removeClass('mh300').addClass('mh500');
                break;
            case 4:
                $('#moo-north').hide();
                $('#moo-south').hide();
                $('#moo-west').hide();
                $('#moo-center').removeClass().addClass('col-md-12 mh500 moo-container ui-droppable ui-sortable');
                $('#moo-east').hide();
                break;
            case 5:
                $('#moo-south').hide();
                $('#moo-west').removeClass('mh300').addClass('mh400');
                $('#moo-center').removeClass('mh300').addClass('mh400');
                $('#moo-east').removeClass('mh300').addClass('mh400');
                break;
            case 6:
                $('#moo-south').hide();
                $('#moo-west').removeClass('mh300').addClass('mh400');
                $('#moo-center').removeClass().addClass('col-md-9 mh400 moo-container ui-droppable ui-sortable');
                $('#moo-east').hide();
                break;
            case 7:
                $('#moo-south').hide();
                $('#moo-west').hide();
                $('#moo-center').removeClass().addClass('col-md-9 mh400 moo-container ui-droppable ui-sortable');
                $('#moo-east').removeClass('mh300').addClass('mh400');
                break;
            case 8:
                $('#moo-south').hide();
                $('#moo-west').hide();
                $('#moo-center').removeClass().addClass('col-md-12 mh400 moo-container ui-droppable ui-sortable');
                $('#moo-east').hide();
                break;
            case 9:
                $('#moo-north').hide();
                $('#moo-west').removeClass('mh300').addClass('mh400');
                $('#moo-center').removeClass('mh300').addClass('mh400');
                $('#moo-east').removeClass('mh300').addClass('mh400');
                break;
            case 10:
                $('#moo-north').hide();
                $('#moo-west').removeClass('mh300').addClass('mh400');
                $('#moo-center').removeClass().addClass('col-md-9 mh400 moo-container ui-droppable ui-sortable');
                $('#moo-east').hide();
                break;
            case 11:
                $('#moo-north').hide();
                $('#moo-west').hide();
                $('#moo-center').removeClass().addClass('col-md-9 mh400 moo-container ui-droppable ui-sortable');
                $('#moo-east').removeClass('mh300').addClass('mh400');
                break;
            case 12:
                $('#moo-north').hide();
                $('#moo-west').hide();
                $('#moo-center').removeClass().addClass('col-md-12 mh400 moo-container ui-droppable ui-sortable');
                $('#moo-east').hide();
                break;

        }
    }
    var getPageContent = function(){
        if(currentPage == '68' || currentPage == '69'){
            $("#moo-edit-page-info").css({'visibility':'hidden'});
            $("#moo-edit-columns").css({'visibility':'hidden'});
        }else{
            $("#moo-edit-page-info").css({'visibility':'visible'})
            $("#moo-edit-columns").css({'visibility':'visible'});
        }
        if ( currentPage == 0 ){
            
            return;
        }
        $("#moo-north ol").html('');
        $("#moo-west ol").html('');
        $("#moo-east ol").html('');
        $("#moo-center ol").html('');
        $("#moo-south ol").html('');
        $("#moo-footer ol").html('');

        // Step 2 - define url and data for initPages
        var short_url = url.admin_getContents_pageId;
        short_url = short_url.replace('pageId',currentPage);
       
        $.getJSON(short_url,function(data){

            if(data.data.data != ''){
                // Step 3
                var number_content = data.data.data.length;

                var region = {north:'north',west:'west',east:'east',south:'south'};

                var location = {0:'top',1:'left',2:'right',3:'bottom'};
                var aLength = Object.keys(region).length;

                for(var i = 0; i<number_content;i++){
                    
                    if(data.data.data[i].CoreContent.type == 'container'){

                            for(var k = 0; k<data.data.data[i].children.length;k++){

                                var el = '<li class="dd-item ui-draggable"></li>';
                                var current = null;
                                switch (data.data.data[i].CoreContent.name){
                                    case 'north':
                                        current = $("#moo-north ol:first").append(el).children(':last');//<a href="#"><span class="icon16 icomoon-icon-move"></span>Activity Feed</a>
                                        
                                        break;
                                    case 'center':
                                        current = $("#moo-center ol:first").append(el).children(':last');
                                        break;
                                    case 'west':
                                        current = $("#moo-west ol:first").append(el).children(':last');
                                        break;
                                    case 'east':
                                        current = $("#moo-east ol:first").append(el).children(':last');
                                        break;
                                    case 'south':
                                        current = $("#moo-south ol:first").append(el).children(':last');
                                        break;
                                    case 'header':
                                        current = $("#moo-header ol:first").append(el).children(':last');
                                        break;
                                    case 'footer':
                                            current = $("#moo-footer ol:first").append(el).children(':last');
                                        break;

                                }

                                if(typeof(data.data.data[i].children[k]) !== 'undefined'){
                                    if(current !== null){

                                        current.attr('data-id',data.data.data[i].children[k].CoreContent.id);

                                        var data_params = '';
                                        var params = JSON.parse(data.data.data[i].children[k].CoreContent.params);
                                        console.log(params);
                                        for(var l = 0; l<data.data.data[i].children[k].nameTranslation.length;l++)
                                        {
                                            if(data.data.data[i].children[k].nameTranslation[l].locale == current_lang)
                                                var nameTranslate = data.data.data[i].children[k].nameTranslation[l];
                                        }
                                        var count = 0;
                                        if(params !== null ){
                                            $.each(params,function(key,value){
                                                //translate the title of widget
                                                if(key == 'title' && (nameTranslate.content != ''))
                                                    value = nameTranslate.content;

                                                data_params += ' data-input'+count+'-value="'+value+'" data-input'+count+'-name="'+key+'"';
                                                count++;
                                            });
                                            current.attr('data-display-name',data.data.data[i].children[k].CoreContent.name/*params.title*/);
                                        }
                                        var title;
                                        if(nameTranslate.content != '')
                                            title = nameTranslate.content;
                                        else
                                            title = params.title;
                                        if(params.tabs_container == 1)
                                        {
                                            current.append('<div class="dd-handle" style="height:auto">' +
                                                '   <div class="tabs-title">' +
                                                '       <span>'+title+'</span>  <i class="fa fa-times pull-right delete-element" style="cursor:pointer; margin-top:3px"></i> <a href="javascript:void(0)" class="edit-block pull-right" data-block-id="'+data.data.data[i].children[k].CoreContent.core_block_id+'" '+data_params+'><i class="fa fa-pencil"></i></a> </div>' +
                                                '   <div id="moo-'+data.data.data[i].CoreContent.name+'-tabs-container-'+data.data.data[i].children[k].CoreContent.id+'" class="tabs-container ui-state-default" style=" border: 1px solid #ffaa00">' +
                                                '       <ol class="dd-list" style="min-height:50px;"></ol>' +
                                                '   </div>' +
                                                '</div>');
                                            initDragDrop('#moo-'+data.data.data[i].CoreContent.name+' .tabs-container','#moo-'+data.data.data[i].CoreContent.name);
                                        }
                                        else
                                        {
                                            if(params.maincontent != '1'){
                                                var dd = current.append('<div class="dd-handle" style="background-color: #CDECFF"><span>'+title+'</span>  <i class="fa fa-times pull-right delete-element" style="cursor:pointer; margin-top:3px"></i> <a href="javascript:void(0)" class="edit-block pull-right" data-block-id="'+data.data.data[i].children[k].CoreContent.core_block_id+'" '+data_params+'><i class="fa fa-pencil"></i></a> </div>');
                                            }else{
                                                var dd = current.append('<div class="dd-handle content_fixed" style="background-color: #C4C4C4"><span>'+title+'</span> <a href="javascript:void(0)" class="edit-block" data-block-id="'+data.data.data[i].children[k].CoreContent.core_block_id+'" '+data_params+'></a> </div>');
                                            }
                                        }
                                        //check if element is tabs widget, if true add children
                                        if(data.data.data[i].children[k].children.length >0)
                                        {
                                            var tabs_children = data.data.data[i].children[k].children;
                                            $.each(tabs_children,function(index,tabs_content){
                                                var tabs_current = current.find('ol:first').append(el).children(':last');
                                                if(typeof(tabs_content) !== 'undefined'){
                                                    if(tabs_current !== null){
                                                        tabs_current.attr('data-id',tabs_content.CoreContent.id);

                                                        var tabs_data_params = '';
                                                        var tabs_params = JSON.parse(tabs_content.CoreContent.params);
                                                        var count = 0;
                                                        if(tabs_params !== null ){
                                                            $.each(tabs_params,function(key,value){
                                                                tabs_data_params += ' data-input'+count+'-value="'+value+'" data-input'+count+'-name="'+key+'"';
                                                                count++;
                                                            });
                                                            tabs_current.attr('data-display-name',tabs_content.CoreContent.name);
                                                        }
                                                        if(tabs_params.maincontent != '1'){
                                                            tabs_current.append('<div class="dd-handle" style="background-color: #CDECFF"><span>'+tabs_params.title+'</span>  <i class="fa fa-times pull-right delete-element" style="cursor:pointer; margin-top:3px"></i> <a href="javascript:void(0)" class="edit-block pull-right" data-block-id="'+tabs_content.CoreContent.core_block_id+'" '+tabs_data_params+'><i class="fa fa-pencil"></i></a> </div>');
                                                        }else{
                                                            tabs_current.append('<div class="dd-handle content_fixed" style="background-color: #C4C4C4"><span>'+tabs_params.title+'</span> <a href="javascript:void(0)" class="edit-block" data-block-id="'+tabs_content.CoreContent.core_block_id+'" '+tabs_data_params+'></a> </div>');
                                                        }
                                                    }
                                                }
                                            });
                                        }
                                    }
                                }
                            }

                    }
                }
            }

        }).fail(function(){
            
        });
    }
    var doResetColumn = function(){
        doEditColumn(1);
    }
    var doEditColumn=function(reset){
        var id;
        if(reset == 1){
            id = 0
            column_layout = id;
        }else{
            $($('#portlet-config2  .modal-body')[0]).find('.choosen').each(function(){
                id = $(this).data('id');
                column_layout = id;
            });
        }
        
        initColumns(id);
        $('#portlet-config2').modal('hide');
    }

    var getRegionInfo = function(container){
        var region = {};
        $.each(container,function(key,value){
            var param = {};
            var num_data = Object.keys($(value).find('a.edit-block').data()).length;
            var y = 0;
            for(var i = 0;i<(num_data-1);i+=2){

                param[$(value).find('a.edit-block').attr('data-input'+y+'-name')]= $(value).find('a.edit-block').attr('data-input'+y+'-value');
                y++;
            }
            var main_param = JSON.stringify(param);

            var aa = {name:$(value).attr('data-display-name').trim(),id:$(value).data('id'),param:main_param,core_block_id:$(value).find('a.edit-block').attr('data-block-id')};
            region[key] = aa

            if($(value).attr('data-display-name') == 'tabsWidget')
            {
                var tabsEl = $(value).find('ol:first').find('li');
                if(Object.keys(tabsEl).length > 0)
                {
                    
                    region[key]['tabs_content'] = {};
                    $.each(tabsEl,function(index,data){
                        var tabs_param = {};
                        var tabs_num_data = Object.keys($(data).find('a.edit-block').data()).length;
                        var j = 0;
                        for(var i = 0;i<(tabs_num_data-1);i+=2){

                            tabs_param[$(data).find('a.edit-block').attr('data-input'+j+'-name')]= $(data).find('a.edit-block').attr('data-input'+j+'-value');
                            j++;
                        }
                        var tabs_main_param = JSON.stringify(tabs_param);

                        var tabs_data = {name:$(data).attr('data-display-name').trim(),id:$(data).data('id'),param:tabs_main_param,core_block_id:$(data).find('a.edit-block').attr('data-block-id')};
                        region[key]['tabs_content'][index] = tabs_data;
                    });
                }
            }
        });
        return region
    }
    var doSavePageContent = function(){

        $(this).html('<i class="fa fa-spinner"></i> Loading');
        $(this).addClass('disabled');
        var data = {};

        var top_container = $('#moo-north .dd-list:first').children('li');
        var left_container = $('#moo-west .dd-list:first').children('li');
        var middle_container = $('#moo-center .dd-list:first').children('li');
        var right_container = $('#moo-east .dd-list:first').children('li');
        var bottom_container = $('#moo-south .dd-list:first').children('li');
        var header_container = $('#moo-header .dd-list:first').children('li');
        var footer_container = $('#moo-footer .dd-list:first').children('li');


        data['North'] = getRegionInfo(top_container);
        data['West'] = getRegionInfo(left_container);
        data['East'] = getRegionInfo(right_container);
        data['Center'] = getRegionInfo(middle_container);
        data['South'] = getRegionInfo(bottom_container);
        data['Header'] = getRegionInfo(header_container);
        data['Footer'] = getRegionInfo(footer_container);
        
        
        var removeComponent = $('#removeComponent').val();

        var short_url = url.admin_savePage;

        $.ajax({
            type: "POST",
            async: true,
            url: short_url,
            data: {pageId: currentPage,columnStyle:column_layout,removeComponent:removeComponent,data:data},
            dataType: 'json',
            success: function(data) {
                var redirect = url.admin_index_pageCreateId;
                redirect = redirect.replace('pageCreateId',currentPage);
                window.location = redirect;
            }
        });
    }
    var doCreateNewPage = function(){
        // Init Form
        $.post(url.admin_createPage)
        $('#PageAdminIndexForm').form('submit',{
            url: url.admin_createPage,
            onSubmit:function(){
                return $(this).form('validate');
            },
            success:function(data){
                
                data = $.parseJSON(data)
                $('#new_page').window('close');
                var short_url = url.admin_index_pageCreateId;
                short_url = short_url.replace('pageCreateId',data.data.insertId);
                window.location = short_url;

            }
        });

    }
    var doDeletePage = function(){
        var confirm = window.confirm("Are you sure to delete this page ?");
        if(confirm){
            alert('Success');
            if ( currentPage == 0 ){
                
                return;
            }
            // Step 2 - define url and data for initPages
            var short_url = url.admin_deletePage;//"<?php echo $this->Html->url(array('controller' => 'Layout','action' => 'admin_deletePage','pageId','ext' => 'json'));?>";
            short_url = short_url.replace('pageId',currentPage);
            $.getJSON(short_url,function(data){
                
                // Step 3
            }).fail(function(){
                
            });
        }
    }
    var doSavePageInfo = function(){
        var short_url = url.admin_editpageinfo_pageId;
        short_url = short_url.replace('pageId',currentPage);
        $.post(short_url,$('#PageAdminEditpageinfoForm').serialize(),function(data){
            if(data.data.error === null){
                $('#edit-page-info').modal('hide');
                $('#page-edit-error').html('');
                $('#page-edit-error').attr('style',"display:none");
            }
            else{
                $('#page-edit-error').attr('style',"display:block");
                var err = Object.keys(data.data.error)[0];
                $('#page-edit-error').html(data.data.error[err][0]);

            }
        });

    }
    var editPage = function(){
        currentPage = $(this).data('value');
        currentPageUri = $(this).data('uri');
        $('#nestable_list_2').find('li[data-uri]').css({display:'none'});
        $('#nestable_list_2').find('li[data-uri*="'+$(this).data('uri')+'"]').css({'display':'block'});
        $('.editing').html($(this).text().trim()+' <i class="fa fa-angle-down"></i>');
        if($(this).data('type') == 'core'){
            $('#moo-delete-page').css({'display':'none'});
        }else{$('#moo-delete-page').css({'display':'block'});}
        if($(this).data('uri')=='site.header' || $(this).data('uri')=='site.footer'){
            $("#moo-edit-page-info").css({'visibility':'hidden'});
            $("#moo-edit-columns").css({'visibility':'hidden'});
        }else{
            $("#moo-edit-page-info").css({'visibility':'visible'})
            $("#moo-edit-columns").css({'visibility':'visible'});
        }


        getPageContent();
        initPageInfo();
        getPageStyle();
    }
    var createNewPage = function(){
        
    }
    var deletePage = function(){
        var short_url = url.admin_deletePage;
        short_url = short_url.replace('pageId',currentPage);
        mooConfirm('Are you sure you want to delete this page ?',short_url);
        currentPage = landingPage;
    }
    var editColumn = function(){
        $('.block').removeClass('choosen');
        // Set title
        $($('#portlet-config2  .modal-header .modal-title')[0]).html(mooPhrase.__('select_new_column'));
        // Set content
        var columns = $('#moo-format-columns').html();

        $($('#portlet-config2  .modal-body')[0]).html(columns);
        if($('#portlet-config2  .modal-footer .reset-column-style').length==0){
            $($('#portlet-config2  .modal-footer')[0]).append('<button type="button" class="btn btn-info reset-column-style">'+mooPhrase.__('reset_default')+'</button>');
        }
        $($('#portlet-config2  .modal-body')[0]).find('.block').each(function(){
            if($(this).data('id') == column_layout){
                if(!$(this).hasClass('choosen')){
                    $(this).addClass('choosen');
                }
            }
            $(this).hover(
                function(){$(this).addClass('hover')},
                function(){$(this).removeClass('hover')}
            );
            $(this).click(
                function(){
                    $('.block').removeClass('choosen');
                    $($('#portlet-config2  .modal-body')[0]).find('.block').each(function(){
                        $(this).removeClass('choosen');
                    });
                    $(this).addClass('choosen');
                }
            );
        });

        // OK callback
        $('#portlet-config2  .modal-footer .ok').click(doEditColumn);
        $('#portlet-config2  .modal-footer .reset-column-style').click(doResetColumn);
        $('#portlet-config2').modal('show');
    }
    var editPageInfo = function(){
        
        $('#edit-page-info').modal('show');

    }
    var initEvents=function(){
        // Editing button
        $('#moo-menu-editing li a').click(editPage);
        // Create new page button
        $('#moo-create-new-page').click(createNewPage);
        // Delete page button
        $('#moo-delete-page').click(deletePage);
        // Edit page info button
        $('#moo-edit-page-info').click(editPageInfo);
        // Edit colunms button
        $('#moo-edit-columns').click(editColumn);
        //Save edit page info
        $('#save_edit_page_info').click(doSavePageInfo);
        //Save change
        $('#moo-save-change').click(doSavePageContent);
        //Save drop component info
        $('#save_edit_component_info').click(function(){
            doSaveComponentInfo();
            $('#edit-component-info').modal('hide');
        });
        //Translate clicked
        $('body').on('click','.tips a',function(){
            translate = $(this).parents('.form-group').find('input');
        })
    }

    var addElements = function()
    {
        $.post(url.admin_add_elements,null,function(data){
            if(data)
            {
                
                $('#custom-elements .modal-content').html(JSON.parse(data.data));
                $('#custom-elements').modal('show');
            }
        });
    }

    var initBlocks = function(){
        
    }
    var showEditContent = function(blockId,node_ol,this_ob){
        var short_url = url.admin_getContentInfo_contentId_blockId;
        if(typeof(this_ob) !== 'undefined')
            short_url = short_url.replace('contentId',this_ob.parents('li').data('id'));
        else
            short_url = short_url.replace('contentId',0);
        if(typeof(blockId) !== 'undefined' && blockId !== null){
            short_url = short_url.replace('blockId',blockId);
        }else{
            short_url = short_url.replace('blockId',avaiableBlocks);
        }
        
        if(typeof(node_ol) !== 'undefined'){
            container = $(node_ol).parent('div').attr('id');
        }
        $.getJSON(short_url,function(data){
            
            $('#edit-component-info .modal-header .modal-title').html(data.headerTitle);
            $('#edit-component-info .modal-body').html(data.data);

            if(typeof(this_ob)!=='undefined'){
                block_editing = this_ob;
                var param = {};
                var num_data = Object.keys(this_ob.data()).length;
                
                var y = 0;
                var elements = $('#CoreContentAdminGetcontentinfoForm').find('.form-group');
                
                for(var i = 0;i<(num_data-1);i+=2){
                    var input = $(elements[y]).find('input');
                    //checkbox or radio button
                    if(input.length > 1){

                        $(input).attr('checked',false);
                        var bb = $(this_ob).attr('data-input'+y+'-value').split(",");
                        for(var k=0;k<input.length;k++){
                            if(bb.indexOf($(input[k]).attr('value')) != -1){
                                $(input[k]).attr('checked','checked');
                            }
                        }
                    }else if(input.length == 1){ //normal text input

                        input.attr('value',$(this_ob).attr('data-input'+y+'-value'));
                        input.attr('name',$(this_ob).attr('data-input'+y+'-name'));
                    }else if($(elements[y]).find('select').length >0){// select box
                        var select = $(elements[y]).find('select');
                        select.attr('value',$(this_ob).attr('data-input'+y+'-value'));
                        select.attr('name',$(this_ob).attr('data-input'+y+'-name'));
                    }else if($(elements[y]).find('textarea').length >0){//text area

                        var textarea = $(elements[y]).find('textarea');
                        textarea.attr('value',$(this_ob).attr('data-input'+y+'-value'));
                        textarea.attr('name',$(this_ob).attr('data-input'+y+'-name'));
                    }
                    y++;
                }
            }
            logicCheckRoleAccess();
            $('.block_popup').find('input[type="checkbox"]').change(function(){
                logicCheckRoleAccess();
            });

            $('#edit-component-info').modal('show');
        }).fail(function(data){
            
        });

        $('#edit-component-info').on('hidden.bs.modal', function (e) {
            // do something...
            //doSaveComponentInfo();
        })

    }

    var logicCheckRoleAccess = function()
    {
        if ($('#CoreContentRolesAll').is(':checked'))
        {
            $('.block_popup').find('input[type="checkbox"]').parent().hide();
            $('.block_popup').find('input[type="checkbox"]').not('#CoreContentRolesAll').attr('checked', false);
        }
        else
        {
            $('.block_popup').find('input[type="checkbox"]').parent().show();
        }

        $('#CoreContentRolesAll').parent().show();
    }

    var deleteComponent = function(){
        $('#block-placement').on('click','.delete-element',function(){

            if(window.confirm('Are you sure ?')){
                var componentId = $(this).parents('.dd-item:first').data('id');
                var currentRemoveComponent = $('#removeComponent').val();
                
                var newRemoveComponent = currentRemoveComponent + ',' + componentId;
                $('#removeComponent').val(newRemoveComponent);
                
                var short_url = url.admin_deleteComponent;
                short_url = short_url.replace('componentId',componentId);

                $(this).parents('.dd-item:first').remove()
            }
        });
    }

    var getPageStyle  = function(){
        var short_url = url.admin_getPageStyle;
        short_url =short_url.replace('pageId',currentPage);
        $.post(short_url,function(data){
            column_layout = parseInt(data);
            initColumns(parseInt(data));
        });
    }
    var editBlock = function(){
        $('#block-placement').on('click','.edit-block',function(){
            showEditContent($(this).data('block-id'),null,$(this));
        })
    }
    var doSaveComponentInfo = function(){
        var elements = $('#CoreContentAdminGetcontentinfoForm').find('.form-group');
        $.each(elements,function(key,value){
            var input = $(value).find('input');

            

            if(input.length > 1){ //checkbox or radio buttons
                var input_value = [];
                var input_name = '';
                for(var i =0;i<input.length;i++){
                    if($(input[i]).attr('type') !='hidden'){
                        if($(input[i]).attr('checked')=='checked' || $(input[i]).attr('selected')=='selected'){
                            input_value.push($(input[i]).attr('value'));
                        }
                    }
                }
                input_name = $(input[1]).attr('name').substring(0,$(input[1]).attr('name').length-2);
            }else if(input.length == 1){ // normal text input
                var input_value = input.attr('value');
                var input_name = input.attr('name');
            }else{
                if($(value).find('select').length >0){ // select box
                    var select = $(value).find('select');
                    var input_value = select.attr('value');
                    var input_name = select.attr('name');
                }else if($(value).find('textarea').length >0){ // text area

                    var textarea = $(value).find('textarea');
                    var input_value = textarea.attr('value');
                    var input_name = textarea.attr('name');
                }
            }
            if(typeof(container)!=='undefined'){
                var a = droppedWidget.find('a');

                droppedWidget.attr('data-display-name',$('#CoreContentPathview').attr('value'));

                a.attr('data-input'+key+'-value',input_value);
                a.attr('data-input'+key+'-name',input_name);
            }else{
               
                block_editing.parents('li:first').attr('data-display-name',$('#CoreContentPathview').attr('value'));

                block_editing.attr('data-input'+key+'-value',input_value);
                block_editing.attr('data-input'+key+'-name',input_name);

            }
        });
        if(typeof(container)!=='undefined'){
            $('#'+container).find('li:last span').html($('#'+container).find('li:last a').attr('data-input0-value'));
        }else{
            block_editing.siblings('span').text(block_editing.attr('data-input0-value'));

        }
        $('#edit-component-info').modal('hide');
    }
    var setComponentInfo = function(blockId){
        
    }

    //add a image element to carousel widget
    var addImgEl = function (params){
        
        var short_url = url.admin_custom_info_modal_pageId;
        short_url = short_url.replace('custom','img');
        short_url = short_url.replace('pageId',currentPage);

        var li = currentCustomEl.parents('li:first').find('ol:first').append('<li class="dd-item ui-draggable"></li>').children(':last');
        li.append('<div class="dd-handle" style="background-color: #CDECFF">' +
        '   <div class="carousel-title">' +
        '       <span>'+params.file_name+'</span> ' +
        '       <i class="fa fa-times pull-right delete-element" style="cursor:pointer; margin-top:3px;"></i> ' +
        '       <a href="'+short_url+'" data-target="#custom-elements-info" data-toggle="modal" class="edit-custom-el pull-right" data-block-id="0"><i class="fa fa-pencil"></i></a>' +
        '   </div>' +
        '</div>');
        var editBlock =  li.find('a.edit-custom-el:last');

        var startingInput = 0;
        editBlock.attr('data-input'+startingInput+'-value',params.img_url);
        editBlock.attr('data-input'+startingInput+'-name',params.file_name);
        editBlock.attr('data-input'+(startingInput+1)+'-value',params.description);
        editBlock.attr('data-input'+(startingInput+1)+'-name','description');
        editBlock.attr('data-input'+(startingInput+2)+'-value',params.width+'x'+params.height);
        editBlock.attr('data-input'+(startingInput+2)+'-name','dimension');

    }
    return{
        init:function(){
            initEvents();
            initDragDrop();
            getPageContent();
            initPageInfo();
            deleteComponent();
            getPageStyle();
            editBlock();
            handleFilter();
        },

        initUniform: function (els) {
            if (els) {
                $(els).each(function () {
                    if ($(this).parents(".checker").size() == 0) {
                        $(this).show();
                        $(this).uniform();
                    }
                });
            } else {
                handleUniform();
            }
        },

        //wrMetronicer function to update/sync jquery uniform checkbox & radios
        updateUniform: function (els) {
            $.uniform.update(els); // update the uniform checkbox & radios UI after the actual input control state changed
        },

        setCurrentPage:function(a){
            currentPage = a;
        },
        setLandingPage:function(a){
            landingPage = a;
        },
        setPageContent:function(a){
            pageContent = a;
        },
        setAvaiableBlocks:function(a){
            avaiableBlocks = a;
        },
        setAvaiablePages:function(a){
            avaiablePages = a;
        },
        setUrl:function(a){
            url = a;
           
        },
        setPageInfo:function(){},
        currentPage:function(){
            return currentPage;
        },
        pageContent:function(){
            return pageContent;
        },
        avaiablePages:function(){
            return avaiablePages;
        },
        avaiableBlocks:function(){
            return avaiableBlocks;
        },
        register:function(blockId,params,path_view,blockName){
            blocks[blockId]=[params,path_view,blockName];

        },
        getBlocks:function(){
            return blocks;
        },
        addCustomEls: function(typeId,params){
            var type = {
                addImgEl: function(){return addImgEl(params);}
            };
            type['add'+typeId+'El']();
        },
        setCustomElOb:function(a){
            currentCustomEl = a;
        },
        getTranslateInput:function(){
            return translate;
        }
    }
}();

