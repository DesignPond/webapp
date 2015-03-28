(function($) {

    $.riiinglink = function(element, options) {

        var defaults = {}

        var plugin = this;

        plugin.settings = {}

        var $element = $(element),
            element  = element;

        plugin.init = function() {

            plugin.settings = $.extend({}, defaults, options);

            var $linked	  = $element.find(".riiinglink");
            var $checkbox = $linked.find(':checkbox');

            $checkbox.change(function()
            {
                $check  = $(this).closest('.linked');
                $check.toggleClass("used");

                var color = $check.find('.chat-msg-content');
                color.toggleClass("bg-activated bg-grey");

                saving($check);

            });
        }

        plugin.foo_public_method = function() {}

        var saving = function(color) {

            var riiinglink = $('#formRiiinglink').serialize();

            $.ajax({
                url     : '/updateMetas',
                data    : { riiinglink: riiinglink , _token: $("meta[name='token']").attr('content')},
                type    : "POST",
                dataType: 'json',
                success : function(data) {
                    if(data)
                    {
                       // $('#saved').fadeIn(200).delay(2000).fadeOut(200);
                        $(color).notify("ok!", {autoHideDelay: 900, position:"left",className: "success" });
                       // $(color).notify.defaults( {autoHideDelay: 900, position:"right"} );
                    }
                }
            });
        }

        plugin.init();

    }

    $.fn.riiinglink = function(options) {

        return this.each(function() {
            if (undefined == $(this).data('riiinglink')) {
                var plugin = new $.riiinglink(this, options);
                $(this).data('riiinglink', plugin);
            }
        });
    }

    $('.riiinglink-list').riiinglink();


})(jQuery);
