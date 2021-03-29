<?php

namespace App\Http\Constants;

    class ApiResponse
    {
        CONST UNAUTHORIZED = 404;
        CONST NOT_FOUND = 404;
        CONST BAD_REQUEST = 400;
        CONST OK = 200;
        CONST CREATED = 201;


        CONST CODE_MESSAGES = [

            self::UNAUTHORIZED => 'unauthorized',
            self::NOT_FOUND => 'not found',
            self::BAD_REQUEST => 'not found',
            self::OK => 'ok',
            self::CREATED => 'created',
        ];
        

        
    }
