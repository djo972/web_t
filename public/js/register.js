var form = document.getElementById('formContent').querySelector('form');

window.addEventListener('load', function () {
    document.getElementById('pass').onkeyup = function () {
        document.getElementById('confirm_pass').value = '';
    }
    document.getElementById('confirm_pass').onkeyup = confirmPassHandler;
    form.onsubmit = function (evt) {
        evt.preventDefault();
        var pass = document.getElementById('pass').value;
        if (pass && pass === document.getElementById('confirm_pass').value) {
            form.submit();
        }
    };
});