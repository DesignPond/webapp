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

    $( "#searchEmail" ).autocomplete({
        source: url + "search",
        minLength: 4,
        select: function( event, ui )
        {
            $('#searchEmail').val(ui.item.label);
            $('#searchEmail_post').val(ui.item.value);

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
