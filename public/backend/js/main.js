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
        dateFormat: "yyyy-mm-dd",
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


    $(".mask_web").blur(function() {
        var input = $(this);
        var val = input.val();
        if (val && !val.match(/^http([s]?):\/\/.*/)) {
            input.val('http://' + val);
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
        height: '350px'
    });

})(jQuery);