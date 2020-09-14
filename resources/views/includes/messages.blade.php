<div class="container position-fixed fixed-top align-content-center" style="top: 6rem">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Форма отправки сообщения') }}</div>

                <div class="card-body">
                    <form name="messages" method="POST" action="">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Язык') }}</label>

                            <div class="col-md-6">

                                <select id="lang-message" size="1" class="form-control @error('lang') is-invalid @enderror" name="Language" required autocomplete="name" autofocus>
                                    @foreach($data['menulangs'] as $lang)
                                        <option value="{{$lang->Наименование}}">{{$lang->Наименование}}</option>
                                    @endforeach
                                </select>

                                @error('lang')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Заглавие') }}</label>

                            <div class="col-md-6">
                                <input id="title-message" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Текст') }}</label>

                            <div class="col-md-6">
                                <textarea id="text-message" class="form-control @error('thirdname') is-invalid @enderror" name="text"></textarea>

                                @error('thirdname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <input id="email-message" type="hidden" name="email" value="{{session('email')}}">
                        {{csrf_field()}}
                        <input id="token-message" type="hidden" name="token" value="{{session('token')}}">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="send-message" type="submit" class="btn btn-primary">
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
