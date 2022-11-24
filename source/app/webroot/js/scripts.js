/* textarea auto grow */

(function($){ 
	jQuery.fn.extend({  
		elastic: function() {
		
			//	We will create a div clone of the textarea
			//	by copying these attributes from the textarea to the div.
			var mimics = [
				'paddingTop',
				'paddingRight',
				'paddingBottom',
				'paddingLeft',
				'fontSize',
				'lineHeight',
				'fontFamily',
				'width',
				'fontWeight',
				'border-top-width',
				'border-right-width',
				'border-bottom-width',
				'border-left-width',
				'borderTopStyle',
				'borderTopColor',
				'borderRightStyle',
				'borderRightColor',
				'borderBottomStyle',
				'borderBottomColor',
				'borderLeftStyle',
				'borderLeftColor'
				];
			
			return this.each( function() {

				// Elastic only works on textareas
				if ( this.type !== 'textarea' ) {
					return false;
				}
					
			var $textarea	= jQuery(this),
				$twin		= jQuery('<div />').css({
					'position'		: 'absolute',
					'display'		: 'none',
					'word-wrap'		: 'break-word',
					'white-space'	:'pre-wrap'
				}),
				lineHeight	= parseInt($textarea.css('line-height'),10) || parseInt($textarea.css('font-size'),'10'),
				minheight	= parseInt($textarea.css('height'),10) || lineHeight*3,
				maxheight	= parseInt($textarea.css('max-height'),10) || Number.MAX_VALUE,
				goalheight	= 0;
				
				// Opera returns max-height of -1 if not set
				if (maxheight < 0) { maxheight = Number.MAX_VALUE; }
					
				// Append the twin to the DOM
				// We are going to meassure the height of this, not the textarea.
				$twin.appendTo($textarea.parent());
				
				// Copy the essential styles (mimics) from the textarea to the twin
				var i = mimics.length;
				while(i--){
					$twin.css(mimics[i].toString(),$textarea.css(mimics[i].toString()));
				}
				
				// Updates the width of the twin. (solution for textareas with widths in percent)
				function setTwinWidth(){
					var curatedWidth = Math.floor(parseInt($textarea.width(),10));
					if($twin.width() !== curatedWidth){
						$twin.css({'width': curatedWidth + 'px'});
						
						// Update height of textarea
						update(true);
					}
				}
				
				// Sets a given height and overflow state on the textarea
				function setHeightAndOverflow(height, overflow){
				
					var curratedHeight = Math.floor(parseInt(height,10));
					if($textarea.height() !== curratedHeight){
						$textarea.css({'height': curratedHeight + 'px','overflow':overflow});
					}
				}
				
				// This function will update the height of the textarea if necessary 
				function update(forced) {
					
					// Get curated content from the textarea.
					var textareaContent = $textarea.val().replace(/&/g,'&amp;').replace(/ {2}/g, '&nbsp;').replace(/<|>/g, '&gt;').replace(/\n/g, '<br />');
					
					// Compare curated content with curated twin.
					var twinContent = $twin.html().replace(/<br>/ig,'<br />');
					
					if(forced || textareaContent+'&nbsp;' !== twinContent){
					
						// Add an extra white space so new rows are added when you are at the end of a row.
						$twin.html(textareaContent+'&nbsp;');
						
						// Change textarea height if twin plus the height of one line differs more than 3 pixel from textarea height
						if(Math.abs($twin.height() + lineHeight - $textarea.height()) > 3){
							
							var goalheight = $twin.height()+lineHeight;
							if(goalheight >= maxheight) {
								setHeightAndOverflow(maxheight,'auto');
							} else if(goalheight <= minheight) {
								setHeightAndOverflow(minheight,'hidden');
							} else {
								setHeightAndOverflow(goalheight,'hidden');
							}
							
						}
						
					}
					
				}
				
				// Hide scrollbars
				$textarea.css({'overflow':'hidden'});
				
				// Update textarea size on keyup, change, cut and paste
				$textarea.bind('keyup change cut paste', function(){
					update(); 
				});
				
				// Update width of twin if browser or textarea is resized (solution for textareas with widths in percent)
				$(window).bind('resize', setTwinWidth);
				$textarea.bind('resize', setTwinWidth);
				$textarea.bind('update', update);
				
				// Compact textarea on blur
				/*$textarea.bind('blur',function(){
					if($twin.height() < maxheight){
						if($twin.height() > minheight) {
							$textarea.height($twin.height());
						} else {
							$textarea.height(minheight);
						}
					}
				});*/
				
				// And this line is to catch the browser paste event
				$textarea.bind('input paste',function(e){ setTimeout( update, 250); });				
				
				// Run update once when elastic is initialized
				update();
				
			});
			
        } 
    }); 
})(jQuery);

/* tipsy */

(function($) {
    $.fn.tipsy = function(options) {

        options = $.extend({}, $.fn.tipsy.defaults, options);
        
        return this.each(function() {
            
            var opts = $.fn.tipsy.elementOptions(this, options);
            
            $(this).hover(function() {

                $.data(this, 'cancel.tipsy', true);

                var tip = $.data(this, 'active.tipsy');
                if (!tip) {
                    tip = $('<div class="tipsy"><div class="tipsy-inner"/></div>');
                    tip.css({position: 'absolute', zIndex: 100000});
                    $.data(this, 'active.tipsy', tip);
                }

                if ($(this).attr('title') || typeof($(this).attr('original-title')) != 'string') {
                    $(this).attr('original-title', $(this).attr('title') || '').removeAttr('title');
                }

                var title;
                if (typeof opts.title == 'string') {
                    title = $(this).attr(opts.title == 'title' ? 'original-title' : opts.title);
                } else if (typeof opts.title == 'function') {
                    title = opts.title.call(this);
                }

                tip.find('.tipsy-inner')[opts.html ? 'html' : 'text'](title || opts.fallback);

                var pos = $.extend({}, $(this).offset(), {width: this.offsetWidth, height: this.offsetHeight});
                tip.get(0).className = 'tipsy'; // reset classname in case of dynamic gravity
                tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).appendTo(document.body);
                var actualWidth = tip[0].offsetWidth, actualHeight = tip[0].offsetHeight;
                var gravity = (typeof opts.gravity == 'function') ? opts.gravity.call(this) : opts.gravity;

                switch (gravity.charAt(0)) {
                    case 'n':
                        tip.css({top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-north');
                        break;
                    case 's':
                        tip.css({top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-south');
                        break;
                    case 'e':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}).addClass('tipsy-east');
                        break;
                    case 'w':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}).addClass('tipsy-west');
                        break;
                }

                if (opts.fade) {
                    tip.css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: 0.8});
                } else {
                    tip.css({visibility: 'visible'});
                }

            }, function() {
                $.data(this, 'cancel.tipsy', false);
                var self = this;
                setTimeout(function() {
                    if ($.data(this, 'cancel.tipsy')) return;
                    var tip = $.data(self, 'active.tipsy');
                    if (opts.fade) {
                        tip.stop().fadeOut(function() { $(this).remove(); });
                    } else {
                        tip.remove();
                    }
                }, 100);

            });
            
        });
        
    };
    
    // Overwrite this method to provide options on a per-element basis.
    // For example, you could store the gravity in a 'tipsy-gravity' attribute:
    // return $.extend({}, options, {gravity: $(ele).attr('tipsy-gravity') || 'n' });
    // (remember - do not modify 'options' in place!)
    $.fn.tipsy.elementOptions = function(ele, options) {
        return $.metadata ? $.extend({}, options, $(ele).metadata()) : options;
    };
    
    $.fn.tipsy.defaults = {
        fade: false,
        fallback: '',
        gravity: 'n',
        html: false,
        title: 'title'
    };
    
    $.fn.tipsy.autoNS = function() {
        return $(this).offset().top > ($(document).scrollTop() + $(window).height() / 2) ? 's' : 'n';
    };
    
    $.fn.tipsy.autoWE = function() {
        return $(this).offset().left > ($(document).scrollLeft() + $(window).width() / 2) ? 'e' : 'w';
    };
    
})(jQuery);

/*!
  Tinycon - A small library for manipulating the Favicon
  Tom Moor, http://tommoor.com
  Copyright (c) 2012 Tom Moor
  MIT Licensed
  @version 0.6
*/
(function(){var e={};var t=null;var n=null;var r=document.title;var i=null;var s=null;var o={};var u=window.devicePixelRatio||1;var a=16*u;var f={width:7,height:9,font:10*u+"px arial",colour:"#ffffff",background:"#F03D25",fallback:true,abbreviate:true};var l=function(){var e=navigator.userAgent.toLowerCase();return function(t){return e.indexOf(t)!==-1}}();var c={ie:l("msie"),chrome:l("chrome"),webkit:l("chrome")||l("safari"),safari:l("safari")&&!l("chrome"),mozilla:l("mozilla")&&!l("chrome")&&!l("safari")};var h=function(){var e=document.getElementsByTagName("link");for(var t=0,n=e.length;t<n;t++){if((e[t].getAttribute("rel")||"").match(/\bicon\b/)){return e[t]}}return false};var p=function(){var e=document.getElementsByTagName("link");var t=document.getElementsByTagName("head")[0];for(var n=0,r=e.length;n<r;n++){var i=typeof e[n]!=="undefined";if(i&&(e[n].getAttribute("rel")||"").match(/\bicon\b/)){t.removeChild(e[n])}}};var d=function(){if(!n||!t){var e=h();n=t=e?e.getAttribute("href"):"/favicon.ico"}return t};var v=function(){if(!s){s=document.createElement("canvas");s.width=a;s.height=a}return s};var m=function(e){p();var t=document.createElement("link");t.type="image/x-icon";t.rel="icon";t.href=e;document.getElementsByTagName("head")[0].appendChild(t)};var g=function(e){if(window.console)window.console.log(e)};var y=function(e,t){if(!v().getContext||c.ie||c.safari||o.fallback==="force"){return b(e)}var n=v().getContext("2d");var t=t||"#000000";var r=d();i=document.createElement("img");i.onload=function(){n.clearRect(0,0,a,a);n.drawImage(i,0,0,16,16,0,0,a,a);if(!c.mozilla)n.drawImage(i,0,0,32,32,0,0,a,a);if((e+"").length>0)w(n,e,t);E()};if(!r.match(/^data/)){i.crossOrigin="anonymous"}i.src=r};var b=function(e){if(o.fallback){if((e+"").length>0){document.title="("+e+") "+r}else{document.title=r}}};var w=function(e,t,n){if(typeof t=="number"&&t>99&&o.abbreviate){t=S(t)}var r=(t+"").length-1;var i=o.width*u+6*u*r,s=o.height*u;var f=a-s,l=a-i-u,h=16*u,p=16*u,d=2*u;e.font=(c.webkit?"bold ":"")+o.font;e.fillStyle=o.background;e.strokeStyle=o.background;e.lineWidth=u;e.beginPath();e.moveTo(l+d,f);e.quadraticCurveTo(l,f,l,f+d);e.lineTo(l,h-d);e.quadraticCurveTo(l,h,l+d,h);e.lineTo(p-d,h);e.quadraticCurveTo(p,h,p,h-d);e.lineTo(p,f+d);e.quadraticCurveTo(p,f,p-d,f);e.closePath();e.fill();e.beginPath();e.strokeStyle="rgba(0,0,0,0.3)";e.moveTo(l+d/2,h);e.lineTo(p-d/2,h);e.stroke();e.fillStyle=o.colour;e.textAlign="right";e.textBaseline="top";e.fillText(t,u===2?29:15,c.mozilla?7*u:6*u)};var E=function(){if(!v().getContext)return;m(v().toDataURL())};var S=function(e){var t=[["G",1e9],["M",1e6],["k",1e3]];for(var n=0;n<t.length;++n){if(e>=t[n][1]){e=x(e/t[n][1])+t[n][0];break}}return e};var x=function(e,t){var n=new Number(e);return n.toFixed(t)};e.setOptions=function(e){o={};for(var t in f){o[t]=e.hasOwnProperty(t)?e[t]:f[t]}return this};e.setImage=function(e){t=e;E();return this};e.setBubble=function(e,t){e=e||"";y(e,t);return this};e.reset=function(){m(n)};e.setOptions(f);window.Tinycon=e})()

/*
// jQuery multiSelect
// Version 1.2.2 beta
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/) 
*/
if(jQuery){(function($){function renderOption(id,option){var html='<label><input type="checkbox" name="data['+id+'][]" value="'+option.value+'"';if(option.selected){html+=' checked="checked"'}html+=" />"+option.text+"</label>";return html}function renderOptions(id,options,o){var html="";for(var i=0;i<options.length;i++){if(options[i].optgroup){html+='<label class="optGroup">';if(o.optGroupSelectable){html+='<input type="checkbox" class="optGroup" />'+options[i].optgroup}else{html+=options[i].optgroup}html+='</label><div class="optGroupContainer">';html+=renderOptions(id,options[i].options,o);html+="</div>"}else{html+=renderOption(id,options[i])}}return html}function buildOptions(options){var multiSelect=$(this);var multiSelectOptions=multiSelect.next(".multiSelectOptions");var o=multiSelect.data("config");var callback=multiSelect.data("callback");multiSelectOptions.html("");var html="";if(o.selectAll){html+='<label class="selectAll"><input type="checkbox" class="selectAll" />'+o.selectAllText+"</label>"}html+=renderOptions(multiSelect.attr("id"),options,o);multiSelectOptions.html(html);var initialWidth=multiSelectOptions.width();var hasScrollbar=false;if(multiSelectOptions.height()>o.listHeight){multiSelectOptions.css("height",o.listHeight+"px");hasScrollbar=true}else{multiSelectOptions.css("height","")}var scrollbarWidth=hasScrollbar&&(initialWidth==multiSelectOptions.width())?17:0;if((multiSelectOptions.width()+scrollbarWidth)<multiSelect.outerWidth()){multiSelectOptions.css("width",multiSelect.outerWidth()-2+"px")}else{multiSelectOptions.css("width",(multiSelectOptions.width()+scrollbarWidth)+"px")}if($.fn.bgiframe){multiSelect.next(".multiSelectOptions").bgiframe({width:multiSelectOptions.width(),height:multiSelectOptions.height()})}if(o.selectAll){multiSelectOptions.find("INPUT.selectAll").click(function(){multiSelectOptions.find("INPUT:checkbox").attr("checked",$(this).attr("checked")).parent("LABEL").toggleClass("checked",$(this).attr("checked"))})}if(o.optGroupSelectable){multiSelectOptions.addClass("optGroupHasCheckboxes");multiSelectOptions.find("INPUT.optGroup").click(function(){$(this).parent().next().find("INPUT:checkbox").attr("checked",$(this).attr("checked")).parent("LABEL").toggleClass("checked",$(this).attr("checked"))})}multiSelectOptions.find("INPUT:checkbox").click(function(){$(this).parent("LABEL").toggleClass("checked",$(this).attr("checked"));updateSelected.call(multiSelect);multiSelect.focus();if($(this).parent().parent().hasClass("optGroupContainer")){updateOptGroup.call(multiSelect,$(this).parent().parent().prev())}if(callback){callback($(this))}});multiSelectOptions.each(function(){$(this).find("INPUT:checked").parent().addClass("checked")});updateSelected.call(multiSelect);if(o.optGroupSelectable){multiSelectOptions.find("LABEL.optGroup").each(function(){updateOptGroup.call(multiSelect,$(this))})}multiSelectOptions.find("LABEL:has(INPUT)").hover(function(){$(this).parent().find("LABEL").removeClass("hover");$(this).addClass("hover")},function(){$(this).parent().find("LABEL").removeClass("hover")});multiSelect.keydown(function(e){var multiSelectOptions=$(this).next(".multiSelectOptions");if(multiSelectOptions.css("visibility")!="hidden"){if(e.keyCode==9){$(this).addClass("focus").trigger("click");$(this).focus().next(":input").focus();return true}if(e.keyCode==27||e.keyCode==37||e.keyCode==39){$(this).addClass("focus").trigger("click")}if(e.keyCode==40||e.keyCode==38){var allOptions=multiSelectOptions.find("LABEL");var oldHoverIndex=allOptions.index(allOptions.filter(".hover"));var newHoverIndex=-1;if(oldHoverIndex<0){multiSelectOptions.find("LABEL:first").addClass("hover")}else{if(e.keyCode==40&&oldHoverIndex<allOptions.length-1){newHoverIndex=oldHoverIndex+1}else{if(e.keyCode==38&&oldHoverIndex>0){newHoverIndex=oldHoverIndex-1}}}if(newHoverIndex>=0){$(allOptions.get(oldHoverIndex)).removeClass("hover");$(allOptions.get(newHoverIndex)).addClass("hover");adjustViewPort(multiSelectOptions)}return false}if(e.keyCode==13||e.keyCode==32){var selectedCheckbox=multiSelectOptions.find("LABEL.hover INPUT:checkbox");selectedCheckbox.attr("checked",!selectedCheckbox.attr("checked")).parent("LABEL").toggleClass("checked",selectedCheckbox.attr("checked"));if(selectedCheckbox.hasClass("selectAll")){multiSelectOptions.find("INPUT:checkbox").attr("checked",selectedCheckbox.attr("checked")).parent("LABEL").addClass("checked").toggleClass("checked",selectedCheckbox.attr("checked"))}updateSelected.call(multiSelect);if(callback){callback($(this))}return false}if(e.keyCode>=33&&e.keyCode<=126){var match=multiSelectOptions.find("LABEL:startsWith("+String.fromCharCode(e.keyCode)+")");var currentHoverIndex=match.index(match.filter("LABEL.hover"));var afterHoverMatch=match.filter(function(index){return index>currentHoverIndex});match=(afterHoverMatch.length>=1?afterHoverMatch:match).filter("LABEL:first");if(match.length==1){multiSelectOptions.find("LABEL.hover").removeClass("hover");match.addClass("hover");adjustViewPort(multiSelectOptions)}}}else{if(e.keyCode==38||e.keyCode==40||e.keyCode==13||e.keyCode==32){$(this).removeClass("focus").trigger("click");multiSelectOptions.find("LABEL:first").addClass("hover");return false}if(e.keyCode==9){multiSelectOptions.next(":input").focus();return true}}if(e.keyCode==13){return false}})}function adjustViewPort(multiSelectOptions){var selectionBottom=multiSelectOptions.find("LABEL.hover").position().top+multiSelectOptions.find("LABEL.hover").outerHeight();if(selectionBottom>multiSelectOptions.innerHeight()){multiSelectOptions.scrollTop(multiSelectOptions.scrollTop()+selectionBottom-multiSelectOptions.innerHeight())}if(multiSelectOptions.find("LABEL.hover").position().top<0){multiSelectOptions.scrollTop(multiSelectOptions.scrollTop()+multiSelectOptions.find("LABEL.hover").position().top)}}function updateOptGroup(optGroup){var multiSelect=$(this);var o=multiSelect.data("config");if(o.optGroupSelectable){var optGroupSelected=true;$(optGroup).next().find("INPUT:checkbox").each(function(){if(!$(this).attr("checked")){optGroupSelected=false;return false}});$(optGroup).find("INPUT.optGroup").attr("checked",optGroupSelected).parent("LABEL").toggleClass("checked",optGroupSelected)}}function updateSelected(){var multiSelect=$(this);var multiSelectOptions=multiSelect.next(".multiSelectOptions");var o=multiSelect.data("config");var i=0;var selectAll=true;var display="";multiSelectOptions.find("INPUT:checkbox").not(".selectAll, .optGroup").each(function(){if($(this).parent().hasClass("checked")){i++;display=display+$(this).parent().text()+", "}else{selectAll=false}});display=display.replace(/\s*\,\s*$/,"");if(i==0){multiSelect.find("span").html(o.noneSelected)}else{if(o.oneOrMoreSelected=="*"){multiSelect.find("span").html(display);multiSelect.attr("title",display)}else{multiSelect.find("span").html(o.oneOrMoreSelected.replace("%",i))}}if(o.selectAll){multiSelectOptions.find("INPUT.selectAll").attr("checked",selectAll).parent("LABEL").toggleClass("checked",selectAll)}}$.extend($.fn,{multiSelect:function(o,callback){if(!o){o={}}if(o.selectAll==undefined){o.selectAll=true}if(o.selectAllText==undefined){o.selectAllText="Select All"}if(o.noneSelected==undefined){o.noneSelected="Select options"}if(o.oneOrMoreSelected==undefined){o.oneOrMoreSelected="% selected"}if(o.optGroupSelectable==undefined){o.optGroupSelectable=false}if(o.listHeight==undefined){o.listHeight=150}$(this).each(function(){var select=$(this);var html='<a href="javascript:;" class="multiSelect"><span></span></a>';html+='<div class="multiSelectOptions" style="position: absolute; z-index: 99999; visibility: hidden;"></div>';$(select).after(html);var multiSelect=$(select).next(".multiSelect");var multiSelectOptions=multiSelect.next(".multiSelectOptions");multiSelect.find("span").css("width",$(select).width()+"px");multiSelect.data("config",o);multiSelect.data("callback",callback);var options=[];$(select).children().each(function(){if(this.tagName.toUpperCase()=="OPTGROUP"){var suboptions=[];options.push({optgroup:$(this).attr("label"),options:suboptions});$(this).children("OPTION").each(function(){if($(this).val()!=""){suboptions.push({text:$(this).html(),value:$(this).val(),selected:$(this).attr("selected")})}})}else{if(this.tagName.toUpperCase()=="OPTION"){if($(this).val()!=""){options.push({text:$(this).html(),value:$(this).val(),selected:$(this).attr("selected")})}}}});$(select).remove();multiSelect.attr("id",$(select).attr("id"));buildOptions.call(multiSelect,options);multiSelect.hover(function(){$(this).addClass("hover")},function(){$(this).removeClass("hover")}).click(function(){if($(this).hasClass("active")){$(this).multiSelectOptionsHide()}else{$(this).multiSelectOptionsShow()}return false}).focus(function(){$(this).addClass("focus")}).blur(function(){$(this).removeClass("focus")});$(document).click(function(event){if(!($(event.target).parents().andSelf().is(".multiSelectOptions"))){multiSelect.multiSelectOptionsHide()}})})},multiSelectOptionsUpdate:function(options){buildOptions.call($(this),options)},multiSelectOptionsHide:function(){$(this).removeClass("active").removeClass("hover").next(".multiSelectOptions").css("visibility","hidden")},multiSelectOptionsShow:function(){var multiSelect=$(this);var multiSelectOptions=multiSelect.next(".multiSelectOptions");var o=multiSelect.data("config");$(".multiSelect").multiSelectOptionsHide();multiSelectOptions.find("LABEL").removeClass("hover");multiSelect.addClass("active").next(".multiSelectOptions").css("visibility","visible");multiSelect.focus();multiSelect.next(".multiSelectOptions").scrollTop(0);var offset=multiSelect.position();multiSelect.next(".multiSelectOptions").css({top:offset.top+$(this).outerHeight()+"px"});multiSelect.next(".multiSelectOptions").css({left:offset.left+"px"})},selectedValuesString:function(){var selectedValues="";$(this).next(".multiSelectOptions").find("INPUT:checkbox:checked").not(".optGroup, .selectAll").each(function(){selectedValues+=$(this).attr("value")+","});return selectedValues.replace(/\s*\,\s*$/,"")}});$.expr[":"].startsWith=function(el,i,m){var search=m[3];if(!search){return false}return eval("/^[/s]*"+search+"/i").test($(el).text())}})(jQuery)};

// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly. 
;(function ( $, window, document, undefined ) {
    'use strict';

    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.

    // window and document are passed through as local variable rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = "menuButton";
    var menuClass = ".button-dropdown";
    var defaults = {
        propertyName: "value"
    };

    // The actual plugin constructor
    function Plugin( element, options ) {

        //SET OPTIONS
        this.options = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;

        //REGISTER ELEMENT
        this.$element = $(element);

        //INITIALIZE
        this.init();
    }

    Plugin.prototype = {
        constructor: Plugin,

        init: function() {
            // WE DON'T STOP PROPGATION SO CLICKS WILL AUTOMATICALLY
            // TOGGLE AND REMOVE THE DROPDOWN & OVERLAY
            this.toggle();
        },

        toggle: function(el, options) {
            if(this.$element.data('dropdown') === 'show') {
                this.hideMenu();
            }
            else {
                this.showMenu();
            }
        },

        showMenu: function() {
            this.$element.data('dropdown', 'show');
            this.$element.find('ul').show();

            if(this.$overlay) {
                this.$overlay.show();
            }
            else {
                this.$overlay = $('<div class="button-overlay"></div>');
                this.$element.append(this.$overlay);
            }
        },

        hideMenu: function() {
            this.$element.data('dropdown', 'hide');
            this.$element.find('ul').hide();
            this.$overlay.hide();
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {

            // TOGGLE BUTTON IF IT EXISTS
            if ($.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName).toggle();
            }
            // OTHERWISE CREATE A NEW INSTANCE
            else {
                $.data(this, "plugin_" + pluginName, new Plugin( this, options ));
            }
        });
    };


    //DELEGATE CLICK EVENT FOR DROPDOWN MENUS
    $(document).on('click', '[data-buttons=dropdown]', function(e) {
        var $dropdown = $(e.currentTarget);
        $dropdown.menuButton();
    });

    //IGNORE CLICK EVENTS FROM DISPLAY BUTTON IN DROPDOWN
    $(document).on('click', '[data-buttons=dropdown] > a', function(e) {
        e.preventDefault();
    });

})( jQuery, window, document);

// spin
!function(t,e,i){var o=["webkit","Moz","ms","O"],r={},n;function a(t,i){var o=e.createElement(t||"div"),r;for(r in i)o[r]=i[r];return o}function s(t){for(var e=1,i=arguments.length;e<i;e++)t.appendChild(arguments[e]);return t}var f=function(){var t=a("style",{type:"text/css"});s(e.getElementsByTagName("head")[0],t);return t.sheet||t.styleSheet}();function l(t,e,i,o){var a=["opacity",e,~~(t*100),i,o].join("-"),s=.01+i/o*100,l=Math.max(1-(1-t)/e*(100-s),t),p=n.substring(0,n.indexOf("Animation")).toLowerCase(),u=p&&"-"+p+"-"||"";if(!r[a]){f.insertRule("@"+u+"keyframes "+a+"{"+"0%{opacity:"+l+"}"+s+"%{opacity:"+t+"}"+(s+.01)+"%{opacity:1}"+(s+e)%100+"%{opacity:"+t+"}"+"100%{opacity:"+l+"}"+"}",f.cssRules.length);r[a]=1}return a}function p(t,e){var r=t.style,n,a;if(r[e]!==i)return e;e=e.charAt(0).toUpperCase()+e.slice(1);for(a=0;a<o.length;a++){n=o[a]+e;if(r[n]!==i)return n}}function u(t,e){for(var i in e)t.style[p(t,i)||i]=e[i];return t}function c(t){for(var e=1;e<arguments.length;e++){var o=arguments[e];for(var r in o)if(t[r]===i)t[r]=o[r]}return t}function d(t){var e={x:t.offsetLeft,y:t.offsetTop};while(t=t.offsetParent)e.x+=t.offsetLeft,e.y+=t.offsetTop;return e}var h={lines:12,length:7,width:5,radius:10,rotate:0,corners:1,color:"#000",speed:1,trail:100,opacity:1/4,fps:20,zIndex:2e9,className:"spinner",top:"auto",left:"auto",position:"relative"};function m(t){if(!this.spin)return new m(t);this.opts=c(t||{},m.defaults,h)}m.defaults={};c(m.prototype,{spin:function(t){this.stop();var e=this,i=e.opts,o=e.el=u(a(0,{className:i.className}),{position:i.position,width:0,zIndex:i.zIndex}),r=i.radius+i.length+i.width,s,f;if(t){t.insertBefore(o,t.firstChild||null);f=d(t);s=d(o);u(o,{left:(i.left=="auto"?f.x-s.x+(t.offsetWidth>>1)+'px':parseInt(i.left,10)+r+'%'),top:(i.top=="auto"?f.y-s.y+(t.offsetHeight>>1):parseInt(i.top,10)+r)+"px"})}o.setAttribute("aria-role","progressbar");e.lines(o,e.opts);if(!n){var l=0,p=i.fps,c=p/i.speed,h=(1-i.opacity)/(c*i.trail/100),m=c/i.lines;(function y(){l++;for(var t=i.lines;t;t--){var r=Math.max(1-(l+t*m)%c*h,i.opacity);e.opacity(o,i.lines-t,r,i)}e.timeout=e.el&&setTimeout(y,~~(1e3/p))})()}return e},stop:function(){var t=this.el;if(t){clearTimeout(this.timeout);if(t.parentNode)t.parentNode.removeChild(t);this.el=i}return this},lines:function(t,e){var i=0,o;function r(t,o){return u(a(),{position:"absolute",width:e.length+e.width+"px",height:e.width+"px",background:t,boxShadow:o,transformOrigin:"left",transform:"rotate("+~~(360/e.lines*i+e.rotate)+"deg) translate("+e.radius+"px"+",0)",borderRadius:(e.corners*e.width>>1)+"px"})}for(;i<e.lines;i++){o=u(a(),{position:"absolute",top:1+~(e.width/2)+"px",transform:e.hwaccel?"translate3d(0,0,0)":"",opacity:e.opacity,animation:n&&l(e.opacity,e.trail,i,e.lines)+" "+1/e.speed+"s linear infinite"});if(e.shadow)s(o,u(r("#000","0 0 4px "+"#000"),{top:2+"px"}));s(t,s(o,r(e.color,"0 0 1px rgba(0,0,0,.1)")))}return t},opacity:function(t,e,i){if(e<t.childNodes.length)t.childNodes[e].style.opacity=i}});(function(){function t(t,e){return a("<"+t+' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">',e)}var e=u(a("group"),{behavior:"url(#default#VML)"});if(!p(e,"transform")&&e.adj){f.addRule(".spin-vml","behavior:url(#default#VML)");m.prototype.lines=function(e,i){var o=i.length+i.width,r=2*o;function n(){return u(t("group",{coordsize:r+" "+r,coordorigin:-o+" "+-o}),{width:r,height:r})}var a=-(i.width+i.length)*2+"px",f=u(n(),{position:"absolute",top:a,left:a}),l;function p(e,r,a){s(f,s(u(n(),{rotation:360/i.lines*e+"deg",left:~~r}),s(u(t("roundrect",{arcsize:i.corners}),{width:o,height:i.width,left:i.radius,top:-i.width>>1,filter:a}),t("fill",{color:i.color,opacity:i.opacity}),t("stroke",{opacity:0}))))}if(i.shadow)for(l=1;l<=i.lines;l++)p(l,-2,"progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)");for(l=1;l<=i.lines;l++)p(l);return s(e,f)};m.prototype.opacity=function(t,e,i,o){var r=t.firstChild;o=o.shadow&&o.lines||0;if(r&&e+o<r.childNodes.length){r=r.childNodes[e+o];r=r&&r.firstChild;r=r&&r.firstChild;if(r)r.opacity=i}}}else n=p(e,"animation")})();if(typeof define=="function"&&define.amd)define(function(){return m});else t.Spinner=m}(window,document);

(function(factory) {

  if (typeof exports == 'object') {
    // CommonJS
    factory(require('jquery'), require('spin'))
  }
  else if (typeof define == 'function' && define.amd) {
    // AMD, register as anonymous module
    define(['jquery', 'spin'], factory)
  }
  else {
    // Browser globals
    if (!window.Spinner) throw new Error('Spin.js not present')
    factory(window.jQuery, window.Spinner)
  }

}(function($, Spinner) {

  $.fn.spin = function(opts, color) {

    return this.each(function() {
      var $this = $(this),
        data = $this.data();

      if (data.spinner) {
        data.spinner.stop();
        delete data.spinner;
      }
      if (opts !== false) {
        opts = $.extend(
          { color: color || $this.css('color') },
          $.fn.spin.presets[opts] || opts
        )
        data.spinner = new Spinner(opts).spin(this)
      }
    })
  }

  $.fn.spin.presets = {
    tiny: { lines:11, length:3, width:1, radius:3, left: 88 },
    small: { lines:11, length:5, width:2, radius:5 },
    large: { color:'#fff', lines:11, length:9, width:7, radius:10, shadow: true },
    custom:{ lines:11, length:3, width:1, radius:3, left: 88, top: '-21px' }
  }

}));

/*! http://mths.be/placeholder v2.0.7 by @mathias */
;(function(f,h,$){var a='placeholder' in h.createElement('input'),d='placeholder' in h.createElement('textarea'),i=$.fn,c=$.valHooks,k,j;if(a&&d){j=i.placeholder=function(){return this};j.input=j.textarea=true}else{j=i.placeholder=function(){var l=this;l.filter((a?'textarea':':input')+'[placeholder]').not('.placeholder').bind({'focus.placeholder':b,'blur.placeholder':e}).data('placeholder-enabled',true).trigger('blur.placeholder');return l};j.input=a;j.textarea=d;k={get:function(m){var l=$(m);return l.data('placeholder-enabled')&&l.hasClass('placeholder')?'':m.value},set:function(m,n){var l=$(m);if(!l.data('placeholder-enabled')){return m.value=n}if(n==''){m.value=n;if(m!=h.activeElement){e.call(m)}}else{if(l.hasClass('placeholder')){b.call(m,true,n)||(m.value=n)}else{m.value=n}}return l}};a||(c.input=k);d||(c.textarea=k);$(function(){$(h).delegate('form','submit.placeholder',function(){var l=$('.placeholder',this).each(b);setTimeout(function(){l.each(e)},10)})});$(f).bind('beforeunload.placeholder',function(){$('.placeholder').each(function(){this.value=''})})}function g(m){var l={},n=/^jQuery\d+$/;$.each(m.attributes,function(p,o){if(o.specified&&!n.test(o.name)){l[o.name]=o.value}});return l}function b(m,n){var l=this,o=$(l);if(l.value==o.attr('placeholder')&&o.hasClass('placeholder')){if(o.data('placeholder-password')){o=o.hide().next().show().attr('id',o.removeAttr('id').data('placeholder-id'));if(m===true){return o[0].value=n}o.focus()}else{l.value='';o.removeClass('placeholder');l==h.activeElement&&l.select()}}}function e(){var q,l=this,p=$(l),m=p,o=this.id;if(l.value==''){if(l.type=='password'){if(!p.data('placeholder-textinput')){try{q=p.clone().attr({type:'text'})}catch(n){q=$('<input>').attr($.extend(g(this),{type:'text'}))}q.removeAttr('name').data({'placeholder-password':true,'placeholder-id':o}).bind('focus.placeholder',b);p.data({'placeholder-textinput':q,'placeholder-id':o}).before(q)}p=p.removeAttr('id').hide().prev().attr('id',o).show()}p.addClass('placeholder');p[0].value=p.attr('placeholder')}else{p.removeClass('placeholder')}}}(this,document,jQuery));

// simple modal

(function($) {

    var self = null;

    //Attach this new method to jQuery
    $.fn.extend({
        buttons: null,
        options: null,

        defaults: {
            onAppend:      null,
            offsetTop:     null,
            overlayOpacity:.3,
            overlayColor:  "#000000",
            width:         400,
            draggable:     true,
            keyEsc:        true,
            overlayClick:  false,
            closeButton:   true, // X close button
            hideHeader:    false,
            hideFooter:    true,
            btn_ok:        "Ok", // Label
            btn_cancel:    "Cancel", // Label
            template:"<div class=\"simple-modal-header modal-header\"><div class=\"title-modal\"> \
                {_TITLE_} \
            </div></div> \
                <div class=\"simple-modal-body modal-body\"> \
                <div class=\"contents\" id=\"simple-modal-body\">{_CONTENTS_}</div> \
            </div> \
                <div class=\"simple-modal-footer modal-footer\"></div>"
        },

        SimpleModal: function(options) {        	
            self = this;

            this.buttons = [];
            this.options = $.extend({}, self.defaults, options);

            return this;
        },

        /**
         * public method showModal
         * Open Modal
         * @options: param to rewrite
         * @return node HTML
         */
        showModal: function() {
            var node = null;

            // Inserisce Overlay
            //this._overlay("show");

            // Switch different modal
            switch(this.options.model) {
            case "modal-ajax":
				node = this._drawWindow(this.options);
                this._loadContents({
                    "url": self.options.param.url || "",
                    "onRequestComplete": this.options.param.onRequestComplete
                });
                break;
            case "confirm":
                // Add button confirm
                this.addButton(this.options.btn_ok, "btn btn-primary btn-action", function() {
                    // in oppose to original version, i'm not catching exceptions
                    // i want to know what's eventually goes wrong
                    self.options.callback();
                    self.hideModal();
                });
                // Add button cancel
                this.addButton(this.options.btn_cancel, "btn btn-default");
                node = this._drawWindow(this.options);
                break;
            case "modal":
                this.addButton(this.options.btn_ok, "btn btn-primary btn-action", function() {
                    self.hideModal();
                });
				node = this._drawWindow(this.options);
                break;
            case "content":
            	node = this._drawWindow(this.options);
            	break;
            default:
				// Alert
                this.addButton(this.options.btn_ok, "btn btn-primary");
				node = this._drawWindow(this.options);
                break;
            }           

			if (node) {
              /*  // Custom size Modal
                node.css('width', this.options.width);

                // Hide Header &&/|| Footer
                if (this.options.hideHeader) node.addClass("hide-header");
               if (this.options.hideFooter) node.addClass("hide-footer");

                // Add Button X
                if (this.options.closeButton) this._addCloseButton();
                */

                // Resize Stage
                this._display();
            }
        },

        /**
         * public method hideModal
         * Close model window
         * return
         */
        hideModal: function() {
		    self._overlay('hide');
            // close modal bootstrap
            $('.modal-backdrop').remove();
            $('#simpleModal').remove();
        },

        /**
         * private method _drawWindow
         * Rendering window
         * return node SM
         */
		_drawWindow:function(options) {
			// Add Node in DOM
            var node = $("<div>").addClass('simple-modal modal-dialog').attr('id', 'simple-modal');

			// Set Contents
		    node.html($("<div>").addClass('modal-content').html(this._template(self.options.template, {"_TITLE_":options.title || "Untitled", "_CONTENTS_":options.contents || ""})));
            node = $("<div>").addClass("modal fade in").attr('id', 'simpleModal').attr('aria-hidden', false).attr('aria-labelledby', 'myModalLabel').attr('role', 'basic').css({'display':'block'}).html(node);

            $('body').append(node);
            $('body').append('<div class="modal-backdrop fade in"></div>');
			// Add all buttons
		    this._injectAllButtons();

		    // Callback append
            if (this.options.onAppend) {
		        this.options.onAppend.call(this);
            }
			return node;
		},

        /**
         * public method addButton
         * Add button to Modal button array
         * require @label:string, @classe:string, @clickEvent:event
         * @return node HTML
         */
        addButton: function(label, classe, clickEvent) {
            var bt = $('<a>').attr({
                "title" : label,
                "class" : classe
            }).click(clickEvent ? function(e) { clickEvent.call(self, e); } : self.hideModal).text(label);

            this.buttons.push(bt);
 		    return this;
        },

        /**
         * private method _injectAllButtons
         * Inject all buttons in simple-modal-footer
         * @return
         */
        _injectAllButtons: function() {
            var footer = $("#simple-modal").find(".simple-modal-footer");

           $.each(self.buttons, function(i, e) {
               footer.append(e);
            });
        },

        /**
         * private method _addCloseButton
         * Inject Close botton (X button)
         * @return node HTML
         */
        _addCloseButton: function() {
            var b = $("<a>").addClass('close').attr({"href": "#"}).html('<i class="material-icons">clear</i>').click(function(e) {
                self.hideModal();
                return false;
            });
            $("#simple-modal").append(b);
            return b;
        },

        /**
         * private method _overlay
         * Create/Destroy overlay and Modal
         * @return
         */
        _overlay: function(status) {
            switch(status) {
            case 'show':

                var overlay = $("<div>")
                        .attr("id", "simple-modal-overlay")
                        .css({"background-color": this.options.overlayColor, "opacity": 0});

                /*
                var overlay = $('div')
                    .attr("id", "simple-modal-overlay")
                    .addClass("modal")
                    .css({'display':'block'});*/
                $('body').append(overlay);

                overlay.animate({opacity: this.options.overlayOpacity});

                // Behaviour
                if (this.options.overlayClick) {
                    overlay.click(function(e) { self.hideModal(); });
                }

                // Add Control Resize
                $(window).resize(self._display);
                $(document).keyup(self._escape);
                break;

            case 'hide':
                // Remove Overlay
                $('#simple-modal-overlay').remove();
                $('#simple-modal').remove();

                $(window).unbind('resize', self._display);
                $(document).unbind('keyup', self._escape);                
            }
        },

        _escape: function(e) {
            if (e.keyCode == 27) self.hideModal();
        },

        /**
         * private method _loadContents
         * Async request for modal ajax
         * @return
         */
        _loadContents: function(param) {
			// Set Loading
			$('#simple-modal-body').spin('small');
			// Match image file
			var re = new RegExp( /([^\/\\]+)\.(jpg|png|gif)$/i ), container = $('#simple-modal');
			if (param.url.match(re)) {
				// Hide Header/Footer
	            container.addClass("hide-footer");
				// Remove All Event on Overlay
				$("#simple-modal-overlay").unbind(); // Prevent Abort
				// Immagine
                var image = $('<img>').attr('src', param.url)
                        .load(function() {
							var content = container.find(".contents").empty().append($(this).css('opacity', 0));
                            var dw = container.width() - content.width(), dh = container.height() - content.height();
							var width = $(this).width()+dw, height  = $(this).height()+dh;

                            //self._display();
                            container.animate({
                                width: width,
                                height: height,
                                left: ($(window).width() - width)/2,
                                top: ($(window).height() - height)/2
                            }, 200, function() {
                                image.animate({opacity: 1});
                            });
                        });
			} else {
				//$('.simple-modal-footer').remove();
                $('#simple-modal .contents').load(param.url, function(responseText, textStatus, XMLHttpRequest) {
                    var container = $('#simple-modal');
                    if (textStatus !== 'success') {
	                    container.find(".contents").html("loading failed");

                        if (param.onRequestFailure) {
                            param.onRequestFailure();
                        }
                    }
                    else
                    {
                        if (param.onRequestComplete) {
                            param.onRequestComplete();
                        }
	                    self._display();
                    }
                });
			}
        },

        /**
         * private method _display
         * Move interface
         * @return
         */
        _display: function() {
            // Update overlay
            $("#simple-modal-overlay").css({width: $(window).width(), height: $(window).height()});

            // Update position popup
            var modal = $("#simple-modal"), top = self.options.offsetTop || ($(window).height() - modal.height())/2;
            //modal.css({
            //    top: top,
            //    left: (($(window).width() - modal.width())/2)
            //});
        },

        /**
         * private method _template
         * simple template by Thomas Fuchs
         * @return
         */
        _template:function(s,d) {
            for(var p in d) {
                s=s.replace(new RegExp('{'+p+'}','g'), d[p]);
            }
            return s;
        }
    });

})(jQuery);

/*! hideshare - v0.1.0 - 2013-08-28
* https://github.com/arnonate/jQuery-FASS-Widget
* Copyright (c) 2013 Nate Arnold; Licensed MIT */
!function(a){a.fn.hideshare=function(b){return b=a.extend({},a.fn.hideshare.options,b),this.each(function(){var c=this,d=null,e=b.title,f=b.link,g=b.media,h='<li><a class="webicon facebook" href="#" onclick="shareFacebook(); return false;"><span>Facebook</span></a></li>',i='<li><a class="webicon twitter" href="#" onclick="shareTwitter(); return false;"><span>Twitter</span></a></li>',j='<li><a class="webicon pinterest" href="#" onclick="sharePinterest(); return false;" data-pin-do="buttonPin" data-pin-config="above"><span>Pinterest</span></a></li>',k='<li><a class="webicon googleplus" href="#" onclick="shareGooglePlus(); return false;"><span>Google Plus</span></a></li>',l='<li><a class="hideshare-linkedin" href="#" onclick="shareLinkedIn(); return false;"><i class="icon-linkedin icon-2x"></i><span>Linked In</span></a></li>';d=b.facebook?h:"",b.twitter?d+=i:d=d,b.pinterest?d+=j:d=d,b.googleplus?d+=k:d=d,b.linkedin?d+=l:d=d,shareFacebook=function(){window.open("//www.facebook.com/sharer.php?u="+encodeURIComponent(f),"Facebook","menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600")},shareTwitter=function(){window.open("//twitter.com/home?status="+encodeURIComponent(e)+"+"+encodeURIComponent(f),"Twitter","menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600")},sharePinterest=function(){window.open("//pinterest.com/pin/create/button/?url="+encodeURIComponent(f)+"&media="+encodeURIComponent(g)+"&description="+encodeURIComponent(e),"Pinterest","menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600")},shareGooglePlus=function(){window.open("//plus.google.com/share?url="+encodeURIComponent(f),"GooglePlus","menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600")},shareLinkedIn=function(){window.open("//www.linkedin.com/shareArticle?mini=true&url="+encodeURIComponent(f)+"&title="+encodeURIComponent(e)+"&source="+encodeURIComponent(f),"LinkedIn","menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600")};var m='<ul class="hideshare-wrap" style="display: none;">'+d+"</ul>";a(c).addClass("hideshare-btn"),a(m).insertAfter(c),a(".hideshare-btn").click(function(){return a(".hideshare-wrap").slideToggle(),!1})})},a.fn.hideshare.options={link:document.URL,title:document.title,media:null,facebook:!0,twitter:!0,pinterest:!0,googleplus:!0,linkedin:!0}}(jQuery);
