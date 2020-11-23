var uploader = new plupload.Uploader({
    runtimes: 'html5,flash,silverlight,html4',
    browse_button: 'pickfiles', // you can pass an id...
    container: document.getElementById('container'), // ... or DOM Element itself
    url: '/bo/video/upload',
    chunk_size: '3000kb',
    flash_swf_url: '../js/Moxie.swf',
    silverlight_xap_url: '../js/Moxie.xap',
    // add X-CSRF-TOKEN in headers attribute to fix this issue
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
    filters: {
        max_file_size: '700mb',
        mime_types: [
            {title: "Video Clips", extensions: "mp4,webm,ogg,mov"},
            //{title: "Video Clips", extensions: "3gp,avi,flv,m4v,mov,mp4,mpeg,mpg,vob,webm,wmv"},
        ]
    },
    unique_names : true,
    multi_selection:false,

    init: {
        PostInit: function () {
            document.getElementById('filelist').innerHTML = '';

            document.getElementById('uploadfiles').onclick = function () {
                uploader.start();
                $('#addVideo').modal({
                    backdrop: 'static'
                });
                return false;
            };
        },

        FilesAdded: function (up, files) {
            plupload.each(files, function (file) {
                document.getElementById('filelist').innerHTML += "<div id=" + file.id + " class='file_bloc d-flex align-items-center'><span class='file_icon'><i class='fa fa-file-video-o fa-2x' aria-hidden='true'></i></span><span class='file_details d-flex flex-column'><span class='file-name'>" + file.name + "</span><span class='file-size'>" + plupload.formatSize(file.size) + "</span></span><span class='upload-pct ml-auto p-2'><b></b></span><div id='myProgress'><div class='myBar'></div></div></div>";
            });
        },


        UploadProgress: function (up, file) {
            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = +file.percent + "%";
            document.getElementById(file.id).getElementsByClassName('myBar')[0].style.width = file.percent + "%";
        },

        FileUploaded: function(up, file, res) {
            var obj = eval('(' + res.response + ')');
            $('#video_file').val(obj.name);
        },

        Error: function (up, err) {
            document.getElementById('console').appendChild(document.createTextNode(err.message));
        }
    }
});

uploader.init();
