(function($) {

    var content = $('#timeline-content');

    var base_url = location.protocol + "//" + location.host + "/";
    var count = 5;
    var total = content.data('total');

    $( "#updateTimeline" ).click(function() {
        if (count > total) {
            $("#timelineLoader").hide();
            $('#updateTimeline').text('Aucune autre activité à afficher');
            return false;
        }
        else
        {
            loadArticle(count);
        }
        count = count + 5;
    });

    if(content)
    {
        $(window).scroll(function ()
        {
            if ( $(window).scrollTop() == $(document).height() - $(window).height() )
            {
                if (count > total) {
                    $("#timelineLoader").hide();
                    $('#updateTimeline').text('Aucune autre activité à afficher');
                    return false;
                }
                else
                {
                    loadArticle(count);
                }
                count = count + 5;
            }
        });
    }

    function loadArticle(pageNumber){

        $("#timelineLoader").show();

        $.ajax({
            url     : base_url + 'activites',
            data    : {skip : count , take : 5, _token: $("meta[name='token']").attr('content')},
            type    : "POST",
            success : function(data) {
                $("#timelineLoader").hide();
                $("#timeline-content").append(data);   // This will be the div where our content will be loaded
            }
        });

        return false;
    }

})(jQuery);