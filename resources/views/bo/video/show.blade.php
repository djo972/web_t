@extends('bo.layouts.index')

@section('content')
@section('js_files')
    {{-- Load vimeo player --}}
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="{{ asset('/js/video.js') }}"></script>
    <script src="{{ asset('/js/uploader.js') }}"></script>
    <script>
        var imagePath = '{{ asset('/uploads/images/')  }}';
    </script>
@endsection
@php
    $file = '';
    if ($video->link != '') {
        $file = $video->link;
    } elseif ($video->video_file) {
        $file = $video->video_file;
    }
@endphp
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
                                @if($video->video_file != '')
                                    {{-- To Remove
                                    <div class="icon_show_video">
                                        <video id='video-player' class='video-js vjs-default-skin' controls preload='auto' data-setup='{}' poster='{{ asset('/uploads/images/').'/'.$video->preview }}'>
                                            <source src='{{ route('video.stream',$video->video_file) }}' type='video/mp4'/>
                                            <source style=""  src="{{ route('video.stream',$video->video_file) }}" type="video/webm" />
                                            <source src="{{ route('video.stream',$video->video_file) }}" type="video/ogg" />
                                            <p class='vjs-no-js'>
                                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                                <a href='http://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
                                            </p>
                                        </video>
                                    </div> --}}

                                    {{-- vimeo player tag --}}

                                    <iframe src="https://player.vimeo.com/video/{{ basename($video->video_file) }}" width="640" height="360" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                                @else

                                    <iframe src="{{ $video->link }}" frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
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
@endsection
