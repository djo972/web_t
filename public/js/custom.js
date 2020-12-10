/**
 * Format dates to be shown in the following format ('d/m/Y')
 *
 * @param timestamp
 *
 * @returns string formatted date
 */
function formatDate(timestamp) {
    var date = (new Date(timestamp * 1000));
    var day = date.getDate().toString().length > 1 ? date.getDate() : '0' + date.getDate();
    var month = date.getMonth() + 1;
    month = month.toString().length > 1 ? month : '0' + month;

    return day + '-' + month + '-' + date.getFullYear();
}

/**
 * Handler for confirm password
 *
 * @param event
 *
 * @returns void
 */

function confirmPassHandler(evt) {
    var pass = document.getElementById('pass').value;
    if (pass.length > 0) {
        var idx = 0;
        while (evt.target.value.charAt(idx) !== '' && evt.target.value.charAt(idx) === pass.charAt(idx)) {
            idx++;
        }
        if (idx !== evt.target.value.length || evt.target.value.length !== pass.length) {
            evt.target.classList.add('is-invalid');
            evt.target.parentNode.querySelector('.error').textContent = messages.error_confirm_password;
        } else {
            evt.target.classList.remove('is-invalid');
            evt.target.parentNode.querySelector('.error').textContent = "";
        }
    }
}

$(document).ready(function () {

    /**
     * get the csrf token in ajax
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $('#description').summernote({
        lang: 'fr-FR', // default: 'en-US'
        height: 300,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true                  // set focus to editable area after initializing summernote
    });

    $('.input-datepicker').datepicker({
        maxViewMode: 0,
        language: "fr",
        autoclose: true,
        disableTouchKeyboard: true
    });

    $('.select-multiple-drag').select2({
        containerCssClass: 'sortable-target'
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $('.color-box').on('click',  function (event) {
            let color= $(this).text();
            console.log(color);
            $('#class_css').val(color);
    });

});