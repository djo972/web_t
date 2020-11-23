<?php

namespace App\Http\Controllers\BO;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Services\Utils;

class ParametersController extends Controller
{
    public function index() {
        return view('bo.parameters.index', array('access' => Config::get('parameters')['access'], 'payment' => Config::get('parameters')['payment']));
    }

    public function update(Request $request, Utils $utils)
    {
        $type = $request->input('type');
        $utils->updateParameters($type, $request->input('update'));
        return response()->json(["message" => 'UPDATE_SUCCESS', "type" => $type], 201);
    }
}
