$( function() {

    $(".selectpicker").chosen({
        disable_search_threshold: 10
    });

    var $orderFilter  = $('#orderFilter');
    var $selectFilter = $('#selectFilter');

    $orderFilter.change(function() {
        $('#filterChange').submit();
    });

    $selectFilter.change(function() {
        $('#filterChange').submit();
    });

    var partage = $('#partageMain');

    /**
    * Search autocomplete
    * */
    var url = location.protocol + "//" + location.host+"/";

    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

    $('#myTabs a').on('shown.bs.tab', function (e) {

        var $input = $(this).data('div');
        var $div   = $('#'+$input).find('input');

        $('.send_input').prop( "disabled", true );
        $div.prop( "disabled", false );

    })

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('#sendInvites').on('submit', function(e) { //use on if jQuery 1.7+

        var email = $('#searchEmail').val();
        if(IsEmail(email)){
            $('#inputEmail').val(email);
        }

    });

    $( "#searchEmail" ).autocomplete({
        source: url + "search",
        minLength: 3,
        change: function( event, ui )
        {
            console.log('changemet');

            var email = $('#searchEmail').val();

            if(IsEmail(email)){
                $('#inputEmail').val(email);
            }

        },
        focus: function( event, ui )
        {
            console.log('focus');
            var email = $('#searchEmail').val();
            if(IsEmail(email)){
                $('#inputEmail').val(email);
            }
        },
        response: function(event, ui) {
            // ui.content is the array that's about to be sent to the response callback.
            if (ui.content.length === 0)
            {
               // $('#searchEmail_email').attr('value', '');
            }
        },
        select: function( event, ui )
        {
            console.log('selected');
            $('#searchEmail').val(ui.item.label);
            $('#inputEmail').val(ui.item.value);

            $.get(url + "labels", { user_type: ui.item.user_type }, function( data )
            {
                $("[data-who='invited']").attr('checked', false);
                partage.html( data );
            });

            return false;
        }
    }).autocomplete( "instance" )._renderItem = function( ul, item )
    {
        return $( "<li>" ).append( "<a>" + item.label + "<span>" + item.desc + "</span></a>" ).appendTo( ul );
    };

});
