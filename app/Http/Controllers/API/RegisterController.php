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

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return ResourcesUser::make($user);
    }

    public function login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('seven')->accessToken;
            return $success['token'];
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // public function login(RegisterRequest $request){

    // 	$validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     if (! $token = auth()->attempt($request->validated())) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    //     return $this->createNewToken($token);
    // }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
