(function($) {

    var $inputs = $(".mask_tel");

    $inputs.intlTelInput({
        defaultCountry: "auto",
        autoHideDialCode:true,
        autoFormat:true,
        nationalMode:false,
        utilsScript: "../../backend/js/utils.js"
    });

    $("#editForm").submit(function (e) {
        $inputs.each( function( index, element ){
            var intlNumber = $(this).intlTelInput("getNumber");
            if(intlNumber != ''){
                $(this).val(intlNumber);
            }
        });
    });

})(jQuery);