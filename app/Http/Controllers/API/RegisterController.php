<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\User as ResourcesUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $request->validated();
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        // $success['token'] = $user->createToken('ABC')->accessToken;
        // $success['name'] = $user->name;

        // return $this->sendResponse($success, 'User Registered Successfully');
        // return (new ResourcesUser($user))->response()->json();
        return ResourcesUser::make($user);
    }

    public function login(LoginRequest $request)
    {
        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        //     $user = Auth::user();
        //     $success['token'] = $user->createToken('ABC')->accessToken;
        //     $success['name'] = $user->name;

        //     return $this->sendResponse($success, 'User Logined Successfully');
        // }
        // else {

        //     return $this->sendError('Please Validate Error', ['error' => 'Unauthorised']);
        // }
        $request->validated();
        $user = Auth::user();
        return ResourcesUser::make($user);
    }
}
