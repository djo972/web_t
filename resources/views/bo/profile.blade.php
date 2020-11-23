@extends('bo.layouts.index')
@section('js_files')
    <script>
        $(document).ready(function() {
            var birthDate = '{{$user->birth_date}}';
            if (birthDate) {
                $('#birth_date').val(formatDate(birthDate));
            }
        });
    </script>
@endsection
@section('content')
<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-user"></i> @lang('messages.title_profile')</h3>
            </div>

            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ route('bo.editProfile') }}" novalidate>
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="male" name="gender" checked class="custom-control-input" value="1" @if($user->gender == 1) checked @endif>
                                        <label class="custom-control-label" for="male">@lang('messages.label.male')</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="female" name="gender" class="custom-control-input" value="2" @if($user->gender == 2) checked @endif>
                                        <label class="custom-control-label" for="female">@lang('messages.label.female')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('messages.label.first_name')</label>
                                        <input class="form-control" name="first_name" type="text" placeholder="@lang('messages.label.first_name')" value="{{$user->first_name}}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('messages.label.last_name')</label>
                                        <input class="form-control" name="last_name" type="text" placeholder="@lang('messages.label.last_name')" value="{{$user->last_name}}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('messages.label.email')</label>
                                        <input class="form-control" name="email" type="email" placeholder="@lang('messages.label.email')" value="{{$user->email}}" >
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('messages.label.mobile')</label>
                                        <input class="form-control" name="mobile" type="text" placeholder="@lang('messages.label.mobile')" value="{{$user->mobile}}" >
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('messages.label.birth_date')</label>
                                        <input class="form-control input-datepicker" id="birth_date" name="birth_date" type="text" placeholder="@lang('messages.label.birth_date')" value="" autocomplete="off" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                        <label for="new-password" class="control-label">@lang('messages.label.current_password')</label>

                                            <input id="current-password" type="password" class="form-control" name="current-password" >

                                            @if ($errors->has('current-password'))
                                                <span class="help-block text-danger">
                                            <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                            @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                        <label for="new-password" class="control-label">@lang('messages.label.new_password')</label>

                                            <input id="new-password" type="password" class="form-control" name="new-password" >

                                            @if ($errors->has('new-password'))
                                                <span class="help-block text-danger">
                                            <strong>{{ $errors->first('new-password') }}</strong>
                                        </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="new-password-confirm" class="control-label">@lang('messages.label.confirm_new_password')</label>

                                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">@lang('messages.btn.edit_profile')</button>
                                </div>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
            <!-- end card-body -->

        </div>
        <!-- end card -->

    </div>
    <!-- end col -->

</div>
@endsection