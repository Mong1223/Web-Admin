require('./bootstrap');
$(document).ready(function () {
    $('#redactor').summernote({
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
    if(hamburg!=null)
    {
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
    }
    let page = document.getElementsByClassName('article-title');
    for (var i=0;i<page.length;i++){
        page[i].addEventListener('click',function (event) {
            var div = event.target.nextSibling;
            div.classList.toggle("d-none");
            div.classList.toggle("d-block");
        });
    }
    let messagesntbtn = document.getElementById('messagesend');
    messagesntbtn.addEventListener('click',(event)=>{
        let messageform = document.getElementById('card-cont');
        messageform.classList.toggle('d-none');
    });
    let messagebtn = document.messages;
    messagebtn.addEventListener('submit',function (event) {
        event.preventDefault();
        let text = document.messages.text;
        let topic = document.messages.title;
        let lang = document.messages.Language;
        let emailmessage = document.messages.email;
        let tokenmes = document.messages.token;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                language: lang.value,
                title: topic.value,
                message: text.value,
                email: emailmessage.value,
                token: tokenmes.value
            },
            type: "POST",
            url: '/messages/send',
            success: function (req) {
                alert('succes');
                let card = document.getElementById('card-cont');
                card.classList.toggle('d-none');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
                alert(errorThrown);
            }
        });
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

    let deletebutton = document.getElementsByClassName('delete-news-button');
    for(var i=0;i<deletebutton.length;i++)
    {
        deletebutton[i].addEventListener('click',function deletefunc(event) {
            if(confirm('Удалить?'))
            {
                if(confirm('Вы уверены? Удалить?'))
                {
                }
                else {
                    event.preventDefault();
                }
            }
            else{
                event.preventDefault();
            }
        });
    }
});
let input = document.getElementById('image');
let group = document.getElementById('imagegroup');
if(input!=null)
{
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
                let id = url.substr(49);
                $('#imgid').attr('value',id);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
                alert(errorThrown);
            }
        });
    });
}
