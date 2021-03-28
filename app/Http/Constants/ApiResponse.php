<?php

    class ApiResponse
    {
        CONST UNAUTHORIZED = 404;
        CONST NOT_FOUND = 404;
        CONST BAD_REQUEST = 400;
        CONST OK = 200;
        CONST CREATED = 201;


        CONST CODE_MESSAGES = [

            UNAUTHORIZED => 'unauthorized',
            NOT_FOUND => 'not found',
            BAD_REQUEST => 'not found',
            OK => 'ok',
            CREATED => 'created',
        ];
        

        
    }
