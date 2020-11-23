@extends('bo.layouts.index')
@section('title')
    @lang('messages.title.video')
@endsection
@section('content')
@section('js_files')
    <script src="{{ asset('/js/uploader.js') }}"></script>
    <script src="{{ asset('/js/video.js') }}"></script>
    <script>
        var imagePath = '{{ asset('/uploads/images/')  }}';
    </script>
@endsection
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title">@lang('messages.title.video')</h1>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input id="search_video" name="search" class="form-control mr-sm-2" type="search" placeholder="@lang('messages.search')" aria-label="Search">
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <select class="form-control" id="fillerListThemes">
                        <option value="" >@lang('messages.label.select.themes')</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-primary btn-add-video" type="button" data-toggle="modal" data-target="#addVideo">
                    @lang('messages.title_add_video')
                    <i class="fa fa-plus"></i>
                </button>
                {{--<a href="{{ route('bo.video.showCreate') }}" class="btn btn-primary btn-add-video" >
                    @lang('form.video.add')
                    <i class="fa fa-plus"></i>
                </a>--}}
            </div>
        </div>
        <div class="ajax-load text-center" style="display:none">
            <p><img src="{{ asset('/images/loading.gif') }}"></p>
        </div>
        <div id="list_items_video" class="list-group list_items_style">
        </div>
        <div class="ajax-load-more text-center" style="display:none">
            <p><img src="{{ asset('/images/loading.gif') }}">@lang('messages.loading_more_video')</p>
        </div>
    </div>
</div>
@include('bo.video.create_modal')
@endsection