'use strict';

function submitForm(method, url, data) {
    $.ajax({
        type: method,
        url: url,
        data: data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            toastr["success"](apiResponseMessages.VIDEO + ' ' + apiResponseMessages[response.message]);
            loadItemsVideo($("#search_video").val(), $('#fillerListThemes').val());
            $('#addVideo').modal('hide');
        },
        error: function (response) {
            toastr["error"](messages.error_submit_form);
            $.each(response.responseJSON.errors, function (name, value) {
                $('.' + name + '_error').html(value[0]);
            });
        }
    });
}

function showScreenImage(fileName) {
    var $showPreview = $('#showPreview');
    var content = '';

    if (fileName == '') {
        $showPreview.html(messages.file_upload_empty);
    } else {
        content = "<span class='mr-auto p-2'>" + messages.label_file_name + "<span class='text-primary'> " + fileName + "</span></span></span><img src='" + imagePath + '/' + fileName + "' ></div>";
        $showPreview.html(content);
    }
}

function ShowScreenVideo(fileName) {
    var $showScreenVideo = $('#showScreenVideo');
    var content = '';

    if (fileName != '') {
        content = "<span class='icon_video'><i class='fa fa-file-video-o fa-3x' aria-hidden='true'></i></span><span class='name_video text-primary'> " + fileName + "</span>";
        $showScreenVideo.html(content);
    }
}

$('#preview').on('change', function (event) {
    if (event.target.files[0] != '') {
        $('#showPreview').html("<span>" + messages.label_file_name + "<span class='text-primary'> " + event.target.files[0].name + "</span></span></span><img src='" + URL.createObjectURL(event.target.files[0]) + "' class='screen'></div>");
    }
});

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

function loadInputVideo(linkOrVideo) {
    if (linkOrVideo == 0) {
        $('#showLink').addClass('d-block').removeClass('d-none');
        $('#showVideo').removeClass('d-block').addClass('d-none');
    } else {
        $('#showLink').addClass('d-none').removeClass('d-block');
        $('#showVideo').removeClass('d-none').addClass('d-block');
    }
}

function loadItemsVideo(search = null, themeId = null) {
    $.ajax({
        type: 'GET',
        url: '/bo/videos',
        data: {
            search: search,
            themeId: themeId
        },
        dataType: 'json',
        success: function (response) {
            var $list_items_video = $('#list_items_video');
            $list_items_video.empty();
            if (response.data) {
                $.each(response.data, function (index, value) {
                    var isVisible = '';
                    var isShareable = '';
                    var screen = '';

                    if (value['is_visible'] == 0) {
                        isVisible = 'text-muted';
                    }
                    if (value['is_shareable'] == 0) {
                        isShareable = 'text-muted';
                    }
                    if (value['preview'] == '' || value['preview'] == null) {
                        screen = 'video-screen.jpg';
                    } else {
                        screen = value['preview'];
                    }

                    $list_items_video.append("<li id='" + value['id'] + "' data-url='/bo/video/" + value['id'] + "' class='list-unstyled default'><div class='row no-gutters align-items-center'>" +
                        "<div class='col-3'><img src='" + imagePath + '/' + screen + "' class='screen'></div>" +
                        "<div class='col-5 font-weight-bold'>" + value['name'] + "</div>" +
                        "<div class='col-4 text-right align-self-start'>" +
                        "<ul class='list-inline list_button'>" +
                        "<li><button data-url='/bo/video/showAtHome/" + value['id'] + "' class='showAtHome " + isVisible + "'><i class='fa fa-eye' aria-hidden='true'></i></button></li>" +
                        "<li><button data-url='/bo/video/showShareLinks/" + value['id'] + "' class='showShareLinks " + isShareable + "'><i class='fa fa-share-alt' aria-hidden='true'></i></button></li>" +
                        "<li><button data-url='/bo/video/" + value['id'] + "' class='update' ><i class='fa fa-pencil-square' aria-hidden='true'></i></button></li>" +
                        "<li><button data-url='/bo/video/" + value['id'] + "' class='delete'><i class='fa fa-trash-o' aria-hidden='true'></i></button></li>" +
                        "</ul>" +
                        "</div></li>");
                });
            } else {
                $list_items_video.append("<div class='alert alert-danger'>" + messages.alert_empty_videos + "</div>");
            }
        }
    });
}


function getListThemes(select = '.select-multiple-drag') {
    $.ajax({
        method: 'get',
        url: '/bo/theme/list',
        dataType: 'json',
    }).done(function (data) {
        if (data && data != null) {
            $.each(data, function (index, value) {
                $(select).append('<option value="' + value.id + '">' + value.name + '</option>');
            });
        }
    });
}

function loadMoreVideo(page){
    var $list_items_video = $('#list_items_video');
    $.ajax(
        {
            url: '/bo/videos',
            type: "get",
            data : {
                page : page,
                themeId : $('#fillerListThemes').val(),
                search: $("#search_video").val()
            },
            beforeSend: function()
            {
                $('.ajax-load').show();
            }
        })
        .done(function(response)
        {
            if (response.data) {
                $.each(response.data, function (index, value) {
                    var isVisible = '';
                    var isShareable = '';
                    var screen = '';

                    if (value['is_visible'] == 0) {
                        isVisible = 'text-muted';
                    }
                    if (value['is_shareable'] == 0) {
                        isShareable = 'text-muted';
                    }
                    if (value['preview'] == '' || value['preview'] == null) {
                        screen = 'video-screen.jpg';
                    } else {
                        screen = value['preview'];
                    }

                    $list_items_video.append("<li id='" + value['id'] + "' data-url='/bo/video/" + value['id'] + "' class='list-unstyled default'><div class='row no-gutters align-items-center'>" +
                        "<div class='col-3'><img src='" + imagePath + '/' + screen + "' class='screen'></div>" +
                        "<div class='col-5 font-weight-bold'>" + value['name'] + "</div>" +
                        "<div class='col-4 text-right align-self-start'>" +
                        "<ul class='list-inline list_button'>" +
                        "<li><button data-url='/bo/video/showAtHome/" + value['id'] + "' class='showAtHome " + isVisible + "'><i class='fa fa-eye' aria-hidden='true'></i></button></li>" +
                        "<li><button data-url='/bo/video/showShareLinks/" + value['id'] + "' class='showShareLinks " + isShareable + "'><i class='fa fa-share-alt' aria-hidden='true'></i></button></li>" +
                        "<li><button data-url='/bo/video/" + value['id'] + "' class='update' ><i class='fa fa-pencil-square' aria-hidden='true'></i></button></li>" +
                        "<li><button data-url='/bo/video/" + value['id'] + "' class='delete'><i class='fa fa-trash-o' aria-hidden='true'></i></button></li>" +
                        "</ul>" +
                        "</div></li>");
                });
            } else {
                $list_items_video.append("<div class='alert alert-danger'>" + messages.alert_no_more_videos + "</div>");
            }
            $('.ajax-load').hide();
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
            alert('server not responding...');
        });
}

$(document).ready(function () {
    var page = 1;
    var $list_items_video = $('#list_items_video');

    getListThemes('#fillerListThemes');

    $('#fillerListThemes').on('change', function () {
        page = 1;
        loadItemsVideo($("#search_video").val(), this.value);
        $list_items_video.sortable('enable');
    });

    loadItemsVideo($("#search_video").val(), $('#fillerListThemes').val());

    $("#search_video").on('keyup keypress', function () {
        var minLength = 3;
        var searchRequest = null;
        var value = $(this).val();

        if (value.length >= minLength) {
            if (searchRequest != null) {
                searchRequest.abort();
            }
            loadItemsVideo(value, $('#fillerListThemes').val());
        } else {
            loadItemsVideo(null, $('#fillerListThemes').val());
        }

    });

    $('#addVideo form').on('submit', function (event) {
        event.preventDefault();
        var $videoModal = $('#addVideo');
        $videoModal.find('form span.error').html('');
        var method = $(this).attr("method");
        var url = $(this).attr("action");
        var data = new FormData($(this)[0]);
        submitForm(method, url, data);
    });

    $('.btn-add-video').on('click', function () {
        var $videoModal = $('#addVideo');
        $videoModal.find('form span.error').html("");
        $videoModal.find('form')[0].reset();
        $videoModal.find('form').attr({"action": "/bo/video", "method": "post"});
        $videoModal.find('#edit-video').remove();
        $('#description').summernote('code', '');
        $(".select-multiple-drag").html('').select2({data: {id: null, text: null}});
        showScreenImage('');
        getListThemes();
        loadInputVideo(0);
        $('#filelist').html('');
        $('#console').html('');
        $('#videoModalLabel').text(messages.modal_video_add);
    });

    $list_items_video.on('click', 'button.update', function (event) {
        event.preventDefault();
        event.stopPropagation();
        var $videoModal = $('#addVideo');
        var url = $(this).data('url');
        $videoModal.find('form span.error').html("");
        $videoModal.find('form')[0].reset();
        $('#description').summernote('destroy');
        $('#videoModalLabel').text(messages.modal_video_update);
        getListThemes();
        $('#filelist').html('');
        $('#console').html('');
        $(".select-multiple-drag").html('').select2({data: {id: null, text: null}});
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
                $("#link").val(response.link);
                if (response.video_file) {
                    $("#btnVideo").attr('checked', 'checked');
                    loadInputVideo(1);
                    ShowScreenVideo(response.video_file);
                } else if (response.link) {
                    $("#btnLink").attr('checked', 'checked');
                    loadInputVideo(0);
                }
                showScreenImage(response.preview);
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


    $list_items_video.on('click', 'button.showAtHome', function (event) {
        event.preventDefault();
        event.stopPropagation();
        var url = $(this).data('url');
        var self = $(this);
        $.ajax({
            type: 'PUT',
            url: url,
            success: function (response) {
                if(self.hasClass('text-muted')){
                    self.removeClass('text-muted');
                }else {
                    self.addClass('text-muted');
                }
                toastr["success"](apiResponseMessages.VIDEO + ' ' + apiResponseMessages[response.message]);
            },
            error: function (response) {
                toastr["error"](messages.error);
            }
        });
    });

    $list_items_video.on('click', 'button.showShareLinks', function (event) {
        event.preventDefault();
        event.stopPropagation();
        var url = $(this).data('url');
        var self = $(this);

        $.ajax({
            type: 'PUT',
            url: url,
            success: function (response) {
                if(self.hasClass('text-muted')){
                    self.removeClass('text-muted');
                }else {
                    self.addClass('text-muted');
                }
                toastr["success"](apiResponseMessages.SHARE + ' ' + apiResponseMessages[response.message]);
            },
            error: function (response) {
                toastr["error"](messages.error);
            }
        });
    });

    $list_items_video.on('click', 'li', function (event) {
        var url = $(this).data('url');
        window.location.href = url;
        $(this).closest('li').addClass('selected');
    });

    $list_items_video.sortable({
        update: function () {
            var orderArray = [];
            var themeId = $('#fillerListThemes').val();

            $(this).children().each(function (i) {
                var li = $(this);
                orderArray['' + i + ''] = li.attr("id");
            });
            $.ajax({
                url: '/bo/video/ordering',
                method: 'POST',
                data: {orderArray: orderArray, themeId: themeId},
                success: function (response) {
                    toastr["success"](apiResponseMessages.VIDEO + ' ' + apiResponseMessages[response.message]);
                }
            });
        }
    });


    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreVideo(page);
        }
    });

    $list_items_video.sortable('disable');

});
