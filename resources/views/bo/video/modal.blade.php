<!-- Modal -->
<div class="modal fade" id="addVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">@lang('messages.title_add_video')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" >
                @csrf
                <div class="modal-body">
                    {{--<div class="form-group">
                        <label>@lang('messages.label.video')</label>
                        <input type="text" id="name" name="name" placeholder="@lang('messages.label.video')" class="form-control">
                        <span class="error" style="color: red"></span>
                    </div>
                    <div class="mb-3">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="btnLink" name="LinkOrVideo" checked class="custom-control-input" value="0">
                            <label class="custom-control-label" for="btnLink">@lang('messages.label.link')</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="btnVideo" name="LinkOrVideo" class="custom-control-input" value="1">
                            <label class="custom-control-label" for="btnVideo">@lang('messages.label.video')</label>
                        </div>
                    </div>

                    <div class="form-group d-block" id="showLink">
                        <input type="text" id="link" name="link" placeholder="@lang('messages.label.link')" class="form-control">
                        <span class="error" style="color: red"></span>
                    </div>
                    <div class="custom-file mb-3 d-none" id="showVideo">
                        <label for="video" class="custom-file-label">@lang('messages.label.video')</label>
                        <input type="file" id="video" name="video" class="custom-file-input" >
                        <span class="error" style="color: red"></span>
                    </div>--}}
                    <div class="demo-section k-content">
                        <input name="files" id="files" type="file" />
                    </div>
                    {{--<div class="custom-file mb-3" id="showVideo">
                        <label for="files" class="custom-file-label">@lang('messages.label.video')</label>
                        <input type="file" id="files" name="files" class="custom-file-input" >
                        <span class="error" style="color: red"></span>
                    </div>--}}
                    {{--<progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
                    <h3 id="status"></h3>
                    <p id="loaded_n_total"></p>--}}


                    {{--<div>
                        <label for="preview" class="custom_file_label">@lang('messages.label.preview')</label>
                        <input type="file" class="custom_file_input" id="preview" name="preview">
                        <span class="error" style="color: red"></span>
                    </div>
                    <div id="showPreview" class=" mb-3"></div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="is_shareable" name="is_shareable" type="checkbox" value="1"  class="custom-control-input">
                        <label class="custom-control-label" for="is_shareable">@lang('messages.checkbox.shareable')</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="is_visible" name="is_visible" type="checkbox" value="1"  class="custom-control-input">
                        <label class="custom-control-label" for="is_visible">@lang('messages.checkbox.visible')</label>
                    </div>
                    <div class="form-group mt-3">
                        <label>@lang('messages.label.description')</label>
                        <textarea id="description" name="description" placeholder="@lang('messages.label.description')" class="form-control" rows="6"></textarea>
                        <span class="error" style="color: red"></span>
                    </div>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.label.close')</button>
                    <button type="submit" id="submitTheme" class="btn btn-primary">@lang('messages.label.add')</button>
                </div>
            </form>
        </div>
    </div>
</div>