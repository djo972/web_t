@extends('layouts.app')
@section('loader')
    <div class="preloader"></div>
@endsection
@section('nav')
    @include('layouts.navbar')
@endsection
@section('content')
    <div class="row container_video no-gutters">
{{--        <div class="col col-lg-9 col-md-8 col_video">--}}
        <div class="col col-lg-12 col_video">
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
{{--        <div class="col col-lg-3 col-md-4 col_text">
            <div class="bloc_desc">
                <div class="ajax-load text-center" >
                    <img src="{{ asset('/images/loading.svg') }}">
                </div>
            </div>
        </div>--}}
        @include('layouts.sidebar')
    </div>

    <div id="toTop" ><img src="{{ asset('/images/to-top.png') }}"></div>
    <a id="back" href="/"> Retour accueil<img src="{{ asset('/images/back.png') }}"></a>
@endsection
@section('js')
    {{-- Load vimeo player --}}
    <script>
        // $("ul li a").on("click", function(){
        //     alert($(this).find('p').text())
        // });

        function textToAudio() {


            let speech = new SpeechSynthesisUtterance();

            speech.lang = "fr-CA";
            speech.text = msg;
            speech.volume = 1;
            speech.rate = 1;
            speech.pitch = 1;

            window.speechSynthesis.speak(speech);
        }


        $(window).on('load', function () {
            $('.preloader').fadeOut('slow');
        });

    </script>
    <script src="https://player.vimeo.com/api/player.js"></script>
@endsection
