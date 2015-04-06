(function($) {

    var content = $('#timeline-content');

    var base_url = location.protocol + "//" + location.host + "/";
    var count = 5;
    var total = content.data('total');

    if(content)
    {
        $(window).scroll(function () {
            if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                if (count > total) {
                    return false;
                }
                else {
                    loadArticle(count);
                }
                count = count + 5;
            }
        });
    }

    function loadArticle(pageNumber){

        $.ajax({
            url     : base_url + 'activites',
            data    : {skip : count , take : 5, _token: $("meta[name='token']").attr('content')},
            type    : "POST",
            success : function(data) {
                console.log('hex');
                $("#timeline-content").append(data);   // This will be the div where our content will be loaded
            }
        });

        return false;
    }

})(jQuery);