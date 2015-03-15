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
                $check = $(this).closest('.linked');

                $check.toggleClass("used");

                var color = $check.find('.chat-msg-title');
                color.toggleClass("bg-turquoise bg-grey");

                saving();

            });
        }

        plugin.foo_public_method = function() {}

        var saving = function() {

            var riiinglink = $('#formRiiinglink').serialize();

            $.ajax({
                url     : '/updateMetas',
                data    : { riiinglink: riiinglink },
                type    : "POST",
                dataType: 'json',
                success : function(data) {
                    if(data)
                    {
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
