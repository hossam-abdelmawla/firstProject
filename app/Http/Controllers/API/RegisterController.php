<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'       => 'required',
            'email'      => 'required | email',
            'password'   => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Please Validate Error', $validator->errors());
        }

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('ABC')->accessToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User Registered Successfully');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('ABC')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User Logined Successfully');
        }
        else {

            return $this->sendError('Please Validate Error', ['error' => 'Unauthorised']);
        }
    }
}
