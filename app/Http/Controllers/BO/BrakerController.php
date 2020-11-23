<?php

namespace App\Http\Controllers\BO;

use App\Braker;
use function App\Helpers\removeImage;
use function App\Helpers\removeVideo;
use function App\Helpers\uploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBrakerRequest;
use App\Http\Requests\UpdateBrakerRequest;
use App\Repositories\BrakerRepository;
use App\Services\VimeoVideo;
use Illuminate\Http\Request;
use Vimeo\Vimeo;

class BrakerController extends Controller
{
    public function index(Request $request)
    {
        $braker = Braker::query()->first();
        if (request()->ajax()) {
            return $braker;
        }
        return view('bo.braker.index', compact('braker'));

    }

    public function create(CreateBrakerRequest $request, Vimeo $client, VimeoVideo $vimeo)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $isShareable = $request->input('is_shareable', 0);
        $preview = $request->file('preview', null);

        if ($request->hasFile('preview')) {
            $preview = uploadImage($preview);
        }
        $videoFile = public_path('/uploads/videos/') . $request->input('video_file');
        $video = $vimeo->upload($client, $request->input('name'), $request->input('description'), $videoFile);

        BrakerRepository::create($name, $preview, $video, $description, $isShareable);
        unlink($videoFile);

        return response()->json(["message" => 'CREATE_SUCCESS'], 201);
    }

    public function update(UpdateBrakerRequest $request, $brakerId, Vimeo $client, VimeoVideo $vimeo)
    {
        $braker = Braker::findOrFail($brakerId);
        $name = $request->input('name');
        $description = $request->input('description');
        $isShareable = $request->input('is_shareable', 0);
        $videoFile = $request->input('video_file');

        if ($request->hasFile('preview')) {
            $preview = $request->file('preview');
            removeImage($braker->preview);
            $preview = uploadImage($preview);
        } else {
            $preview = $braker->preview;
        }
        if (isset($videoFile) && $braker->video_file != $videoFile) {
            $vimeo->delete($client, $braker->video_file);
            $vid = public_path('/uploads/videos/') . $request->input('video_file');
            $videoFile = $vimeo->upload($client, $request->input('name'), $request->input('description'), $vid);
            unlink($vid);
            removeVideo($braker->video_file);
        }

        $brakerRepository = new BrakerRepository($braker);
        $brakerRepository->update($name, $preview, $videoFile, $description, $isShareable);

        if ($request->ajax()) {
            return response()->json(["message" => 'UPDATE_SUCCESS'], 200);
        }
    }
    /**
     * Find Braker by $brakerId
     *
     * @param $brakerId
     *
     * @return Braker
     */
    public function show($brakerId)
    {
        if (request()->ajax()) {
            $braker = Braker::findOrFail($brakerId);
            return $braker;
        }
    }

    /**
     * enable or disabled show share links at home
     *
     * @param int $brakerId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showShareLinks($brakerId)
    {
        $braker = Video::findOrFail($brakerId);

        $brakerRepository = new BrakerRepository($braker);
        if ($braker->is_visible == 1) {
            $brakerRepository->showShareLinks();
            return response()->json(["message" => 'IS_DISABLED'], 200);
        } else {
            $brakerRepository->showShareLinks();
            return response()->json(["message" => 'IS_ENABLED'], 200);
        }
    }

}
