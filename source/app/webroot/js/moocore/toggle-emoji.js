/* Copyright (c) SocialLOFT LLC

 * mooSocial - The Web 2.0 Social Network Software

 * @website: http://www.moosocial.com

 * @author: mooSocial

 * @license: https://moosocial.com/license/

 */
(function(root, factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD
		define(['jquery', 'textcomplete','mooEmojiPicker'], factory);
	} else if (typeof exports === 'object') {
		// Node, CommonJS-like
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals (root is window)
		root.mooToggleEmoji = factory(root.jQuery);
	}
}(this, function($) {
	var init = function(textAreaId, icon) {
		if(!mooConfig.isApp){
			if (typeof icon === "undefined") {
				icon = '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>';
			}

			window.emojiPicker = new EmojiPicker({
				emojiable_selector: $('#' + textAreaId),
				assetsPath: mooConfig.url.base + '/img/emoji',
				popupButtonClasses: icon,

			});
			window.emojiPicker.discover();
		}
	};
	return {
		init: init
	}
}));