(function($) {

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var tab   = $(e.target).attr('rel');
        var input = $('#user_type');

        input.val(tab);

    });

    $.datepicker.regional['fr-CH'] = {
        closeText: 'Fermer',
        prevText: '&#x3c;Préc',
        nextText: 'Suiv&#x3e;',
        currentText: 'Courant',
        dateFormat: "yy-mm-dd",
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
        dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
        dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
        weekHeader: 'Sm',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false
    };

    $.datepicker.setDefaults($.datepicker.regional['fr-CH']);

   $( ".mask_date" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "1900:"+ new Date().getFullYear()
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        language: 'fr'
    });

    $('.daterange').daterangepicker({
        format: 'YYYY-MM-DD',
        separator: ' | ',
        locale: {
            applyLabel: 'Appliquer',
            cancelLabel: 'Annuler',
            fromLabel: 'De',
            toLabel: 'A',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Dim', 'Lu', 'Ma', 'Me', 'Je', 'Ve','Sa'],
            monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
            firstDay: 1
        }
    });

    var ranges = $(".daterange");

    $( ranges).each( function( index, element ){
        var value =  element;
    });

    // $(this).data('daterangepicker').setStartDate('2014-03-01');
    // $(this).data('daterangepicker').setEndDate('2014-03-31');
    var re_weburl = new RegExp('/^(ftp|http|https):\/\/[^ "]+$/');

    $(".mask_web").blur(function() {

        var input = $(this);
        var val   = input.val();

        if(val)
        {
            if(!val.match(/^http([s]?):\/\/.*/))
            {
                input.val('http://' + val);
            }

            var newval = input.val();

            console.log(newval);
            var myRegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
            if (!myRegExp.test(newval))
            {
                $(this).css({'border':'1px solid #b91919'});

                if(!$('#urlValidation').length)
                {
                    $( '<p id="urlValidation" class="text-danger">L\'url ne semble pas valide</p>' ).appendTo(this.closest('div'));
                }
            }
            else
            {
                $(this).css({'border':'1px solid #dbd9d9'});
                $('#urlValidation').remove();
            }

        }

    });

    $(".accordion-body").on("shown.bs.collapse", function () {
        var selected = $(this);
        var collapseh = $(".collapse.in").height();

        $('html, body').animate({
            scrollTop: $(selected).offset().top - 100
        }, 500);

        return false;
    });

    $('#scroll').slimScroll({
        height: '337px'
    });

    var base_url = location.protocol + "//" + location.host+"/";

    $("#myTags").tagit({
        placeholderText: "Nouveau tag",
        removeConfirmation: true,
        afterTagAdded: function(event, ui) {
            if(!ui.duringInitialization){

                var tag = ui.tagLabel;
                var id  = $(this).data('id');

                $.ajax({
                    dataType: "json",
                    type    : 'POST',
                    url     : base_url + 'addTag',
                    data: {  id  : id,  tag : tag , _token: $("meta[name='token']").attr('content') },
                    success: function( data ) {
                        console.log('added');
                    },
                    error: function(data) {  console.log('error');  }
                });
            }
        },
        beforeTagRemoved: function(event, ui) {

            var tag = ui.tagLabel;
            var id  = $(this).data('id');

            var answer = confirm('Voulez-vous vraiment supprimer : '+ tag +' ?');
            if (answer) {
                $.ajax({
                    dataType: "json",
                    type: 'POST',
                    url: base_url + 'removeTag',
                    data: {id: id, tag: tag, _token: $("meta[name='token']").attr('content')},
                    success: function (data) {
                        console.log('removed');
                    },
                    error: function (data) {
                        console.log('error');
                    }
                });
            }
            else
            {
                return false;
            }
        },
        autocomplete: {
            delay: 0,
            minLength: 2,
            source: function( request, response ) {
                $.ajax({
                    dataType: "json",
                    type    : 'GET',
                    url     : base_url + 'tags',
                    data: {  term: request.term , _token: $("meta[name='token']").attr('content') },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.title
                            }
                        }));
                    },
                    error: function(data) {  console.log('error');  }
                });
            }
        }
    });

    $('.partageCheckAll').on('click',function()
    {
        var who = $(this).data('who');
        console.log(who);
        if ($(this).is(':checked'))
        {
            $('.checkbox.'+who+' input').each(function(){this.checked = true;});
        }
        else
        {
            $('.checkbox.'+who+' input').each(function(){this.checked = false;});
        }
    });


})(jQuery);