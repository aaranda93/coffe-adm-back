<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\Users\Store as StoreUser;
use App\Http\Requests\Users\Update as UpdateUser;
use App\Http\Requests\Users\Index as IndexUser;
use App\Http\Requests\Users\Show as ShowUser;
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
    public function index(IndexUser $request)
    {
        $users = User::filter($request->all())
        ->without('company','branch','roles')
        ->get();

        return $this->response(Api::OK, $users);
    }

    public function show(ShowUser $request ,$user_id)
    {
        $user = User::without('company','branch','roles')
        ->find($user_id);

        return $this->response(Api::OK, $user);
    }

    public function store(StoreUser $request, $branch_id)
    {
        $branch = Branch::find($branch_id);
        $newUser = User::create($request->all());

        $branch->contract($newUser);

        return $this->response(Api::CREATED, $newUser);
    }

    public function update(UpdateUser $request, $user_id)
    {
        $user = User::find($user_id);
        $user->update($request->all());

        return $this->response(Api::OK, $user);
    }

    public function destroy($user_id)
    {
       
        
    }
}