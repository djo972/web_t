
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
            toastr["success"](apiResponseMessages.THEME + ' ' + apiResponseMessages[response.message]);
            loadItemsTheme();
            $('#addTheme').modal('hide');
        },
        error: function (error) {
            $.each(error.responseJSON.errors, function (name, value) {
                $('#' + name + ' + .error').html(value[0]);
            });

            if (error.responseJSON.error) {
                toastr["error"](apiResponseMessages[error.responseJSON.error]);
            } else {
                toastr["error"](messages.error_submit_form);
            }
        }
    });
}

function loadItemsTheme(search) {
    $.ajax({
        type: 'GET',
        url: '/bo/themes',
        data: {'search': search},
        dataType: 'json',
        cache: false,
        beforeSend: function () {
            $('.ajax-load').show();
        },
        success: function (response) {
            var listItems = $('#list_items_theme');
            var count = 0;
            listItems.empty();
            if(response != ''){
                $.each(response, function (index, value) {
                    var showAtHome = 'fa-eye';
                    var buttonShowAtHome = '';
                    count++;
                    if (value['is_visible'] == 0) {
                        showAtHome = '';
                        buttonShowAtHome = "<button data-activate='1' data-url='/bo/theme/showAtHome/" + value['id'] + "' class='showAtHome'><i class='fa fa-eye-slash' aria-hidden='true'></i></button>";
                    }else {
                        buttonShowAtHome = "<button data-activate='0' data-url='/bo/theme/showAtHome/" + value['id'] + "' class='showAtHome'><i class='fa fa-eye' aria-hidden='true'></i></button>";
                    }

                    listItems.append("<li id='" + value['id'] + "' class='list-unstyled ui-sortable-handle'><div class='row no-gutters'>" +
                        "<div class='col-xs-6 col-sm-2 col-img'><img src='" + imagePath + '/' + value['icon'] + "' class='picto'></div>" +
                        "<div class='col-xs-6 col-sm-7 col-title font-weight-bold'>" + value['name'] + "</div>" +
                        "<div class='col-xs-0 col-sm-3 col-action text-right'>" +
                        "<ul class='list-inline list_button'>" +
                        "<li>" + buttonShowAtHome + "</li>" +
                        "<li><button data-url='/bo/theme/" + value['id'] + "' class='update' ><i class='fa fa-pencil-square' aria-hidden='true'></i></button></li>" +
                        "<li><button data-url='/bo/theme/" + value['id'] + "' class='delete'><i class='fa fa-trash-o' aria-hidden='true'></i></button></li>" +
                        "</ul>" +
                        "</div></li>");
                });
                $('.ajax-load').hide();
            } else {
                $('.ajax-load').hide();
                listItems.append("<div class='alert alert-danger'>" + messages.alert_empty_theme + "</div>");
            }

        },
        error: function () {
            $('.ajax-load').hide();
        }
    });

}

function ShowIcon(fileName) {
    var $showPreview = $('#showIcon');
    var content = '';

    if (fileName == '') {
        $showPreview.html(messages.file_upload_empty);
    } else {
        content = "<span>" + messages.label_file_name + "<span class='text-primary'> " + fileName + "</span></span></span><img src='" + imagePath + '/' + fileName + "' ></div>";
        $showPreview.html(content);
    }
}

$('#icon').on('change', function (event) {
    if (event.target.files[0] != '') {
        $('#showIcon').html("<span>" + messages.label_file_name + "<span class='text-primary'> " + event.target.files[0].name + "</span></span></span><img src='" + URL.createObjectURL(event.target.files[0]) + "' class='screen'></div>");
    }
});

$(document).ready(function () {

    var $list_items_theme = $('#list_items_theme');
    loadItemsTheme();

    $("#search_theme").on('keyup keypress', function () {
        var minLength = 3;
        var searchRequest = null;
        var value = $(this).val();

        if (value.length >= minLength) {
            if (searchRequest != null) {
                searchRequest.abort();
            }
            loadItemsTheme(value);
        } else {
            loadItemsTheme();
        }

    });

    $('#addTheme form').on('submit', function (event) {
        event.preventDefault();
        var $themeModal = $('#addTheme');
        $themeModal.find('form span.error').html('');
        var method = $(this).attr("method");
        var url = $(this).attr("action");
        var data = new FormData($(this)[0]);
        submitForm(method, url, data);
    });

    $('.btn-add-theme').on('click', function () {
        var $themeModal = $('#addTheme');
        $themeModal.find('form span.error').html("");
        $themeModal.find('form')[0].reset();
        $themeModal.find('form').attr({"action": "/bo/theme", "method": "post"});
        $themeModal.find('#edit-theme').remove();
        ShowIcon('');
        $('#themeModalLabel').text(messages.modal_theme_add);
        _ajaxLoadThemes('#fillerListThemes');
    });


    $list_items_theme.on('click', 'button.update', function (event) {
        event.preventDefault();
        var $themeModal = $('#addTheme');
        var url = $(this).data('url');
        $themeModal.find('form span.error').html("");
        $themeModal.find('form')[0].reset();
        $('#themeModalLabel').text(messages.modal_theme_update);
        _ajaxLoadThemes('#fillerListThemes');
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $themeModal.find('form').attr({"action": "/bo/theme/" + response.id, "method": "post"});
                $themeModal.modal('show');
                $("#name").val(response.name);
                $('select[name=theme_parent]').val(response.theme_parent);
                $("#class_css").val(response.class_css);
                ShowIcon(response.icon);
                $('#is_visible input').removeAttr('checked');
                $('input[name=is_visible][value=' + response.is_visible + ']').prop('checked', true);
                $themeModal.find('form').prepend($('<input>').attr({
                    type: 'hidden',
                    id: 'edit-theme',
                    name: '_method',
                    value: 'PUT'
                }));
            },
            error: function (response) {
                toastr["error"](messages.error);
            }
        });
    });

    $list_items_theme.on('click', 'button.delete', function (event) {
        event.preventDefault();
        var url = $(this).data('url');

        $.confirm({
            icon: 'fa fa-warning',
            title: messages.title_delete_alert,
            content: messages.content_delete_alert_theme,
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
                                loadItemsTheme();
                                toastr["success"](apiResponseMessages.THEME + ' ' + apiResponseMessages[response.message]);
                            },
                            error: function (response) {
                                //console.log(response);
                                toastr["error"](apiResponseMessages[response.responseJSON.message]);
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

    $list_items_theme.on('click', 'button.showAtHome', function (event) {
        event.preventDefault();
        var self = $(this);
        var url = $(this).data('url');
        $.ajax({
            type: 'PUT',
            url: url,
            data:{enabled : self.data('activate')},
            dataType: 'json',
            success: function (response) {
                loadItemsTheme();
                toastr["success"](apiResponseMessages.THEME + ' ' + apiResponseMessages[response.message]);
            },
            error: function (error) {
                if (error.responseJSON.error) {
                    toastr["error"](apiResponseMessages[error.responseJSON.error]);
                } else {
                    toastr["error"](messages.error);
                }
            }
        });
    });

    $list_items_theme.sortable({
        update: function () {
            var orderArray = [];

            $(this).children().each(function (i) {
                var li = $(this);
                orderArray['' + i + ''] = li.attr("id");
            });
            $.ajax({
                url: '/bo/theme/sort',
                method: 'post',
                data: {orderArray: orderArray},
                dataType: 'json',
                success: function (response) {
                    toastr["success"](apiResponseMessages.THEME + ' ' + apiResponseMessages[response.message]);
                }
            });

        }
    });

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
                $(select).empty();
                $(select).append('<option value="">' + messages.select_themesparent + '</option>');
                $.each(data, function (index, value) {
                    $(select).append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }


});