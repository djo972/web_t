<?php

namespace App\Http\Controllers\BO;

use function App\Helpers\removeFile;
use function App\Helpers\removeImage;
use function App\Helpers\removeVideo;
use function App\Helpers\uploadImage;
use function App\Helpers\uploadVideo;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Repositories\VideoRepository;
use App\Services\VimeoVideo;
use App\Video;
use Vimeo\Vimeo;

use Illuminate\Http\Request;

class VideoController extends Controller
{

    /**
     * index for Video model
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $search = $request->get('search', null);
            $themeId = $request->get('themeId', null);
            return response()->json(VideoRepository::findVideos($search, $themeId));
        }
        return view('bo.video.index');
    }


    /**
     * Find Video by id
     *
     * @param $videoId
     *
     * @return Video
     */
    public function show($videoId)
    {
        $video = Video::with('themes')->findOrFail($videoId);
        if (request()->ajax()) {
            return $video;
        }
        return view('bo.video.show', compact('video'));
    }


    /**
     * create new Video
     *
     * @param CreateVideoRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateVideoRequest $request, Vimeo $client, VimeoVideo $vimeo)
    {
        $themes = $request->input('themes');
        $name = $request->input('name');
        $description = $request->input('description');
        $isShareable = $request->input('is_shareable', 0);
        $isVisible = $request->input('is_visible', 0);
        $preview = $request->file('preview', null);
        //$linkOrVideo = $request->input('linkOrVideo');

        if ($request->hasFile('preview')) {
            $preview = uploadImage($preview);
        }

        // video path in project directory
        $videoFile = public_path('/uploads/videos/') . $request->input('video_file');

        $video = $vimeo->upload($client, $name, $description, $videoFile);

        // save video
        VideoRepository::create($name, $preview, $video, $description, $isVisible, $isShareable, $themes);

        // remove video from project directory
        unlink($videoFile);
        return response()->json(["message" => 'CREATE_SUCCESS'], 201);
    }

    /**
     * update video
     *
     * @param UpdateVideoRequest $request
     * @param int $videoId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateVideoRequest $request, $videoId, Vimeo $client, VimeoVideo $vimeo)
    {
        $video = Video::findOrFail($videoId);
        $themes = $request->input('themes');
        $name = $request->input('name');
        $description = $request->input('description');
        $isShareable = $request->input('is_shareable');
        $isVisible = $request->input('is_visible');
        $change_file = $request->input('change_file');
        //$linkOrVideo = $request->input('linkOrVideo');

        if ($request->hasFile('preview')) {
            $preview = $request->file('preview');
            removeImage($video->preview);
            $preview = uploadImage($preview);
        } else {
            $preview = $video->preview;
        }

        $videoFile = $request->input('video_file');
        if ($change_file == 1) {
            removeVideo($video->video_file);
            $vimeo->delete($client, $video->video_file);
            $vid = public_path('/uploads/videos/') . $request->input('video_file');
            $videoFile = $vimeo->upload($client, $request->input('name'), $request->input('description'), $vid);
            unlink($vid);
        } else {
            $vimeo->update($client, $request->input('name'), $request->input('description'), $video->video_file);
        }

        $videoRepository = new VideoRepository($video);

        $videoRepository->update($name, $preview, $videoFile, $description, $isVisible,
            $isShareable, $themes);

        if ($request->ajax()) {
            return response()->json(["message" => 'UPDATE_SUCCESS'], 200);
        }

    }

    /**
     * enable or disabled show video at home
     *
     * @param int $videoId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAtHome($videoId)
    {
        $video = Video::findOrFail($videoId);

        $videoRepository = new VideoRepository($video);
        if ($video->is_visible == 1) {
            $videoRepository->showAtHome();
            return response()->json(["message" => 'IS_DISABLED'], 200);
        } else {
            $videoRepository->showAtHome();
            return response()->json(["message" => 'IS_ENABLED'], 200);
        }
    }

    /**
     * enable or disabled show share links at home
     *
     * @param int $videoId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showShareLinks($videoId)
    {
        $video = Video::findOrFail($videoId);

        $videoRepository = new VideoRepository($video);
        if ($video->is_visible == 1) {
            $videoRepository->showShareLinks();
            return response()->json(["message" => 'IS_DISABLED'], 200);
        } else {
            $videoRepository->showShareLinks();
            return response()->json(["message" => 'IS_ENABLED'], 200);
        }
    }

    /**
     * delete video softly
     *
     * @param int $videoId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($videoId, Vimeo $client, VimeoVideo $vimeo)
    {
        $video = Video::findOrFail($videoId);
        $vimeo->delete($client, $video->video_file);
        removeImage($video->preview);
        removeVideo($video->video_file);
        $video->themes()->detach();
        $videoRepository = new VideoRepository($video);
        $videoRepository->delete();
        return response()->json(["message" => 'DELETE_SUCCESS'], 200);
    }

    /**
     * sort videos by theme with drag and drop
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        if (request()->ajax()) {
            $orderArray = $request->input('orderArray');
            $themeId = $request->input('themeId');
            VideoRepository::updateOrder($orderArray, $themeId);
            return response()->json(["message" => 'UPDATE_ORDER_SUCCESS'], 200);
        }

    }


    /**
     * upload video by chunk
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        // Settings
        //$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
        $targetDir = public_path('/uploads/videos/');
        //$targetDir = 'uploads';
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }
        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        // Chunking might be enabled
        $requestChunk = $request->input('chunk');
        $requestChunks = $request->input('chunks');
        $chunk = isset($requestChunk) ? intval($requestChunk) : 0;
        $chunks = isset($requestChunks) ? intval($requestChunks) : 0;

        // Remove old temp files
        if ($cleanupTargetDir) {

            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                return response()->json(["message" => trans('messages.FAILED_OPEN_TEMP_DIRECTORY')], 100);
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }


        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            return response()->json(["message" => trans('messages.FAILED_OPEN_OUTPUT_STREAM')], 102);
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                return response()->json(["message" => trans('messages.FAILED_MOVE_FILE')], 103);
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                return response()->json(["message" => trans('messages.FAILED_OPEN_INPUT_STREAM')], 101);
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                return response()->json(["message" => trans('messages.FAILED_OPEN_INPUT_STREAM')], 101);
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }

        // Return Success JSON-RPC response
        return response()->json(['message' => 'UPLOAD_SUCCESS', 'name' => $fileName], 200);
    }

}
