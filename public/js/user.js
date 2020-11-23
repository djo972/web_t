window.addEventListener('load', function () {
    if (users) {
        var data = JSON.parse(users);
        var table = $('#table_id').DataTable({
            data: data,
            columns: [
                { data: "login" },
                { data: "type" },
                { data: null, defaultContent: '<ul class="list-inline list_button"><li><button class="delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button></li></ul>' }
            ],
            columnDefs: [
                { className: "dt-center", targets: "_all" }
            ],
            language: {
                processing:     "Traitement en cours...",
                search:         "Rechercher :",
                lengthMenu:     "Afficher _MENU_ éléments",
                info:           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                infoEmpty:      "Affichage de l'élément 0 à 0 sur 0 éléments",
                infoFiltered:   "(filtré de _MAX_ éléments au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun élément à afficher",
                emptyTable:     "Aucune donnée disponible dans le tableau",
                paginate: {
                    first:      "Premier",
                    previous:   "Précédent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
                aria: {
                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                },
                select: {
                    rows: {
                        0: "Aucun élément sélectionné",
                        1: "1 élément sélectionné"
                    }
                }
            },
            select: {
                selector: 'button.delete',
                style: "single"
            }
        });

        table.on('select', function (e, dt, type, instances) {
            if (type === 'row') {
                var elemToDelete = table.rows(instances).data()[0];
                document.getElementById("loginUserToDelete").textContent = elemToDelete.login;
                document.getElementById("idUserToDelete").value = elemToDelete.id;
                $("#deleteUser").modal("show");
            }
        });

        $('#deleteUser').on('hide.bs.modal', function () {
            table.rows().deselect();
        });

        var tok = document.querySelector('meta[name="_token"]').getAttribute('content');
        var headers = new Headers({
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": tok
        });

        var updateTable = async function (table, headers) {
            var getReq = await fetch(usersURL, {
                headers: headers,
                method: 'GET'
            });
            var getRes = await getReq.json();
            table.clear();
            table.rows.add(getRes);
            table.draw();
        };

        document.getElementById('deleteUser').querySelector('form').onsubmit = async function (evt) {
            try {
                evt.preventDefault();
                // Delete request
                var delReq = await fetch(userURL + '/' + document.getElementById("idUserToDelete").value, {
                    headers: headers,
                    method: 'DELETE'
                });
                var delRes = await delReq.json();
                toastr["success"](apiResponseMessages.USER + ' ' + apiResponseMessages[delRes.message]);
                $('#deleteUser').modal('hide');
                updateTable(table, headers);
            } catch (e) {
                toastr["error"](messages.error);
            }
        };

        var insert = async function (headers, formData, table, json) {
            if(json) {
                headers.append('Content-Type', 'application/json');
                formData = JSON.stringify(formData);
            }
            var insReq = await fetch(userURL, {
                headers: headers,
                method: 'POST',
                body: formData
            });
            var insRes = await insReq.json();

            console.log(insRes)
            toastr.remove();
            if (insRes.error) {
                for (var [key, val] of Object.entries(insRes.error)) {
                    var elem = document.querySelector('[name="' + key + '"]');
                    if (elem && val[0]) {
                        elem.classList.add('is-invalid');
                        elem.parentNode.querySelector('.error').textContent = val[0];
                        elem.addEventListener('keyup', function (evt) {
                            evt.target.classList.remove('is-invalid');
                            evt.target.parentNode.querySelector('.error').textContent = '';
                        });
                    }
                }
            } else {
                toastr["success"](apiResponseMessages.USER + ' ' + apiResponseMessages[insRes.message]);
                $('#addUser').modal('hide');
                // Get list of users
                headers.delete('Content-Type');
                updateTable(table, headers);
            }
        };

        var form = document.getElementById('addUser').querySelector('form');

        form.onsubmit = async function (evt) {
            evt.preventDefault();

            // try {
            //     if (document.getElementById('addOneContent').hasAttribute('style')) {
            //         console.log('der');
            //         if (document.getElementById('prefixe').value && parseInt(document.getElementById('nb').value, 10)) {
            //             toastr["warning"](apiResponseMessages.SAVING_USER, messages.quit_page_warning, {timeOut: 0, extendedTimeOut: 0});
            //             var formData = {
            //                 sendr: 'more',
            //                 prfx: document.getElementById('prefixe').value,
            //                 nmbr: document.getElementById('nb').value
            //             };
            //             if (document.getElementById('type') && document.getElementById('type').value) {
            //                 formData.typeU = document.getElementById('type').value;
            //             }
            //             insert(headers, formData, table);
            //         }
            //     }
            //     else if (document.getElementById('addMoreContent').hasAttribute('style')) {
            //         console.log('rar you')
            //         var pass = document.getElementById('pass').value;
            //         if (pass && pass === document.getElementById('confirm_pass').value) {
            //             toastr["warning"](apiResponseMessages.SAVING_USER, messages.quit_page_warning, {timeOut: 0, extendedTimeOut: 0});
            //             var formData = {
            //                 sendr: 'one',
            //                 fname: document.getElementById('fname').value,
            //                 lname: document.getElementById('lname').value,
            //                 email: document.getElementById('email').value,
            //                 passw: pass
            //             };
            //             if (document.getElementById('type') && document.getElementById('type').value) {
            //                 formData.typeU = document.getElementById('type').value;
            //             }
            //             insert(headers, formData, table);
            //         }
            //     }
            try {
                if (document.getElementById('addOneContent').classList.contains("act")) {
                    console.log('rar you')
                    var pass = document.getElementById('pass').value;
                    if (pass && pass === document.getElementById('confirm_pass').value) {
                        toastr["warning"](apiResponseMessages.SAVING_USER, messages.quit_page_warning, {timeOut: 0, extendedTimeOut: 0});
                        var formData = {
                            sendr: 'one',
                            fname: document.getElementById('fname').value,
                            lname: document.getElementById('lname').value,
                            email: document.getElementById('email').value,
                            passw: pass
                        };
                        if (document.getElementById('type') && document.getElementById('type').value) {
                            formData.typeU = document.getElementById('type').value;
                        }
                        insert(headers, formData, table, true);
                    }

                }
                else if (document.getElementById('addMoreContent').classList.contains("act")) {
                    console.log('der');
                    if (document.getElementById('prefixe').value && parseInt(document.getElementById('nb').value, 10)) {
                        toastr["warning"](apiResponseMessages.SAVING_USER, messages.quit_page_warning, {timeOut: 0, extendedTimeOut: 0});
                        var formData = {
                            sendr: 'more',
                            prfx: document.getElementById('prefixe').value,
                            nmbr: document.getElementById('nb').value
                        };
                        if (document.getElementById('type') && document.getElementById('type').value) {
                            formData.typeU = document.getElementById('type').value;
                        }
                        insert(headers, formData, table, true);
                    }
                }
                else{
                    toastr["warning"](apiResponseMessages.SAVING_USER, messages.quit_page_warning, {timeOut: 0, extendedTimeOut: 0});
                    // let file = document.getElementById('fileImport').files[0]
                    let formData = new FormData();
                    formData.append("sendr", 'import');
                    formData.append("prfx", document.getElementById('prefixImport').value);
                    formData.append("select_file", document.getElementById('fileImport').files[0]);
                    formData.append("typeU", document.getElementById('type').value);
                    // let formData = {
                    //     sendr: 'import',
                    //     prfx: document.getElementById('prefixImport').value,
                    //     select_file: document.getElementById('fileImport').files[0]
                    // };
                    console.log(formData);

                    insert(headers, formData, table, false);
                }
            } catch (e) {
                console.log(e);
                toastr.remove();
                toastr["erfror"](messages.error);
            }
        };

        function Import(){
            let Importform = document.getElementById('importExcel')
            Importform.onsubmit = async function (evt) {
                evt.preventDefault()
                toastr["warning"](apiResponseMessages.SAVING_USER, messages.quit_page_warning, {timeOut: 0, extendedTimeOut: 0});
                let file =document.getElementById('fileImport').files[0]

                try{
                    let formData = new FormData();
                    formData.append("sendr", 'import');
                    formData.append("prfx", document.getElementById('prefixImport').value);
                    formData.append("select_file", document.getElementById('fileImport').files[0]);
                    formData.append("typeU", document.getElementById('type').value);
                    insert(headers, formData, table, false);
                }catch (e) {
                    toastr.remove();
                    toastr["error"](messages.error);
                }

            }
        }





        var prepForm = function (show, hide,hide2) {

            show.removeAttribute('style');
            hide.style.cssText = "display: none";
            hide2.style.cssText = "display: none";
            hide.classList.remove('act');
            hide2.classList.remove('act');

            for (var input of hide2.querySelectorAll('input[required="required"]')) {
                input.removeAttribute('required');
            }
            for (var input of hide.querySelectorAll('input[required="required"]')) {
                input.removeAttribute('required');
            }
            for (var input of show.querySelectorAll('input')) {
                input.setAttribute('required', 'required');
            }
        };

        $('#addUser').on('show.bs.modal', function (evt) {
            form.reset();
            var one = document.getElementById('addOneContent');
            var more = document.getElementById('addMoreContent');
            var xls = document.getElementById('addXlsContent');


            if (evt.relatedTarget === document.getElementById('addOne')) {
                one.classList.add("act");
                document.getElementById('userModalLabel').textContent = messages.modal_user_add;
                prepForm(one, more, xls);
            } else if (evt.relatedTarget === document.getElementById('addMore')) {
                more.classList.add('act');
                document.getElementById('userModalLabel').textContent = messages.modal_users_add;
                prepForm(more, one , xls);
            }else{
                xls.classList.add('act');
                document.getElementById('userModalLabel').textContent = messages.modal_users_add;
                prepForm(xls, one , more);
            }
        });

        document.getElementById('pass').onkeyup = function () {
            document.getElementById('confirm_pass').value = '';
        }

        document.getElementById('confirm_pass').onkeyup = confirmPassHandler;
    }
});
