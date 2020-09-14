<html>
<head>
</head>
<body>
    @isset($data)
    <p>
        Error:{{$data->error}}
    </p>
    @else
        <p>
            Вы успешно смении пароль!
        </p>
    @endisset
</body>
</html>
