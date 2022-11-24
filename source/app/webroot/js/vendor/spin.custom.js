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