@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        @if($errors->any())
            <div class="alert alert-danger" style="margin-top: 4.6rem">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row" style="margin-top: 2rem; margin-bottom: 4rem">
            <div class="col-md-2"></div>
            <div class="col-md-6">
                <h3>Добавление статьи</h3>
                <form action="{{route('SaveNews')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="page" id="page" value="{{$Page['Страница']}}">
                    <input type="hidden" name="language" id="language" value="{{$Page['Язык']}}">
                    <input type="hidden" name="menupunct" id="menupunct" value="{{$Page['ПунктМеню']}}">
                    <div class="form-group">
                        <label for="name">Введите название</label><br>
                        <input style="width: 30rem" type="text" name="name" id="name">
                    </div>
                    <div>
                        <label for="topic">Введите тему</label><br>
                        <input style="width: 30rem" type="text" name="topic" id="topic">
                    </div>
                    <div class="form-group">
                        <label for="text">Введите короткий текст</label><br>
                        <textarea name="description" cols="55" rows="10" id="text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="redactor">Введте текст</label><br>
                        <textarea name="text" cols="55" rows="10" id="redactor"></textarea>
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.11.2.js">
    </script>
    <script type="text/javascript">
        (function () {
            var converter1 = Markdown.getSanitizingConverter();

            converter1.hooks.chain("preBlockGamut", function (text, rbg) {
                return text.replace(/^ {0,3}""" *\n((?:.*?\n)+?) {0,3}""" *$/gm, function (whole, inner) {
                    return "<blockquote>" + rbg(inner) + "</blockquote>\n";
                });
            });

            var editor1 = new Markdown.Editor(converter1);

            editor1.run();

            var converter2 = new Markdown.Converter();

            converter2.hooks.chain("preConversion", function (text) {
                return text.replace(/\b(a\w*)/gi, "*$1*");
            });

            converter2.hooks.chain("plainLinkText", function (url) {
                return "This is a link to " + url.replace(/^https?:\/\//, "");
            });

            var help = function () { alert("Do you need help?"); }
            var options = {
                helpButton: { handler: help },
                strings: { quoteexample: "whatever you're quoting, put it right here" }
            };
            var editor2 = new Markdown.Editor(converter2, "-second", options);

            editor2.run();
        })();
    </script>
@endsection
