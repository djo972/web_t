@extends('layouts.app')
@section('nav')
    @include('layouts.header')
@endsection
@section('content')

@section('block_js')
    {{-- Load vimeo player --}}
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script>
        var isShareable = '';
        @if($video != null)
            isShareable = {{ $video->is_shareable }}
            $(document).ready(function() {
                $('.bloc_description').mCustomScrollbar({
                    axis: "y",
                    theme: "dark"
                });

                // To Remove
                // $('video').prop('muted',true)
                // $('video').attr('data-keepplaying', '')
                // $('video').get(0).play();
            });
        @endif
        if(isShareable == 1){
            $('.share_links').show();
        }

    </script>
@endsection
    <div class="container_home">
{{--        @if($video != null)--}}
{{--            <h1>{{ $video->name }} </h1>--}}
{{--        @endif--}}
        <div class="bloc_video">
            @if($video != null)
                @if($video->video_file != '')
                    {{-- To Remove
                    <video id='video-player' class='video-js vjs-default-skin'  poster='{{ asset('/uploads/images/').'/'.$video->preview }}' controls autoplay="autoplay">
                        <source src='{{ route('video.stream',$video->video_file) }}' type='video/mp4'/>
                        <source style=""  src="{{ route('video.stream',$video->video_file) }}" type="video/webm" />
                        <source src="{{ route('video.stream',$video->video_file) }}" type="video/ogg" />
                        <p class='vjs-no-js'>
                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                            <a href='http://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
                        </p>
                    </video> --}}

                    {{-- vimeo player tag --}}
                <div class="embed-container">
                    <iframe src="https://player.vimeo.com/video/{{ $video->video_file }}?autoplay=1"  width="640" height="360" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                </div>

                @endif
            @endif
        </div>
{{--        <div class="bloc_description">--}}
{{--            @if($video != null)--}}
{{--                {!! $video->description !!}--}}
{{--            @else--}}
{{--                <div class="ajax-load text-center" >--}}
{{--                    <img src="{{ asset('/images/loading.svg') }}">--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

    </div>
@include('layouts.nav')

@endsection
