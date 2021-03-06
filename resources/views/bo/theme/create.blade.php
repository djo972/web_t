<!-- Modal -->
<div class="modal fade" id="addTheme" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="themeModalLabel">@lang('messages.title_add_theme')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" >
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('messages.label.theme')</label>
                        <input type="text" id="name" name="name" placeholder="@lang('messages.label.theme')" class="form-control" maxlength="20">
                        <span class="error" style="color: red"></span>
                    </div>
                    <div class="custom-file mb-3">
                        <label for="icon" class="custom-file-label">@lang('messages.label.icon')</label>
                        <input type="file" id="icon" name="icon" class="custom-file-input" >
                        <span class="error" style="color: red"></span>
                    </div>
                    <div id="showIcon" class=" mb-3"></div>
                    <div class="custom-control custom-checkbox">
                        <input id="is_visible" name="is_visible" type="checkbox" value="1"  class="custom-control-input">
                        <label class="custom-control-label" for="is_visible">@lang('messages.checkbox.visible')</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.label.close')</button>
                    <button type="submit" id="submitTheme" class="btn btn-primary">@lang('messages.label.add')</button>
                </div>
            </form>
        </div>
    </div>
</div>