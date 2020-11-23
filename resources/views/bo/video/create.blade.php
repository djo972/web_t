@extends('bo.layouts.index')

@section('content')
@section('js_files')
    <script src="{{ asset('/js/uploader.js') }}"></script>
    <script src="{{ asset('/js/video.js') }}"></script>
    <script>
        var imagePath = '{{ asset('/uploads/images/')  }}';
    </script>
@endsection
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title">@lang('messages.title_add_video')</h1>
        </div>
    </div>
</div>
<div class="card" id="addVideo" >
    <div class="card-body">
            <form enctype="multipart/form-data" >
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('messages.label.themes')</label>
                        <select class="form-control select-multiple-drag" name="themes[]" multiple="multiple" data-fouc>
                        </select>
                        <span class="error themes_error" style="color: red"></span>
                    </div>
                    <div class="form-group">
                        <label>@lang('messages.label.name_video')</label>
                        <input type="text" id="name" name="name" placeholder="@lang('messages.label.name_video')" class="form-control" autocomplete="off">
                        <span class="error name_error" style="color: red"></span>
                    </div>
                    {{--<div class="mb-3">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="btnLink" name="linkOrVideo" checked class="custom-control-input" value="0">
                            <label class="custom-control-label" for="btnLink">@lang('messages.label.link')</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="btnVideo" name="linkOrVideo" class="custom-control-input" value="1">
                            <label class="custom-control-label" for="btnVideo">@lang('messages.label.video')</label>
                        </div>
                    </div>--}}

                    {{--<div class="form-group" id="showLink">
                        <input type="text" id="link" name="link" placeholder="@lang('messages.label.link')" class="form-control">
                        <span class="error link_error" style="color: red"></span>
                    </div>--}}
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
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="is_visible" name="is_visible" type="checkbox" value="1"  class="custom-control-input">
                        <label class="custom-control-label" for="is_visible">@lang('messages.checkbox.visible')</label>
                        <span class="error is_visible_error ml-2" style="color: red"></span>
                    </div>
                    <div id="textEditor">
                        <div class="form-group mt-3">
                            <label>@lang('messages.label.description')</label>
                            <textarea id="description" name="description" placeholder="@lang('messages.label.description')" class="form-control" rows="6"></textarea>
                            <span class="error description_error" style="color: red"></span>
                        </div>
                    </div>

                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.label.close')</button>
                <button type="submit" id="submitTheme" class="btn btn-primary">@lang('messages.label.add')</button>
            </form>
        </div>
</div>
@endsection