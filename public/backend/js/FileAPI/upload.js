var url  = location.protocol + "//" + location.host+"/";

$('#userpic').fileapi({
    url: url + 'upload',
    accept: 'image/*',
    data:{_token: $("meta[name='token']").attr('content')},
    imageSize: { minWidth: 200, minHeight: 200 },
    elements: {
        active: { show: '.js-upload', hide: '.js-browse' },
        preview: {
            el: '.js-preview',
            width: 200,
            height: 200
        },
        progress: '.js-progress'
    },
    onComplete: function (evt, uiEvt){
        var file = uiEvt.file;
        $("#flow-img").val(file.name);
        var path = url + 'users/' + file.name;
        $("#userpic").css({ "background-image" : '' });
        $("#userpic").css({ "background-image" : 'url("' + path + '")' });

        console.log(path);
    },
    onSelect: function (evt, ui){
        var file = ui.files[0];
        if( !FileAPI.support.transform ) {
            alert('Your browser does not support Flash :(');
        }
        else if( file ){
            $('#popup').modal({
                closeOnEsc: true,
                closeOnOverlayClick: true,
                onOpen: function (overlay){
                    $(overlay).on('click', '.js-upload', function (){
                        $.modal().close();
                        $('#userpic').fileapi('upload');
                    });
                    $('.js-img', overlay).cropper({
                        file: file,
                        bgColor: '#fff',
                        maxSize: [$(window).width()-100, $(window).height()-100],
                        minSize: [200, 200],
                        selection: '90%',
                        onSelect: function (coords){
                            $('#userpic').fileapi('crop', file, coords);
                        }
                    });
                }
            }).open();
        }
    }
});
