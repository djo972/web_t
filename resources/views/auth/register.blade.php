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
                <form class="form-signin" method="POST" action="{{ route('register') }}" novalidate>
                    <div class="mt-3 text-center">
                        @csrf
                        <div class="form-group row">
                            <label for="lname" class="sr-only">@lang('messages.label.last_name') *</label>
                            <input id="lname" type="text"
                                   class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname"
                                   value="{{ old('lname') }}" placeholder="@lang('messages.label.last_name')" required="required">
                            @if ($errors->has('lname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('lname') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="sr-only">@lang('messages.label.first_name') *</label>
                            <input id="fname" type="text"
                                   class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname"
                                   value="{{ old('fname') }}" placeholder="@lang('messages.label.first_name')" required="required">
                            @if ($errors->has('fname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fname') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="email" class="sr-only">@lang('messages.label.email') *</label>
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ old('email') }}" placeholder="@lang('messages.label.email')" required="required">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="pass" class="sr-only">@lang('messages.label.password') *</label>
                            <input id="pass" type="password"
                                   class="form-control{{ $errors->has('passw') ? ' is-invalid' : '' }}" name="passw"
                                   placeholder="@lang('messages.label.password')" required="required">
                            @if ($errors->has('passw'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('passw') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="confirm_pass" class="sr-only">@lang('messages.label.confirm_password') *</label>
                            <input type="password" id="confirm_pass" placeholder="@lang('messages.label.confirm_password')" class="form-control" required="required">
                            <span class="invalid-feedback confirm-pass" role="alert">
                                <strong class="error"></strong>
                            </span>
                        </div>

                        <div class="form-group row">
                            <button type="submit" class="btn btn-block">
                                @lang('auth.register')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('bo.layouts.js')

        <script type="text/javascript" src="{{ asset('/js/register.js') }}"></script>
    </body>
</html>
