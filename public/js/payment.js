window.addEventListener('load', async function () {
    var form = document.getElementById('payment-form');
    var nonce = document.getElementById('nonce');
    var resu = await fetch('/token', {
        header: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    });
    resu = await resu.json();
    var client_token = resu.token;
    document.getElementById('waitForPaymentModule').style.cssText = 'display: none';
    braintree.dropin.create({
        authorization: client_token,
        container: '#dropin-container',
        paypal: {
            flow: 'vault'
        },
        locale: 'fr_FR',
        vaultManager: true,
        card: {
            cardholderName: {
                required: true
            }
        }
    }, function (createErr, instance) {
        if (createErr) {
            console.log('Create Error', createErr);
            return;
        }
        var btn = form.querySelector('button');
        btn.removeAttribute('style');
        btn.onclick = (event) => {
            instance.requestPaymentMethod(function (err, payload) {
                var msg = form.querySelector('.invalid-feedback');
                if (err) {
                    console.log('Request Payment Method Error', err);
                    msg.style.cssText = 'display: block';
                    btn.textContent = messages.validate;
                    btn.classList.remove('pay');
                    btn.setAttribute('type', 'button');
                    return;
                }
                msg.removeAttribute('style');
                nonce.value = payload.nonce;
                btn.textContent = messages.pay;
                btn.classList.add('pay');
                btn.setAttribute('type', 'submit');
            });
        };
        
        form.onsubmit = (event) => {
            event.preventDefault();
            instance.requestPaymentMethod(function (err, payload) {
                if (!err) {
                    nonce.value = payload.nonce;
                    form.submit();
                }
            });
        }
    });
});