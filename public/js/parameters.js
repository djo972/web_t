window.addEventListener('load', function () {
    if (routeUpdate) {
        var update = function (evt) {
            var token = document.querySelector("meta[name='_token']").getAttribute("content");
            var url = routeUpdate;
            fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: "POST",
                body: JSON.stringify({
                    type: evt.target.getAttribute('data-type'),
                    update: evt.target.checked
                })
            })
            .then(res => res.json())
            .then(res => {
                toastr["success"](apiResponseMessages.PARAMETERS + ' ' + apiResponseMessages[res.message]);
            })
            .catch(res => toastr["error"](messages.error));
        };

        var iptAccess = document.getElementById("iptAccess");
        var iptPayment = document.getElementById("iptPayment");
        iptAccess.onchange = update;
        iptPayment.onchange = update;
        iptAccess.addEventListener('change', function () {
            if (this.checked) {
                iptPayment.removeAttribute('disabled');
            } else {
                iptPayment.checked = false;
                iptPayment.setAttribute('disabled', 'disabled');
            }
        });
    }
});