<?php

namespace App\Imports;

use App\User;
use App\Mail\NewUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;

class ImportExcel implements ToModel {
    private $row = 0;
    private $data;
    private $password;
    public function __construct (array $data){
        $this->data = $data;
    }

    /**
     * @param array $row
     * @return User
     */
    public function model (array $row){

        $count = 0;
        $this->row++;
        $this->password = str_random(8);
        $import['email'] = $row[0];
        $valid = Validator::make($import, ['email' => 'required|email']);
        if(!$valid->fails()){

            Mail::to($row[0])->send(new NewUser(['login' => $this->data[0] . $this->row, 'pass' =>  $this->password]));

            return new User(['login' => $this->data[0] . $this->row, 'password' => Hash::make($this->password), 'email' => $row[0], 'type' => $this->data[1]]);
        }
        return null;
    }
}
