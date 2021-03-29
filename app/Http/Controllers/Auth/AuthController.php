<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Constants\ApiResponse as Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        
        return $this->response(Api::OK, Auth::user());
    }

}