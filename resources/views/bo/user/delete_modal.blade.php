<!-- Modal -->
<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">@lang('messages.title_delete_user')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    Etes-vous sûr de vouloir supprimer le compte de <span id="loginUserToDelete"></span> ?
                </div>
                <input type="hidden" name="id" id="idUserToDelete">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.label.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('messages.label.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>