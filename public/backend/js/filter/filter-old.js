$( function() {

    var $orderFilter = $('#orderFilter');

    $orderFilter.change(function() {
        $('#filterChange').submit();
    });


    $(".selectpicker").chosen({
        disable_search_threshold: 10
    });

    //$(".selectpicker").chosen().change();

    /*
     * Fetch json
     */

    var urlroot  = location.protocol + "//" + location.host+"/";
    // container reference
    var $mainContainer = $('#mainContainer');
    var $pagination    = $('#pagination');

    var current   = 1;
    var offset    = 0;
    var limit     = 10;
    var totalPage = 0;

    // Test if container exist on page
    if($mainContainer) {

        var template  = '<li class="disabled"><a rel="previous" href="#">Précédent</a></li>';
            template += '<li><a rel="next" href="#">Suivant</a></li>';

        $pagination.append(template);
        var $links = $pagination.find('a');

        getTotal();
        fetchItems(limit,offset);
    }

    $links.on('click',function()
    {
        var $direction = $(this).attr('rel');

        $links.parent().removeClass('disabled');

        if($direction == 'next'){
            offset  = offset  + limit;
            current = current + 1;

            if(current === totalPage){
                $(this).parent().addClass('disabled');
            }
        }
        else
        {
            offset  = offset - limit;
            current = current - 1;

            if(current === 1){
                $(this).parent().addClass('disabled');
            }
        }

        fetchItems(limit,offset);

        console.log(totalPage);
        console.log(current);

    });

    function getTotal(){

        $.getJSON(urlroot + 'total')
            .done(function(result) {
                totalPage = Math.ceil(result/limit);
            })
            .fail(function() {
                $mainContainer.append('<p>Oh no, something went wrong!</p>');
            });
    }
    // Ajax function for item fetching
    function fetchItems(limit,offset,search){

        $.getJSON(urlroot + 'riiinglinks',{
            limit  : limit,
            offset : offset,
            search : search
        })
        .done(function(result) {
            if(result.data){

                var items = Object.keys(result.data).map(function(key){

                    var template  = '<div class="col-lg-6 col-md-6 col-xs-12 element-item"><div class="panel panel-info"><div class="panel-body">';
                        template += '<span class="pull-left"><img class="img-circle thumb48" alt="Image" src="' + urlroot + '/users/' + result.data[key].invited_photo + '"></span>';
                        template += '<a class="text-inverse" href="' + urlroot + 'user/link/"><strong class="title">' + result.data[key].invited_name + '</strong></a>';
                        template += '<small class="pull-right text-muted"><a class="mr btn btn-xs btn-oval btn-info" href="">Voir</a></small>';
                        template += '</div>';
                        template += '</div>';

                    return template;

                });

                //console.log(items);
                $mainContainer.empty();
                $mainContainer.append(items);
            }
            else{
                $mainContainer.append('<p>Oh no, something went wrong!</p>');
            }
        })
        .fail(function() {
            $mainContainer.append('<p>Oh no, something went wrong!</p>');
        });

    }

    /*
    * Isotope
    */

    // quick search regex
    var qsRegex;
    var buttonFilter;

    // init Isotope
    var $container = $('.isotope').isotope({
        itemSelector: '.element-item',
        layoutMode: 'fitRows',
        filter: function() {
            var $this = $(this);
            var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
            var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
            return searchResult && buttonResult;
        }
    });

    $('#selectFilter').on( 'change', function() {
        buttonFilter = $(this).find(':selected').attr('data-filter');
        $container.isotope();
    });

    // use value of search field to filter
    var $quicksearch = $('#quicksearch').keyup( debounce( function() {
        qsRegex = new RegExp( $quicksearch.val(), 'gi' );
        $container.isotope();
    }) );


    // change is-checked class on buttons
    $('.button-group').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'a', function() {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $( this ).addClass('is-checked');
        });
    });

    var url = location.protocol + "//" + location.host+"/";

    $( "#searchEmail" ).autocomplete({
        source: url + "search",
        minLength: 4,
        select: function( event, ui ) {
            $('#searchEmail').val(ui.item.label);
        }
    });

});

// debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
    var timeout;
    return function debounced() {
        if ( timeout ) {
            clearTimeout( timeout );
        }
        function delayed() {
            fn();
            timeout = null;
        }
        setTimeout( delayed, threshold || 100 );
    };
}
