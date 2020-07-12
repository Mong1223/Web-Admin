<html>
<head>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <title>TPU PROJECT</title>
    <meta charset="UTF-8">
</head>

<body>
@include('includes.header')
@yield('content')
</body>
<script>
    var current = 0;
    shownews(current);
    function submenushow(id){
        var nameid = "lvl2";
        nameid = nameid + id;
        document.getElementById(nameid).classList.toggle("active");
    }
    function shownews(current){
        var i;
        var listnews = document.getElementsByClassName("news-content");
        for(i=0;i<listnews.length;i++){
            listnews[i].style.display = "none";
        }
        listnews[current].style.display = "block";
    }
</script>
</html>
