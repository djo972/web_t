'use strict';
/**
 * Setup module
 */
var App = function () {

    var linkPost = '';
    var linkVideo = '';
    var url = window.location.href;
    var baseUrl = $('meta[name="_base_url"]').attr('content');
    var $textDescription = $(".description_video");
    var $listVideos = $('#listVideos');
    var $toTop = $('#toTop');

    /**
     * Add CSRF Protection for every ajax request
     */
    var _ajaxSetup = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    };

    var _frameVideo = function (linkVideo) {
        return "<iframe src='" + linkVideo + "' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";

    };

    var _htmlVideo = function (linkPost, linkVideo) {
        // vimeo player tag
        return "<div class='image_Container'><iframe src='" + linkVideo +"' frameborder='0' allowfullscreen allow='autoplay; encrypted-media'></iframe></div>";
        App.initEnded();
    };

    /**
     * Load carousel viseos
     */
    var _loadCarouselVideos = function () {
        console.log('_loadCarouselVideos');
        var lastPage = '';
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            contentType: 'application/json',
            cache: false,
            success: function (response) {
                var carouselData = '';
                var active = '';
                $listVideos.find('.carousel-video').html('');
                if (response.data != '') {
                    getFirstVideo(response.data[0]);

                    $.each(response.data, function (index, value) {
                        var filePathImage = baseUrl + '/uploads/images/' + value.preview;
                        if (index == 0) {
                            active = 'active_image';
                        } else {
                            active = '';
                        }
                        carouselData += "<div class='item' data-id='" + value.id + "'><img class='item_video " + active + "' alt='" + value.name + "' src='" + filePathImage + "'/><h2>" + value.name + "</h2></div>";
                    });
                    $listVideos.find('.carousel-video').html(carouselData);
                } else {
                    $('.container_video').html("<div id='notfound'><div class='notfound'><div class='notfound-404'></div><h1>Oops!</h1><p>" + messages.video_not_found + "</p><a href='/'>" + messages.back_home + "</a></div></div>");
                }
                lastPage = response.last_page;
            },
            error: function (response) {
                $('.container_video').html("<div id='notfound'><div class='notfound'><div class='notfound-404'></div><h1>Oops!</h1><p>" + messages.video_not_found + "</p><a href='/'>" + messages.back_home + "</a></div></div>");
            },
            complete: function () {
                var page = 1;
                $(".carousel-video").mCustomScrollbar({
                    axis: "x",
                    theme: "dark-3",
                    horizontalScroll: true,
                    advanced: {autoExpandHorizontalScroll: true},
                    callbacks: {
                        onTotalScroll: function () {
                            page++;
                            if (page <= lastPage) {
                                loadMoreVideo(page)
                            }
                        },
                        ondrag: function ($item, position) {
                            // original functionality - better be safe
                            $item.css(position);

                            var sign = '-';
                            if ($this._prevDragPositionY > position.top) {
                                sign = '+'; //console.log('scrolling up');
                            } else { //console.log('scrolling down'); }
                                $this._prevDragPositionY = position.top;

                                $('.jsScroll').mCustomScrollbar("scrollTo", sign + "=75", {
                                    scrollInertia: 300,
                                    scrollEasing: "linear"
                                });
                            }
                        }
                    }
                });

            }

        });

        /**
         * Load more videos and append to carousel paginate by 10
         */
        function loadMoreVideo(page) {
            console.log('loadMoreVideo');
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    beforeSend: function () {
                        $('#carouselVideoLoading').show();
                    }
                },
            ).done(function (response) {
                var carouselData = '';
                $.each(response.data, function (index, value) {
                    var filePathImage = baseUrl + '/uploads/images/' + value.preview;
                    carouselData += "<div class='item' data-id='" + value.id + "'><img class='item_video' alt='" + value.name + "' src='" + filePathImage + "'/><h2>" + value.name + "</h2></div>";
                });
                $('#carouselVideoLoading').hide();
                $(".carousel-video .mCSB_container").append(carouselData);
                console.log(response.data);
            });
        }

        /**
         * Load video and set up to read
         */
        function getFirstVideo(response) {
            console.log('getFirstVideo');
            if (response.preview) {
                linkPost = baseUrl + '/uploads/images/' + response.preview;
            }

            /*if (response.link) {
                linkVideo = response.link;
                $(".bloc_video_theme").html(_frameVideo(linkVideo));
            } else {
                linkVideo = baseUrl + '/streamVideo/' + response.video_file;
                $(".bloc_video_theme").html(_htmlVideo(linkPost, linkVideo));
            }*/
            linkVideo = "https://player.vimeo.com/video/" + response.video_file;
            $(".bloc_video_theme .embed-container-theme ").html(_htmlVideo(linkPost, linkVideo));
            var description = '';

            description += "<h1>" + response.name + "</h1>";
            description += "<div class='description_video'>" + response.description + "</div>";
            $('.bloc_desc').html(description);
            jQuery('iframe').contents().find('#player .controls-wrapper .title h1').css({'display':'none'});
            if (response.is_shareable == 1) {
                $('.share_links').show();
            } else {
                $('.share_links').hide();
            }
            $('.description_video').mCustomScrollbar({
                axis: "y",
                theme: "dark"
            });
        }
    };


    /**
     * Active Navbar link
     */
    var _activeNavbar = function () {
        $("#listLinks li").each(function (index) {
            if ($(this).find('a').attr('href') == url) {
                $(this).find('a').addClass('active_navbar_li');
            }
        });
    };

    /**
     * load Video when from carousel videos
     */
    var _loadVideoFromCarousel = function () {
        console.log('_loadVideoFromCarousel');



        $('#listVideos').on('click', '.item', function () {
            var id = $(this).data('id');
            var url = '/video/' + id;
            var self = $(this);
            $('#listVideos').find('img').removeClass('active_image');
            var linkPost = '';
            var linkVideo = '';

            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                cache: false,
                success: function (response) {
                    self.find('img').addClass('active_image');
                    if (response.preview) {
                        linkPost = baseUrl + '/uploads/images/' + response.preview;
                    }
                    /*if (response.link) {
                        linkVideo = response.link;
                        $(".bloc_video_theme").html(_frameVideo(linkVideo));
                    } else {
                        linkVideo = baseUrl + '/streamVideo/' + response.video_file;
                        $(".bloc_video_theme").html(_htmlVideo(linkPost, linkVideo));
                    }*/
                    linkVideo = "https://player.vimeo.com/video/" + response.video_file;
                    $(".bloc_video_theme").html(_htmlVideo(linkPost, linkVideo));


                    $('h1').html(response.name);
                    $(".description_video  #mCSB_1_container").html(response.description);
                    if (response.is_shareable == 1) {
                        $('.share_links').show();
                    } else {
                        $('.share_links').hide();
                    }

                    $('html,body').animate({scrollTop: 0}, 'slow');

                },
                error: function (response) {
                }
            });
        });

    }

    // When the user clicks on the button, scroll to the top of the document
    var _toTopFunction = function () {
        $('#toTop').on('click', function () {
            $('html,body').animate({scrollTop: 0}, 'slow');
            return false;
        });
    }

    /**
     * load plugin jsSocials for sharing page
     */
    var _shareLink = function () {
        $(".share_links").jsSocials({
            shareIn: "popup",
            showLabel: false,
            shares: [{
                share: "twitter",
                logo: "../images/icons8-twitter-24.png"
            }, {
                share: "facebook",
                logo: "../images/icons8-facebook-24.png"
            }, {
                share: "instagram",
                logo: "../images/icons8-instagram-24.png"
            }],
        });
    }

    var _scrollFunction = function () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            $toTop.show();
        } else {
            $toTop.hide();
        }
    }
   var _getEndedEvent=function(){

       var iframe = document.querySelector('iframe');
       var player = new Vimeo.Player(iframe);
       console.log(iframe);
       console.log(player);
       player.on('play', function() {
           console.log('Played the video');
       });
       player.getVideoTitle().then(function(title) {
           console.log('title:', title);
       });
    };
    // var _scrollMenu = function () {
    //     $('#listLinks').mousewheel(function(e, delta) {
    //         this.scrollLeft -= (delta * 40);
    //
    //         e.preventDefault();
    //     });
    // };

    var _scrollMenu = function () {

        var links = document.getElementById('listLinks');
        var  righty = document.getElementsByClassName('rightButton');
        var lefty = document.getElementsByClassName('leftButton');

        var handlerClickRight = function(){

            event.preventDefault();
            $('#listLinks').animate({
                scrollLeft: "+=300px"
            }, "slow");
        }
        var handlerClickLeft = function(){

            event.preventDefault();
            $('#listLinks').animate({
                scrollLeft: "-=300px"
            }, "slow");
        }

        function removeArrow(handlerClickLeft,handlerClickRight){

            var  righty = document.getElementsByClassName('rightButton');
            var lefty = document.getElementsByClassName('leftButton');
            var $width = $('#listLinks').outerWidth()
            var $scrollWidth = $('#listLinks')[0].scrollWidth;
            var $scrollLeft = $('#listLinks').scrollLeft();
            var equal = $scrollWidth - $width ;

            if (Math.abs(equal  - $scrollLeft) <= 1) {
                righty[0].removeEventListener('click',handlerClickRight,false);
                righty[0].addEventListener('click',handlerClickLeft,false);
                righty[0].classList.add("end");
            }else{
                righty[0].removeEventListener('click',handlerClickLeft,false);
                righty[0].addEventListener('click',handlerClickRight,false);
                righty[0].classList.remove("end");
            }
            if ($scrollLeft===0){
                lefty[0].removeEventListener('click',handlerClickLeft,false);
                lefty[0].addEventListener('click',handlerClickRight,false);
                lefty[0].classList.add('end');
            }
            else{
                lefty[0].removeEventListener('click',handlerClickRight,false);
                lefty[0].addEventListener('click',handlerClickLeft,false);
                lefty[0].classList.remove("end");
            }
        }


        function addArrows(hasHorizontalScrollbar){

            var hasHorizontalScrollbar = links.scrollWidth > links.clientWidth;

            if(hasHorizontalScrollbar === true){
                var parentElement = document.getElementById('navbarNav');
                var theFirstChild = document.getElementById('listLinks');

                var newElement = document.createElement('div');
                newElement.classList.add('leftButton');

                var newElement2 = document.createElement('div');
                newElement2.classList.add('rightButton');

                parentElement.insertBefore(newElement, theFirstChild)    ;
                theFirstChild.after(newElement2);


                removeArrow(handlerClickLeft,handlerClickRight);
            }
        }


        window.onresize = function(event) {
            var links = document.getElementById('listLinks');
            var parentE = links.parentElement;
            var hasHorizontalScrollbar = links.scrollWidth > links.clientWidth;
            var  divExists =parentE.getElementsByClassName("leftButton");

            if ((divExists.length > 0)&&(hasHorizontalScrollbar === false)) {
                document.querySelectorAll('.leftButton ,.rightButton').forEach(function(a) {
                    a.remove()
                })
            }else if ((divExists.length == 0)&&(hasHorizontalScrollbar === true))
            {
                addArrows();
                removeArrow(handlerClickLeft,handlerClickRight);
            }
        };
        addArrows();


        $('#listLinks').scroll( function() {
            removeArrow(handlerClickLeft,handlerClickRight);
        });


        $('#listLinks').mousewheel(function(e, delta) {
            this.scrollLeft -= (delta * 40);

            e.preventDefault();
        });
    }


    var darkMorde = function myFunction() {
        let element = document.body;
        let mod=element.classList.contains("dark-mode");
        element.classList.toggle("dark-mode");
        if (mod == true ){
            Cookies.set('skin', 'ligth', { expires: 365 })
        }else{
            Cookies.set('skin', 'dark', { expires: 365 })
        }
    };

    /**
     * Return objects assigned to module
     */
    return {
        initEnded:function(){
            _getEndedEvent();
        },
        initGlobal: function () {
            _ajaxSetup();
        },
        initActiveNavbar: function () {
            _activeNavbar();
        },
        initCarouselVideos: function () {
            _loadCarouselVideos();
        },
        initLoadVideoFromCarousel: function () {
            _loadVideoFromCarousel();
        },
        initShareLink: function () {
            _shareLink();
        },
        initToTopFunction: function () {
            _toTopFunction();
        },
        initScrollFunction: function () {
            window.onscroll = function () {
                _scrollFunction()
            };
        },
        initScrollMenu: function () {
            _scrollMenu();
        },
        initDarkMode:function(){
            darkMorde();
        }

    }
}();

// When content is loaded
/*document.addEventListener('DOMContentLoaded', function() {

});*/

// When page is fully loaded
window.addEventListener('load', function () {
    App.initGlobal();
    App.initActiveNavbar();
    App.initCarouselVideos();
    App.initLoadVideoFromCarousel();
    App.initShareLink();
    App.initToTopFunction();
    App.initScrollFunction();
    App.initScrollMenu();

    let dark = document.getElementById('dark');
    let element = document.body;
    let cook =Cookies.get('skin');

    if (cook == 'dark' ){
        element.classList.add("dark-mode");
    }
    dark.addEventListener('click', function (event) {
        event.preventDefault();
        App.initDarkMode();
    }, false);




    var iframe = $('.image_Container iframe');
    console.log(iframe.length);
    iframe.each( function() {
        var player = $f( $(this)[0] );
        // When the player is ready, add listeners for pause, finish, and playProgress
    console.log(player)

    } );
});
