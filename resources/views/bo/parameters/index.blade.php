@extends('bo.layouts.index')

@section('title')
    @lang('messages.title.parameters')
@endsection

@section('block_css')
    <link href="{{ asset('/css/parameters.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="breadcrumb-holder">
                <h1 class="main-title">@lang('messages.title.parameters')</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center"><label>@lang('messages.label.parameters.access')</label></div>
            <div class="row justify-content-center">
                <label class="switch">
                    <input id="iptAccess" data-type="access" type="checkbox" {{ $access == true ? "checked='checked'" : "" }}>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center"><label>@lang('messages.label.parameters.payment')</label></div>
            <div class="row justify-content-center">
                <label class="switch">
                    <input id="iptPayment" data-type="payment" type="checkbox" {{ $payment == true ? "checked='checked'" : "" }}>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
@endsection

@section('block_js')
    <script type="text/javascript">
        var routeUpdate = "{{ route('bo.parameters.update') }}";
    </script>
    <script type="text/javascript" src="{{ asset('/js/parameters.js') }}"></script>
@endsection