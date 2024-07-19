<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required:same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully');
    }

     /**
     * Login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully');
        } else {
            return $this->sendError('Unauthorized', ['error' => 'Unauthorized']);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        // $user = Auth::user();
        // dd($request->user()->currentAccessToken());
        
        // Get all user token
        // dd($user->tokens()->get()->pluck('token'));
        
        // Revoke all user token
        // $user->tokens()->delete();
        
        // Revoke the token that was used to authenticate the current request
        // $request->user()->currentAccessToken()->delete();
        // $user->currentAccessToken()->delete();
        
        // Revoke a specific token...
        // $user->tokens()->where('id', 3)->delete();

        if ($request->user()->currentAccessToken()->delete()) {
            return $this->sendResponse(null, 'User logout successfully');
        } else {
            return $this->sendError('Logout failed', ['error' => 'Logout failed']);
        }

    }
}
