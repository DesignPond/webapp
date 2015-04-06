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

});
