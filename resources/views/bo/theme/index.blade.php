@extends('bo.layouts.index')
@section('title')
    @lang('messages.title.theme')
@endsection
@section('content')
@section('js_files')
    <script src="{{ asset('/js/theme.js') }}"></script>
    <script>
        var imagePath = '{{ asset('/uploads/images/')  }}';
    </script>
@endsection

<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title">@lang('messages.title.theme')</h1>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row  mb-4">
            <div class="col-sm-6 col-12">
                <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input id="search_theme" name="search" class="form-control mr-sm-2" type="search" placeholder="@lang('messages.search')" aria-label="Search">
                </div>
            </div>
            <div class="col-sm-6 col-12 text-right">
                <button class="btn btn-primary btn-add-theme" type="button" data-toggle="modal" data-target="#addTheme">
                    @lang('messages.title_add_theme')
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="ajax-load text-center" style="display:none">
            <p><img src="{{ asset('/images/loading.gif') }}"></p>
        </div>
        <div id="list_items_theme" class="list-group list_items_style">
        </div>
    </div>
</div>
@include('bo.theme.create')
@endsection
