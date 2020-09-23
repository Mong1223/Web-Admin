<div id="adddoc" class="container position-fixed fixed-top align-content-center d-none" style="top: 6rem">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="row">
                    <div id="docheader" class="card-header col-11">{{ __('Форма отправки документа') }}</div>
                    <div class="card-header col-1">
                        <a href="" id="closeform">X</a>
                    </div>
                </div>


                <div class="card-body">
                    <form name="documents">
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
                                <input id="fileid" name="document" type="file" class="form-control">

                                @error('thirdname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="send-document" type="submit" class="btn btn-primary">
                                    {{ __('Отправить') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
