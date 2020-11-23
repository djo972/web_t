<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('/assets/images/favicon.ico') }}" type="image/ico"/>

    <title> {{ config('app.name') }} </title>

    @include('bo.layouts.css')
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet" type="text/css">
</head>


<body>
<div class="wrapper ">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="contain_logo">
            <img src="{{ asset('/assets/images/logo.png') }}" id="icon" alt="User Icon"/>
        </div>
        <form class="form-signin" method="POST" action="{{ route('login') }}" novalidate>
            <div class="mt-3 text-center">
                @csrf

                <div class="form-group row">
                    <label for="login" class="sr-only">{{ __('Login') }}</label>
                    <input id="login" type="text"
                           class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" name="login"
                           value="{{ old('login') }}" placeholder="@lang('messages.label.login')" required >

                    @if ($errors->has('login'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('login') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                           placeholder="@lang('messages.label.password')" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group row">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" name="remember"
                            id="remember" {{ old('remember') ? 'checked' : '' }}  class="custom-control-input">
                        <label class="custom-control-label" for="remember">@lang('messages.label.remember_me')</label>
                    </div>

                    <button type="submit" class="btn btn-block">
                        @lang('messages.label.login')
                    </button>

                    <button id="register" type="button" class="btn btn-block">
                        <a href="{{ route('register') }}" class="btn-register">@lang('auth.register')</a>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('bo.layouts.js')
</body>
</html>
