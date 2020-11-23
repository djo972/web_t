<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if (Auth::user()->type == 'superadmin')
                        <div class="form-group">
                            <label>@lang('messages.label.user_type') *</label>
                            <select id="type" name="type" class="form-control" required="required">
                                <option disabled="disabled" selected="selected" value="">@lang('messages.label.user_type')</option>
                                <option value="admin">@lang('messages.label.admin')</option>
                                <option value="user">@lang('messages.label.user')</option>
                            </select>
                            <span class="error" style="color: red"></span>
                        </div>
                    @endif
                    <div id="addOneContent">
                        <div class="form-group">
                            <label>@lang('messages.label.last_name') *</label>
                            <input type="text" id="lname" name="lname" placeholder="@lang('messages.label.last_name')" class="form-control">
                            <span class="error" style="color: red"></span>
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.label.first_name') *</label>
                            <input type="text" id="fname" name="fname" placeholder="@lang('messages.label.first_name')" class="form-control">
                            <span class="error" style="color: red"></span>
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.label.email') *</label>
                            <input type="email" id="email" name="email" placeholder="@lang('messages.label.email')" class="form-control">
                            <span class="error" style="color: red"></span>
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.label.password') *</label>
                            <input type="password" id="pass" name="passw" placeholder="@lang('messages.label.password')" class="form-control">
                            <span class="error" style="color: red"></span>
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.label.confirm_password') *</label>
                            <input type="password" id="confirm_pass" placeholder="@lang('messages.label.confirm_password')" class="form-control">
                            <span class="invalid-feedback confirm-pass" role="alert">
                                <strong class="error"></strong>
                            </span>
                        </div>
                    </div>
                    <div id="addMoreContent">
                        <div class="form-group">
                            <label>@lang('messages.label.prefixe') *</label>
                            <input type="text" id="prefixe" name="prefixe" placeholder="@lang('messages.label.prefixe')" class="form-control">
                            <span class="error" style="color: red"></span>
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.label.nb_account') *</label>
                            <input type="number" id="nb" name="nb" placeholder="@lang('messages.label.nb_account')" class="form-control">
                            <span class="error" style="color: red"></span>
                        </div>
                    </div>
                        <div id="addXlsContent">
                            <div class="form-group">
                                <label>@lang('messages.label.prefixe') *</label>
                                <input type="text" id="prefixImport" name="prfx" placeholder="@lang('messages.label.prefixe')" class="form-control">
                                <span class="error" style="color: red"></span>
                            </div>
                            <div class="form-group">
                                <table class="table">
                                    <tr>
                                        <td width="40%" align="right"><label>Importer un fichier excel</label></td>
                                        <td width="30">
                                            <input id="fileImport" type="file" name="select_file" />
                                            <span class="error" style="color: red"></span>
                                        </td>
                                        <td width="30%" align="left">
                                            <input type="submit" name="upload" class="btn btn-primary" value="Upload">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="right"></td>
                                        <td width="30"><span class="text-muted">.xls, .xslx</span></td>
                                        <td width="30%" align="left"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.label.close')</button>
                        <button type="submit" class="btn btn-primary">@lang('messages.label.add')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
