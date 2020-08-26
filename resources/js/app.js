require('./bootstrap');
$(document).ready(function () {
    $('#redactor').summernote({
        height: 500,
        width: 800,
        lang: 'ru-RU',
        callbacks: {
            onImageUpload: function (files,editor,welEditable) {
                sendFile(files[0],editor,welEditable);
            }
        }
    });
    var langtable = document.getElementById('langs-panel');
    $('#langs').bind('click',function () {
        langtable.classList.toggle('d-none');
        langtable.classList.toggle('d-block');
    });
    var menutype = document.getElementById('type');
    $('#type').bind('change',function () {
        if(menutype.selectedIndex==0){
            $('#menuarticle').show();
            $('#link').hide();
            $('#namearticle').innerText = "";
            $('#topicarticle').innerText = "";
            $('#image').innerHTML = "";
            $('#imgfile').attr('src','');
            $('#imgid').innerText = "";
            $('№descriptionarticle').innerText = "";
            $('#redactor').innerText = "";
        }
        if(menutype.selectedIndex==1){
            $('#linktext').innerText = "";
            $('#link').show();
            $('#menuarticle').hide();
        }
        if(menutype.selectedIndex==2){
            $('#link').hide();
            $('#menuarticle').hide();
        }
        if(menutype.selectedIndex==3){
            $('#link').hide();
            $('#menuarticle').hide();
        }
    });
    let hamburg = document.getElementById('hamburg');
    hamburg.addEventListener('click',function () {
        let sidebarcont = document.getElementById('sidebar-content');
        let contentnav = document.getElementById('content-nav');
        let main = document.getElementById('main');
        sidebarcont.classList.toggle("d-none");
        sidebarcont.classList.toggle("d-block");
        contentnav.classList.toggle("col-md-1");
        contentnav.classList.toggle("col-md-2");
        contentnav.classList.toggle("sidebar-little");
        main.classList.toggle("col-md-11");
        main.classList.toggle("col-md-10");
    });
    let page = document.getElementsByClassName('article-title');
    for (var i=0;i<page.length;i++){
        page[i].addEventListener('click',function (event) {
            var div = event.target.nextSibling;
            div.classList.toggle("d-none");
            div.classList.toggle("d-block");
        });
    }
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
            async: true,
            success: function (url) {
                let html = $('#redactor').summernote('code');
                $('#redactor').summernote('code',html+'<img style="max-width:100%;height:auto;" src="'+url+'"/>');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
                alert(errorThrown);
            }
        });
    }
});
let input = document.getElementById('image');
let group = document.getElementById('imagegroup');
input.addEventListener('change',function (event) {
    let file = event.srcElement.files[0];
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
        async: true,
        success: function (url) {
            $('#imgfile').attr('src',url);
            let id = url.substr(42);
            $('#imgid').attr('value',id);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus);
            alert(errorThrown);
        }
    });
});
