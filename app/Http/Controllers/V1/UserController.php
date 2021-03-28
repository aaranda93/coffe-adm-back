<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelsl\User;

class UserController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(StoreUser $request)
    {

            $newUser = User::Create($request->all());

    }
    public function show($user_id)
    {
       
        
    }
    public function store(Request $request, $user_id)
    {
       
        
    }
    public function update(Request $request, $user_id)
    {
       
        
    }
    public function destroy($user_id)
    {
       
        
    }
}