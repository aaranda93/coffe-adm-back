<?php

namespace App\Http\Controllers;
use App\Http\Constants\ApiResponse as Api;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    static function response($code, $data = null){

        return response()->json(
            [
                'code' => $code, 
                'message' => Api::CODE_MESSAGES[$code],
                'data' => $data
            ]
            , $code
        );

    }
    
}
