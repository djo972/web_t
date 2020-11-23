<!-- Modal -->
<div class="modal fade" id="addBraker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                    <div class="form-group">
                        <label>@lang('messages.label.name_video')</label>
                        <input type="text" id="name" name="name" placeholder="@lang('messages.label.name_video')" class="form-control" autocomplete="off">
                        <span class="error name_error" style="color: red"></span>
                    </div>

                    <div class="form-group mb-3" id="showVideo">
                        <div class="upload-section">
                            <br />
                            <div id="container">
                                <a id="pickfiles" class="btn btn_upload" href="javascript:;">@lang('messages.label.select_video')</a>
                                <a id="uploadfiles" class="btn btn-primary" href="javascript:;">@lang('messages.label.upload_video')</a>
                                <input type="hidden" id="video_file" name="video_file" value="">
                                <span class="error video_file_error" style="color: red"></span>
                            </div>
                            <div id="showScreenVideo"></div>
                            <br />
                            <div id="filelist">
                            </div>
                            <div id="console"></div>
                        </div>
                    </div>


                    <div class="group_preview">
                        <label for="preview" class="custom_file_label">@lang('messages.label.preview')</label>
                        <input type="file" class="custom_file_input" id="preview" name="preview">
                        <span class="error preview_error" style="color: red"></span>
                    </div>
                    <div id="showPreview" class=" mb-3"></div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="is_shareable" name="is_shareable" type="checkbox" value="1"  class="custom-control-input">
                        <label class="custom-control-label" for="is_shareable">@lang('messages.checkbox.shareable')</label>
                        <span class="error is_shareable_error ml-2" style="color: red"></span>
                    </div>
                    <div id="textEditor">
                        <div class="form-group mt-3">
                            <label>@lang('messages.label.description')</label>
                            <textarea id="description" name="description" placeholder="@lang('messages.label.description')" class="form-control" rows="6"></textarea>
                            <span class="error description_error" style="color: red"></span>
                        </div>
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