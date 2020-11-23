function loadCarouselVideos(url){
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            contentType: 'application/json',
            success: function (response) {
                var $listVideos = $('#listVideos');
                var carouselData = '';
                var active = '';
                $listVideos.find('.mcs-horizontal-example').html('');
                getFirstVideo(response.data[0]);
                $.each(response.data, function (index, value) {
                    var filePathImage = baseUrl +'/uploads/images/'+ value.preview;
                    if(index == 0){
                        active = 'active_image';
                    }else {
                        active = '';
                    }
                    carouselData += "<div class='item' data-id='" + value.id+"'><img class='item_video "+active+"' alt='"+ value.name+"' src='"+ filePathImage+"'/><h2>" + value.name+"</h2></div>" ;
                });
                $listVideos.find('.mcs-horizontal-example').html(carouselData);

            },
            error: function (response) {
                $('.container_video').html("<div id='notfound'><div class='notfound'><div class='notfound-404'></div><h1>Oops!</h1><p>"+messages.video_not_found+"</p><a href='/'>"+messages.back_home+"</a></div></div>");
            },
            complete: function () {
                var page = 1;
                $(".mcs-horizontal-example").mCustomScrollbar({
                    axis:"x",
                    theme:"dark-3",
                    horizontalScroll:true,
                    advanced:{ autoExpandHorizontalScroll:true },
                    callbacks:{
                        onTotalScroll:function(){
                            page++;
                            loadMoreData(page)
                        },
                        ondrag:function ($item, position) {
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
}
function loadMoreData(page){
    $.ajax(
        {
            url: '?page=' + page,
            type: "get",
        })
        .done(function(response)
        {
            var carouselData = '';
            $.each(response.data, function (index, value) {
                var filePathImage = baseUrl +'/uploads/images/'+ value.preview;
                carouselData += "<div class='item' data-id='" + value.id+"'><img class='item_video' alt='"+ value.name+"' src='"+ filePathImage+"'/><h2>" + value.name+"</h2></div>" ;
            });
            $(".mcs-horizontal-example #mCSB_1_container").append(carouselData);

        });
}
function getFirstVideo(response){
    var linkPost = '';
    if(response.preview) {
        linkPost = baseUrl + '/images/' + response.preview;
    }
    var linkVideo = '';
    if(response.video_file){
        linkVideo = baseUrl+'/streamVideo/'+ response.video_file;
    }else if(response.link){
        linkVideo = baseUrl+'/streamVideo/'+ response.link;
    }
    if(response.description != ''){
        shortText = $.trim(response.description).substring(0, 400)
            .split(" ").slice(0, -1).join(" ") + " ...";
    }
    $(".bloc_video_theme").html("<div class='image_Container'><video id='video-player' class='video-js vjs-default-skin' controls preload='auto' data-setup='{}' poster='"+ linkPost +"'><source src='"+ linkVideo +"' type='video/mp4' /><p class='vjs-no-js'>To view this video please enable JavaScript, and consider upgrading to a web browser that<a href='http://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a></p></video></div>");
    $(".description_video").html(shortText);
    $('h1').html(response.name);
    if(response.is_shareable == 1){
        $('.share_links').show();
    }else {
        $('.share_links').hide();
    }
}
$(document).ready(function () {

    var url = window.location.href;
    loadCarouselVideos(url);
    $( "#listLinks li" ).each(function( index ) {
        if( $( this ).find('a').attr('href') == url){
            $( this ).find('a').addClass('active_navbar_li');
        }
    });

    $('#listVideos').on('click', '.item', function () {
        var id = $(this).data('id');
        var url = '/video/'+id;
        var shortText = '';
        var self = $(this);
        $('#listVideos').find('img').removeClass('active_image');
        var linkPost = '';
        var linkVideo = '';

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                self.find('img').addClass('active_image');
                if(response.preview) {
                    linkPost = baseUrl + '/images/' + response.preview;
                }

                if(response.video_file){
                    linkVideo = baseUrl+'/streamVideo/'+ response.video_file;
                } else if(response.link){
                    linkVideo = baseUrl+'/streamVideo/'+ response.link;
                }

                if(response.description != ''){
                    shortText = $.trim(response.description).substring(0, 400)
                        .split(" ").slice(0, -1).join(" ") + " ...";
                }
                $(".bloc_video_theme").html("<div class='image_Container'><div class='image_Container'><video id='video-player' class='video-js vjs-default-skin' controls preload='auto' data-setup='{}' poster='"+ linkPost +"'><source src='"+ linkVideo +"' type='video/mp4'/><p class='vjs-no-js'>To view this video please enable JavaScript, and consider upgrading to a web browser that<a href='http://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a></p></video></div></div>");
                $(".description_video").html(shortText);
                $('h1').html(response.name);
                if(response.is_shareable == 1){
                    $('.share_links').show();
                }else {
                    $('.share_links').hide();
                }

            },
            error: function (response) {
                console.log('error' + response);
            }
        });
    });

    $(".share_links").jsSocials({
        shareIn: "popup",
        showLabel: false,
        shares: [{
            share: "twitter",
            logo: "../images/icons8-twitter-24.png"
        },{
            share: "facebook",
            logo: "../images/icons8-facebook-24.png"
        }, {
            share: "instagram",
            logo: "../images/icons8-instagram-24.png"
        }],
    });


});
