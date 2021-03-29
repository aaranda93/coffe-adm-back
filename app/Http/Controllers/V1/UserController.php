<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\Users\StoreUser;
use App\Http\Requests\Users\StoreUpdate;
use App\Http\Requests\Users\Index3;
use Illuminate\Http\Request;
use App\Http\Constants\ApiResponse as Api;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(Index3 $request)
    {

        $users = User::filter($request->all())
        ->get();

        return $this->response(Api::OK, $users);
    }

    public function show($user_id)
    {
        $user = User::find($user_id)
        ->first();

        return $this->response(Api::OK, $user);
    }

    public function store(StoreUser $request)
    {
        $newUser = User::create($request->all());

        return $this->response(Api::CREATED, $newUser);
    }

    public function update(StoreUpdate $request, $user_id)
    {
        $user = User::find($user_id);
        $user->update($request->all());

        return $this->response(Api::OK, $user);
    }

    public function destroy($user_id)
    {
       
        
    }
}