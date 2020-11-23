<?php

namespace App\Http\Controllers\BO;

use App\Imports\ImportExcel;
use App\Http\Controllers\Controller;
use App\Mail\NewUser;
use App\Mail\NewUsersNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;
use Excel;

class UserController extends Controller {
    public function index (Request $request){
        if($request->user()->type == 'superadmin'){
            $users = User::where('type', '!=', 'superadmin')->get();
            $types = array('admin', 'user');
        }else{ // $request->user()->type == 'admin'
            $users = User::where('type', '=', 'user')->get();
            $types = array('user');
        }
        $res = array();
        foreach($users as $key => $val){
            $res[ $key ] = array('id' => $val->id, 'login' => $val->login, 'type' => $val->type);
        }
        if($request->ajax()){
            return response()->json($res);
        }
        return view('bo.user.index', array('users' => json_encode($res), 'types' => $types));
    }

    private function prefixe ($prefixe){
        $lastUsr = DB::table('users')->where('login', 'like', DB::raw("'$prefixe" . "\_%'"))->orderBy(DB::raw("CONVERT(SUBSTRING_INDEX(login, '_', -1), UNSIGNED INTEGER)"), 'desc')->first();
        if(!isset($lastUsr)){
            $indexPf = 0;
        }else{
            $indexPf = explode('_', $lastUsr->login)[1];
        }
        return $indexPf;
    }

    public function create (Request $request){
        $mode = $request->input('sendr');

        if($mode == 'more'){
            $prfx = $request->input('prfx');
            $nmbr = $request->input('nmbr');
            $indx = $this->prefixe($prfx);
            $type = $request->input('typeU');
            $resp = array();
            for($i = 0; $i < $nmbr; $i++){
                $aux = factory(\App\User::class)->make(['login' => $prfx . '_' . ++$indx, 'type' => (isset($type)) ? $type : 'user']);
                $pass = $aux->password;
                $aux->password = Hash::make($aux->password);
                $aux->save();
                array_push($resp, array('login' => $aux->login, 'pass' => $pass));
            }
            if(isset($request->user()->email)){
                Mail::to($request->user()->email)->send(new NewUsersNotification($resp));
            }else{
                $usrs = User::where('type', '!=', 'user')->whereNotNull('email')->get();
                foreach($usrs as $usr){
                    Mail::to($usr->email)->send(new NewUsersNotification($resp));
                }
            }
        }elseif($mode == 'one'){
            $valid = Validator::make($request->all(), ['fname' => 'required|string', 'lname' => 'required|string', 'passw' => 'required|string', 'email' => 'required|email|unique:users,login']);
            if($valid->fails()){
                return response()->json(["error" => $valid->errors()->getMessages()], 201);
            }
            $new = new User();
            $new->first_name = $request->input('fname');
            $new->last_name = $request->input('lname');
            $new->email = $request->input('email');
            $pass = $request->input('passw');
            $new->password = Hash::make($pass);
            $type = $request->input('typeU');
            $new->type = (isset($type)) ? $type : 'user';
            $new->login = $new->email;
            $new->save();
            Mail::to($new->email)->send(new NewUser(array('login' => $new->login, 'pass' => $pass)));
        }elseif($mode === 'import'){
            $valid = Validator::make($request->all(), ['prfx' => 'required|string', 'select_file' => 'required']);
            if($valid->fails()){
                return response()->json(["error" => $valid->errors()->getMessages()], 201);
            }
            $data = [];
            $data[] = $request->input('prfx');
            $type = $request->input('typeU');
            $data[] = (isset($type)) ? $type : 'user';
            $path1 = $request->file('select_file')->store('temp');
            $path = storage_path('app').'/'.$path1;
            Excel::import(new ImportExcel($data), $path);
        }

        return response()->json(["message" => 'CREATE_SUCCESS'], 201);
    }

    public function delete ($userId){
        $user = User::findOrFail($userId);
        $user->forceDelete();
        return response()->json(["message" => 'DELETE_SUCCESS'], 200);
    }
}
