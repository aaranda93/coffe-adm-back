<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Constants\ApiResponse as Api;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function user(Request $request)
    {
        return $this->response(Api::OK, $request->user());
    }

}