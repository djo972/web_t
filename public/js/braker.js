'use strict';

var Braker = function () {

    var baseUrl = $('meta[name="_base_url"]').attr('content');
    var $modalBraker = $('#addBraker')

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
                $modalBraker.modal('hide');
                location.reload(true);
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


    var _submitForm = function () {
        $modalBraker.find('form').on('submit', function (event) {
            event.preventDefault();
            toastr["warning"](apiResponseMessages.UPLOADING_VIMEO, messages.quit_page_warning, {timeOut: 0, extendedTimeOut: 0});
            document.getElementById("toast-container").classList.add("nopacity");
            $modalBraker.find('form span.error').html('');
            var method = $(this).attr("method");
            var url = $(this).attr("action");
            var data = new FormData($(this)[0]);
            _ajaxSubmitForm(method, url, data);
        });
    }

    var _createVideo = function () {
        $('.btn-add-braker').on('click', function (event) {
            $modalBraker.find('form span.error').html("");
            $modalBraker.find('form')[0].reset();
            $modalBraker.find('form').attr({"action": "/bo/braker", "method": "POST"});
            $modalBraker.find('#edit-video').remove();
            $('#description').summernote('code', '');
            _showScreenImage('');
            $('#filelist').html('');
            $('#console').html('');
            $('#showScreenVideo').html('');
            $('#videoModalLabel').text(messages.modal_video_add);
            $modalBraker.modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    }

    var _updateVideo = function () {
        $('.btn-update-braker').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var url = $(this).data('url');
            $modalBraker.find('form span.error').html("");
            $modalBraker.find('form')[0].reset();
            $('#description').summernote('destroy');
            $('#videoModalLabel').text(messages.modal_video_update);
            $('#filelist').html('');
            $('#console').html('');
            $('#showScreenVideo').html('');
            $(".select-multiple-drag").html('').select2({data: {id: null, text: null}});
            $modalBraker.modal({
                backdrop: 'static',
                keyboard: false
            });
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function (response) {
                    $modalBraker.find('form').attr({"action": "/bo/braker/" + response.id, "method": "POST"});
                    $modalBraker.modal('show');
                    $("#name").val(response.name);
                    if(response.video_file != null){
                        _showScreenVideo(response.name);
                    }
                    $("#video_file").val(response.video_file);
                    _showScreenImage(response.preview);

                    $('#description').summernote('code', response.description);
                    $('#is_shareable input').removeAttr('checked');
                    $('input[name=is_shareable][value=' + response.is_shareable + ']').prop('checked', true);
                    $modalBraker.find('form').prepend($('<input>').attr({
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
    }

    var _enabledShareLink = function () {
        /*$list_items_video.on('click', 'button.showShareLinks', function (event) {
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
        });*/
    }

    /**
     * Return objects assigned to module
     */
    return {

        initGlobal: function () {
            _ajaxSetup();
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
        initShareLink: function () {
            _enabledShareLink();
        },
        initLoadPreviewImage: function () {
            _onChangeLoadPreviewImage();
        },

    }
}();


// When content is loaded
/*document.addEventListener('DOMContentLoaded', function() {

});*/

// When page is fully loaded
window.addEventListener('load', function () {
    Braker.initGlobal();
    Braker.initSubmitForm();
    Braker.initCreateVideo();
    Braker.initUpdateVideo();
    Braker.initShareLink();
    Braker.initLoadPreviewImage();
    $('#description').on("summernote.paste", function (e, ne) {
        var bufferText = ne.originalEvent.clipboardData.getData('Text');
        ne.preventDefault();
        setTimeout(function () {
            document.execCommand('insertText', false, bufferText);
        }, 10);
    });
});
