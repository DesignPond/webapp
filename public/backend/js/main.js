(function($) {

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var tab   = $(e.target).attr('rel');
        var input = $('#user_type');

        input.val(tab);

    });

    /*    $.fn.datepicker.dates['fr'] = {
     days: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
     daysShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
     daysMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
     months: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
     monthsShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
     today: "Aujourd'hui",
     clear: "Clear"
     };*/

    /*  $('.mask_date').datepicker({
     format: 'yyyy-mm-dd',
     language: 'fr',
     calendarWeeks: true*
     });*/

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
        altFormat: "yyyy-mm-dd",
        dateFormat: "dd.mm.yy",
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

    $('.mask_tel').inputmask({"mask": "999 999 99 99"});  //static mask

    $(".mask_web").blur(function() {
        var input = $(this);
        var val = input.val();
        if (val && !val.match(/^http([s]?):\/\/.*/)) {
            input.val('http://' + val);
        }
    });

})(jQuery);