<?php

namespace App\Http\Controllers;

use App\Helper\ResponseJson;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * @var UserService
     */
    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function list()
    {
        return ResponseJson::success('all users',User::all());
    }

    public function add(Request $request)
    {
        // add new user
        $validated = $this->validate($request,UserRequest::add());

        $user = $this->user_service->createUser($validated);
        if($user){
            return ResponseJson::success("User Successfully Created");
        } else {

            return ResponseJson::failure("Something went wrong");
        }


    }
    public function edit(Request $request,$id)
    {
        // add new user
        $request->merge(['id'=>$id]);
        $validated = $this->validate($request,UserRequest::edit());
        $user_id = $validated['id'];
        $user = $this->user_service->findUserById($user_id);
        if($user->update($validated)){
            return ResponseJson::success("User Successfully updated");
        } else {

            return ResponseJson::failure("Something went wrong");
        }

    }
    public function delete(Request $request,$id)
    {
        // delete user
        $request->merge(['id'=>$id]);
        $validated = $this->validate($id, UserRequest::delete());
        $user_id = $validated['id'];
        $user = $this->user_service->findUserById($user_id);
        if($user->delete()){
            return ResponseJson::success("User Successfully deleted");
        } else {

            return ResponseJson::failure("Something went wrong");
        }

    }



}
