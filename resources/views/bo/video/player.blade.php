@extends('bo.layouts.index')

@section('content')
@section('js_files')
    <script src="{{ asset('/js/video.js') }}"></script>
    <script src="{{ asset('/js/uploader.js') }}"></script>
    <script>
        var imagePath = '{{ asset('/uploads/images/')  }}';
    </script>
@endsection
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title">@lang('messages.label.video')</h1>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-12">

        <div class="card mb-3">
            <div class="card-body">

                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="invoice-title text-center mb-3 ">
                                @if($video->preview != '')
                                    <div class="icon_show_video">
                                <img src="{{ asset('/uploads/images/').'/'.$video->preview }}" class="img-thumbnail bloc_image" alt="{{ $video->name }}">
                                    </div>
                                @else
                                <img src="{{ asset('/uploads/images/').'/video-screen.jpg' }}" class="img-thumbnail bloc_image" alt="{{ $video->name }}">
                                    @endif
                            </div>
                            <div class="d-flex justify-content-between bloc_name">
                                <div class="font-weight-bold">{{ $video->name }}</div>
                                <div class="">@lang('messages.label.video_added'){{  date_format($video->created_at,"d/m/Y") }} </div>
                            </div>
                            <div class="bloc_description">
                                {!! $video->description !!}
                            </div>
                    </div>

                </div>


            </div><!-- end card body -->

        </div><!-- end card-->

    </div><!-- end col-->

</div>
@include('bo.video.create')
@endsection