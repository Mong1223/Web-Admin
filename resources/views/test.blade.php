<html>
<head>
</head>
<body>
    <form action="{{route('SaveImage')}}" method="POST" enctype="multipart/form-data">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <label for="file">Enter Image</label><br>
            {{csrf_field()}}
            <input type="file" name="file" id="file">
        </div>
        <button type="submit">Enter</button>
    </form>
</body>
</html>
