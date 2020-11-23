<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class Utils
{
    public function updateParameters($type, $value)
    {
        $array = Config::get('parameters');
        if (!empty($type)) {
            switch ($type) {
                case 'access':
                    $array['access'] = $value;
                    if (!$value) {
                        $array['payment'] = false;
                    }
                    break;
                case 'payment':
                    if ($array['access']) {
                        $array['payment'] = $value;
                    }
                    break;
                default:
                    return false;
            }
            $data = var_export($array, 1);
            // dd($data, $array);
            if(File::put(config_path('parameters.php'), "<?php\n return $data ;")) {
                return true;
            }
        }
        return false;
    }
}