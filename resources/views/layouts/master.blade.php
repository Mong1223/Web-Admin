<html>
<head>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <title>Internationals</title>
    <meta charset="UTF-8">
</head>

<body>
@include('includes.header')
@yield('content')
@isset($data['menulangs'])
    @include('includes.messages')
    @include('includes.AddDoc')
@endisset
</body>
</html>
