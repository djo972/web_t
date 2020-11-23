'use strict';

var Video = function () {

    var page = 1;
    var $videoModal = $('#addVideo');
    var $list_items_video = $('#list_items_video');
    var $filerByTheme = $('#fillerListThemes');
    var $search = $("#search_video");
    var baseUrl = $('meta[name="_base_url"]').attr('content');
    var lastPage = '';

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

    var _formattingItemVideo = function (idItem, name, screen, isVisible, isShareable) {
        return "<li id='" + idItem + "' data-url='/bo/video/" + idItem + "' class='list-unstyled default'><div class='row no-gutters align-items-center'>" +
            "<div class='col-xs-3 col-sm-4 col-img'><img src='" + imagePath + '/' + screen + "' class='screen'></div>" +
            "<div class='col-xs-9 col-sm-5 col-title font-weight-bold'>" + name + "</div>" +
            "<div class='col-xs-0 col-sm-3 col-action text-right align-self-start'>" +
            "<ul class='list-inline list_button'>" +
            "<li><button data-url='/bo/video/showAtHome/" + idItem + "' class='showAtHome'><i class='fa " + isVisible + "' aria-hidden='true'></i></button></li>" +
            "<li><button data-url='/bo/video/showShareLinks/" + idItem + "' class='showShareLinks " + isShareable + "'><i class='fa fa-share-alt' aria-hidden='true'></i></button></li>" +
            "<li><button data-url='/bo/video/" + idItem + "' class='update' ><i class='fa fa-pencil-square' aria-hidden='true'></i></button></li>" +
            "<li><button data-url='/bo/video/" + idItem + "' class='delete'><i class='fa fa-trash-o' aria-hidden='true'></i></button></li>" +
            "</ul>" +
            "</div></li>";
    };

    var _ajaxSubmitForm = function (method, url, data) {
        $.ajax({
            type: method,
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                toastr.remove();
                toastr["success"](apiResponseMessages.VIDEO + ' ' + apiResponseMessages[response.message]);
                _ajaxLoadVideos($search.val(), $filerByTheme.val());
                $('#addVideo').modal('hide');
            },
            error: function (response) {
                toastr.remove();
                toastr["error"](messages.error_submit_form);
                $.each(response.responseJSON.errors, function (name, value) {
                    $('.' + name + '_error').html(value[0]);
                });
            }
        });
    }

    var _ajaxLoadVideos = function (search, themeId) {
        $.ajax({
            type: 'GET',
            url: '/bo/videos',
            cache: false,
            data: {
                search: search,
                themeId: themeId
            },
            dataType: 'json',
            beforeSend: function () {
                $('.ajax-load').show();
            },
            success: function (response) {
                var $list_items_video = $('#list_items_video');
                $list_items_video.empty();
                if (response.data != '') {
                    $.each(response.data, function (index, value) {
                        var isVisible = 'fa-eye';
                        var isShareable = '';
                        var screen = '';

                        if (value['is_visible'] == 0) {
                            isVisible = 'fa-eye-slash';
                        }
                        if (value['is_shareable'] == 0) {
                            isShareable = 'text-muted';
                        }
                        if (value['preview'] == '' || value['preview'] == null) {
                            screen = 'video-screen.jpg';
                        } else {
                            screen = value['preview'];
                        }

                        $list_items_video.append(_formattingItemVideo(value['id'], value['name'], screen, isVisible, isShareable));
                        $('.ajax-load').hide();
                        lastPage = response.last_page;
                    });
                } else {
                    $list_items_video.append("<div class='alert alert-danger'>" + messages.alert_empty_videos + "</div>");
                    $('.ajax-load').hide();
                }
            }

        });
    }

    var _loadMoreVideos = function (page) {
        $.ajax(
            {
                url: '/bo/videos',
                type: "get",
                cache: false,
                data: {
                    page: page,
                    themeId: $filerByTheme.val(),
                    search: $search.val()
                },
                beforeSend: function () {
                    $('.ajax-load-more').show();
                }
            })
            .done(function (response) {
                lastPage = response.last_page;
                if (response.data) {
                    $.each(response.data, function (index, value) {
                        var isVisible = 'fa-eye';
                        var isShareable = '';
                        var screen = '';

                        if (value['is_visible'] == 0) {
                            isVisible = 'fa-eye-slash';
                        }
                        if (value['is_shareable'] == 0) {
                            isShareable = 'text-muted';
                        }
                        if (value['preview'] == '' || value['preview'] == null) {
                            screen = 'video-screen.jpg';
                        } else {
                            screen = value['preview'];
                        }

                        $list_items_video.append(_formattingItemVideo(value['id'], value['name'], screen, isVisible, isShareable));
                    });
                } else {
                    $list_items_video.append("<div class='alert alert-danger'>" + messages.alert_no_more_videos + "</div>");
                }
                $('.ajax-load-more').hide();
            });

    }

    var _paginateVideoByScroll = function () {
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
               /* if(page == 1){
                    _loadMoreVideos(page);
                }*/
                page++;
                if(page > 1 && page <= lastPage){
                    _loadMoreVideos(page);
                }

            }
        });
    }

    var _ajaxLoadThemes = function (select) {
        if(select == null){
            select = '.select-multiple-drag';
        }
        $.ajax({
            method: 'get',
            url: '/bo/theme/list',
            dataType: 'json',
            cache: false,
        }).done(function (data) {
            if (data && data != null) {
                $.each(data, function (index, value) {
                    $(select).append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    var _showScreenVideo = function (fileName) {
        var $showScreenVideo = $('#showScreenVideo');
        var content = '';

        if (fileName != '') {
            content = "<span class='icon_video'><i class='fa fa-file-video-o fa-3x' aria-hidden='true'></i></span><span class='name_video text-primary'> " + fileName + "</span>";
            $showScreenVideo.html(content);
        }
    }

    var _showScreenImage = function (fileName) {
        var $showPreview = $('#showPreview');
        var content = '';

        if (fileName == '') {
            $showPreview.html(messages.file_upload_empty);
        } else {
            content = "<span class='mr-auto p-2'>" + messages.label_file_name + "<span class='text-primary'> " + fileName + "</span></span></span><img src='" + imagePath + '/' + fileName + "' ></div>";
            $showPreview.html(content);
        }
    }


    // Method to load on document
    var _onChangeLoadPreviewImage = function () {
        $('#preview').on('change', function (event) {
            if (event.target.files[0] != '') {
                $('#showPreview').html("<span>" + messages.label_file_name + "<span class='text-primary'> " + event.target.files[0].name + "</span></span></span><img src='" + URL.createObjectURL(event.target.files[0]) + "' class='screen'></div>");
            }
        });
    }

    var _selectVideoOrLink = function () {
        $('input[type=radio][name=linkOrVideo]').change(function () {
            if (this.value == 0) {
                $('#showLink').addClass('d-block').removeClass('d-none');
                $('#showVideo').removeClass('d-block').addClass('d-none');
            }
            else if (this.value == 1) {
                $('#showLink').addClass('d-none').removeClass('d-block');
                $('#showVideo').removeClass('d-none').addClass('d-block');
            }
        });
    }

    var _loadVideos = function () {
        _ajaxLoadVideos($search.val(), $filerByTheme.val());
    }

    var _loadThemes = function () {
        _ajaxLoadThemes('#fillerListThemes');
    }

    var _filterVideosByTheme = function () {
        $filerByTheme.on('change', function () {
            page = 1;
            _ajaxLoadVideos($search.val(), this.value);
            $list_items_video.sortable('enable');
        });
    }

    var _filterVideoByName = function () {
        $search.on('keyup keypress', function () {
            var minLength = 3;
            var searchRequest = null;
            var value = $(this).val();

            if (value.length >= minLength) {
                if (searchRequest != null) {
                    searchRequest.abort();
                }
                _ajaxLoadVideos(value, $filerByTheme.val());
            } else {
                _ajaxLoadVideos(null, $filerByTheme.val());
            }

        });
    }

    var _submitForm = function () {
        $('#addVideo form').on('submit', function (event) {
            event.preventDefault();
            toastr["warning"](apiResponseMessages.UPLOADING_VIMEO, messages.quit_page_warning, {timeOut: 0, extendedTimeOut: 0});
            document.getElementById("toast-container").classList.add("nopacity");
            var $videoModal = $('#addVideo');
            $videoModal.find('form span.error').html('');
            var method = $(this).attr("method");
            var url = $(this).attr("action");
            var data = new FormData($(this)[0]);
            _ajaxSubmitForm(method, url, data);
        });
    }

    var _createVideo = function () {
        $('.btn-add-video').on('click', function () {
            var $videoModal = $('#addVideo');
            $videoModal.find('form span.error').html("");
            $videoModal.find('form')[0].reset();
            $videoModal.find('form').attr({"action": "/bo/video", "method": "post"});
            $('#edit-video').remove();
            $( '#change_file' ).val(0);
            $('#description').summernote('code', '');
            $(".select-multiple-drag").html('').select2({data: {id: null, text: null}});
            _showScreenImage('');
            _ajaxLoadThemes();
            //_loadInputVideo(0);
            $('#filelist').html('');
            $('#console').html('');
            $('#showScreenVideo').html('');
            $('#videoModalLabel').text(messages.modal_video_add);
            $videoModal.modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    }

    var _updateVideo = function () {
        var changeVideo = '';
        $list_items_video.on('click', 'button.update', function (event) {
            event.preventDefault();
            event.stopPropagation();

            var url = $(this).data('url');
            $videoModal.find('form span.error').html("");
            $videoModal.find('form')[0].reset();
            $('#description').summernote('destroy');
            $('#videoModalLabel').text(messages.modal_video_update);
            _ajaxLoadThemes();
            $('#filelist').html('');
            $('#console').html('');
            $('#showScreenVideo').html('');
            $(".select-multiple-drag").html('').select2({data: {id: null, text: null}});
            $('#edit-video').remove();
            $( '#change_file' ).val(0);
            $videoModal.modal({
                backdrop: 'static',
                keyboard: false
            });
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function (response) {
                    $videoModal.find('form').attr({"action": "/bo/video/" + response.id, "method": "post"});
                    $videoModal.modal('show');
                    var selectedValues = [];
                    $.each(response.themes, function (index, value) {
                        selectedValues[index] = value.id;
                    });
                    $(".select-multiple-drag").val(selectedValues).trigger('change');
                    $("#name").val(response.name);
                    $('input[name=linkOrVideo]').attr('checked', false);
                    if(response.video_file != null){
                        _showScreenVideo(response.name);
                        changeVideo = response.video_file;
                        $("#video_file").val(changeVideo);
                    }
                    _showScreenImage(response.preview);
                    $('#description').summernote('code', response.description);
                    //$("#order").val(response.order);
                    $('#is_visible input').removeAttr('checked');
                    $('input[name=is_visible][value=' + response.is_visible + ']').prop('checked', true);
                    $('#is_shareable input').removeAttr('checked');
                    $('input[name=is_shareable][value=' + response.is_shareable + ']').prop('checked', true);
                    $videoModal.find('form').prepend($('<input>').attr({
                        type: 'hidden',
                        id: 'edit-video',
                        name: '_method',
                        value: 'put'
                    }));
                },
                error: function (response) {
                    toastr["error"](messages.error);
                }
            });
        });

        $videoModal.on('click', '#pickfiles', function () {
            $( '#change_file' ).val(1);
        });
    }

    var _deleteVideo = function () {
        $list_items_video.on('click', 'button.delete', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var url = $(this).data('url');
            var $row = $(this).closest('li.default');
            $.confirm({
                icon: 'fa fa-warning',
                title: messages.title_delete_alert,
                content: messages.content_delete_alert_video,
                type: 'red',
                typeAnimated: true,
                buttons: {
                    confirm: {
                        text: messages.confirm,
                        btnClass: 'btn-red', // multiple classes.
                        action: function () {
                            $.ajax({
                                type: 'delete',
                                url: url,
                                success: function (response) {
                                    $row.fadeOut('normal', function () {
                                        $(this).remove();
                                    });
                                    toastr["success"](apiResponseMessages.VIDEO + ' ' + apiResponseMessages[response.message]);
                                },
                                error: function (response) {
                                    toastr["error"](messages.error);
                                }
                            });
                        },
                    },
                    cancel: {
                        text: messages.cancel,
                        action: function () {

                        }
                    },
                }
            });
        });
    }

    var _showAtHome = function () {
        $list_items_video.on('click', 'button.showAtHome', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var url = $(this).data('url');
            var self = $(this);
            $.ajax({
                type: 'PUT',
                url: url,
                success: function (response) {
                    if (self.find('i').hasClass('fa-eye-slash')) {
                        self.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                    } else {
                        self.find('i').addClass('fa-eye-slash').removeClass('fa-eye');
                    }
                    toastr["success"](apiResponseMessages.VIDEO + ' ' + apiResponseMessages[response.message]);
                },
                error: function (response) {
                    toastr["error"](messages.error);
                }
            });
        });
    }

    var _enabledShareLink = function () {
        $list_items_video.on('click', 'button.showShareLinks', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var url = $(this).data('url');
            var self = $(this);

            $.ajax({
                type: 'PUT',
                url: url,
                success: function (response) {
                    if (self.hasClass('text-muted')) {
                        self.removeClass('text-muted');
                    } else {
                        self.addClass('text-muted');
                    }
                    toastr["success"](apiResponseMessages.SHARE + ' ' + apiResponseMessages[response.message]);
                },
                error: function (response) {
                    toastr["error"](messages.error);
                }
            });
        });
    }

    var _actionDetailsVideo = function () {
        $list_items_video.on('click', 'li', function (event) {
            var url = $(this).data('url');
            window.location.href = url;
            $(this).closest('li').addClass('selected');
        });
    }

    var _sortVideosByTheme = function () {
        $list_items_video.sortable({
            update: function () {
                var orderArray = [];
                var themeId = $filerByTheme.val();

                $(this).children().each(function (i) {
                    var li = $(this);
                    orderArray['' + i + ''] = li.attr("id");
                });
                $.ajax({
                    url: '/bo/video/ordering',
                    method: 'POST',
                    data: {orderArray: orderArray, themeId: themeId},
                    success: function (response) {
                        // toastr["success"](apiResponseMessages.VIDEO + ' ' + apiResponseMessages[response.message]);
                    }
                });
            }
        });
    }

    var _disabledSort = function () {
        $list_items_video.sortable('disable');
    }

    /**
     * Return objects assigned to module
     */
    return {

        initGlobal: function () {
            _ajaxSetup();
        },
        initLoadVideos: function () {
            _loadVideos();
        },
        initLoadThemes: function () {
            _loadThemes();
        },
        initFilterVideosByTheme: function () {
            _filterVideosByTheme();
        },
        initFilterVideoByName: function () {
            _filterVideoByName();
        },
        initSubmitForm: function () {
            _submitForm();
        },
        initCreateVideo: function () {
            _createVideo();
        },
        initUpdateVideo: function () {
            _updateVideo();
        },
        initDeleteVideo: function () {
            _deleteVideo();
        },
        initShowAtHome: function () {
            _showAtHome();
        },
        initShareLink: function () {
            _enabledShareLink();
        },
        initGoDetailsVideo: function () {
            _actionDetailsVideo();
        },
        initSortVideosByTheme: function () {
            _sortVideosByTheme();
        },
        initPaginateVideoByScroll: function () {
            _paginateVideoByScroll();
        },
        initDisabledSort: function () {
            _disabledSort();
        },
        initLoadPreviewImage: function () {
            _onChangeLoadPreviewImage();
        },
        initSelectVideoOrLink: function () {
            _selectVideoOrLink();
        },

    }
}();


// When content is loaded
/*document.addEventListener('DOMContentLoaded', function() {

});*/

// When page is fully loaded
window.addEventListener('load', function () {
    Video.initGlobal();
    Video.initLoadVideos();
    Video.initLoadThemes();
    Video.initFilterVideosByTheme();
    Video.initFilterVideoByName();
    Video.initSubmitForm();
    Video.initCreateVideo();
    Video.initUpdateVideo();
    Video.initDeleteVideo();
    Video.initShowAtHome();
    Video.initShareLink();
    Video.initGoDetailsVideo();
    Video.initSortVideosByTheme();
    Video.initPaginateVideoByScroll();
    Video.initLoadPreviewImage();
    Video.initSelectVideoOrLink();
    Video.initDisabledSort();
    $('#description').summernote({ height: 300, placeholder: 'Enter your description here...', });
    $('#description').on("summernote.paste", function (e, ne) {
        var bufferText = ne.originalEvent.clipboardData.getData('Text');
        ne.preventDefault();
        setTimeout(function () {
            document.execCommand('insertText', false, bufferText);
        }, 10);
    });
});
