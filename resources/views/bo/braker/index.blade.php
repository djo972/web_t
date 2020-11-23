@extends('bo.layouts.index')
@section('title')
    @lang('messages.title.video')
@endsection
@section('content')
@section('js_files')
    <script src="{{ asset('/js/uploader.js') }}"></script>
    <script src="{{ asset('/js/braker.js') }}"></script>
    <script>
        var imagePath = '{{ asset('/uploads/images/')  }}';
    </script>
@endsection
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title">@lang('messages.title.video_braker')</h1>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row justify-content-end">
            @if($braker == null)
            <button class="btn btn-primary btn-add-braker" type="button" data-toggle="modal" data-target="#addBraker">
                @lang('messages.title_add_braker')
                <i class="fa fa-plus"></i>
            </button>
                @else
            <button class="btn btn-primary btn-update-braker mb-3 mr-2" data-url="{{ route('bo.barker.show', $braker->id) }}" type="button" data-toggle="modal" data-target="#updateBraker">
                @lang('messages.title_update_braker')
                <i class="fa fa-plus"></i>
            </button>
            @endif
        </div>
        @if($braker != null)
        <div class="row">

            <div class="col-12">

                <div class="card mb-3">
                    <div class="card-body">

                        <div class="container">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="invoice-title text-center mb-3 ">
                                        <iframe src="https://player.vimeo.com/video/{{ basename($braker->video_file) }}" width="640" height="360" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                                    </div>
                                    <div class="d-flex justify-content-between bloc_name">
                                        <div class="font-weight-bold">{{ $braker->name }}</div>
                                        <div class="">@lang('messages.label.video_added'){{  date_format($braker->created_at,"d/m/Y") }} </div>
                                    </div>
                                    <div class="bloc_description">
                                        {!! $braker->description !!}
                                    </div>
                                </div>

                            </div>


                        </div><!-- end card body -->

                    </div><!-- end card-->

                </div><!-- end col-->

            </div>
    </div>
        @endif
</div>
@include('bo.braker.braker_modal')
@endsection