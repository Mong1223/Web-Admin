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
