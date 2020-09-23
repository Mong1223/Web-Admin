<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5 - Summernote Wysiwyg Editor with Image Upload Example</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
</head>
<body>
<div class="card-body">
    <form enctype="multipart/form-data" name="documents" method="POST" action="{{route('upload')}}">
        @csrf

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Название документа') }}</label>

            <div class="col-md-6">
                <input id="title-message" type="text" class="form-control @error('title') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">

            <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Загрузка документа') }}</label>

            <div class="col-md-6">
                {{csrf_field()}}
                <input type="file" id="fileid" name="file" class="form-control">

                @error('thirdname')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <input type="hidden" name="id" value="A66E2E61-9A04-4FAB-8C9E-35DC02C42AB1">

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button id="send-document" type="submit" class="btn btn-primary">
                    {{ __('Отправить') }}
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
