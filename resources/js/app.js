require('./bootstrap');
$(document).ready(function () {
    $('#redactor').summernote({
        height: 500,
        width: 800,
        callbacks: {
            onImageUpload: function (files,editor,welEditable) {
                sendFile(files[0],editor,welEditable);
            }
        }
    });
    var menutype = document.getElementById('type');
    $('#type').bind('change',function () {
        if(menutype.selectedIndex==0){
            $('#menuarticle').show();
            $('#link').hide();
            $('#linktext').innerText = "";
        }
        if(menutype.selectedIndex==1){
            $('#link').show();
            $('#menuarticle').hide();
            $('#namearticle').innerText = "";
            $('#topicarticle').innerText = "";
            $('#descriptionarticle').innerText = "";
            $('#textarticle').innerText = "";
        }
        if(menutype.selectedIndex==2){
            $('#link').hide();
            $('#menuarticle').hide();
            $('#linktext').innerText = "";
            $('#namearticle').innerText = "";
            $('#topicarticle').innerText = "";
            $('#descriptionarticle').innerText = "";
            $('#textarticle').innerText = "";
        }
        if(menutype.selectedIndex==3){
            $('#link').hide();
            $('#menuarticle').hide();
            $('#linktext').innerText = "";
            $('#namearticle').innerText = "";
            $('#topicarticle').innerText = "";
            $('#descriptionarticle').innerText = "";
            $('#textarticle').innerText = "";
        }
    })
    function sendFile(file, editor, welEditable) {
        datafile = new FormData();
        datafile.append("file",file);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: datafile,
            type: "POST",
            url: '/SaveNews/SaveImage',
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            success: function (url) {
                $('#testing').html(url);
                editor.insertImage(welEditable,url);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
                alert(errorThrown);
            }
        });
    }
});
