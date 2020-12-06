@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div class="row container_video no-gutters">
        <div class="col col-lg-9 col-md-8 col_video">
            <div class='bloc_video_theme'>
                <div class="embed-container-theme">
                    <div class="ajax-load text-center" >
                        <img src="{{ asset('/images/loading.svg') }}">
                    </div>
                </div>
            </div>
            <div id="listVideos" class="bloc_list_video">
                <div class="carousel-video">
                    <div class="ajax-load text-center" >
                        <img src="{{ asset('/images/loading.svg') }}">
                    </div>
                </div>
                <img id="carouselVideoLoading" src="{{ asset('/images/spinner.svg') }}">
            </div>
        </div>
        <div class="col col-lg-3 col-md-4 col_text">
            <div class="bloc_desc">
                <div class="ajax-load text-center" >
                    <img src="{{ asset('/images/loading.svg') }}">
                </div>
            </div>
        </div>
    </div>
    <div id="toTop" ><img src="{{ asset('/images/to-top.png') }}"></div>
@endsection
@section('js')
    {{-- Load vimeo player --}}

    <script src="https://player.vimeo.com/api/player.js"></script>
@endsection
