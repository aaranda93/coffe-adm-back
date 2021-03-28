<?php

namespace App\Http\Controllers;
use App\Http\Constants\ApiResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    static function response($code, $data = null){


        response()->json(
            [
                'code' => $code, 
                'message' => ApiResponse::CODE_MESSAGES[$code],
                'data' => $data
            ]
            , $code
        );

    }
    
}
