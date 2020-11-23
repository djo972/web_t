<?php

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection {

    public $data;

    public function collection(Collection $rows){
        $this->data = $data;
}

}
