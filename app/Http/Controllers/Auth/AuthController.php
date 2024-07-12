<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\ApiResponse;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(),442);
        }

        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return ApiResponse::error("Unauthoriozed",401);
        }
        $user = Auth::user();
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ApiResponse::error("Unauthoriozed",401);
            }
        } catch (JWTException $e) {
            return ApiResponse::error("Could not create token",599);
        }

        $user["token"] = $token;
        return ApiResponse::success(new LoginResource($user),true);

    }
    public function register(Request $request){
         $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(),442);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if(!$user){
            return ApiResponse::error("Please Try Again",500);
        }
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return ApiResponse::error("Unauthoriozed",401);
        }
        $user = Auth::user();
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ApiResponse::error("Unauthoriozed",401);
            }
        } catch (JWTException $e) {
            return ApiResponse::error("Could not create token",599);
        }

        $user["token"] = $token;
        return ApiResponse::success(new LoginResource($user),true);

    }
    public function logout()
    {
        Auth::logout();
        return ApiResponse::Message("Successfully logged out",true,200);

    }

    public function refresh()
    {
            $user = Auth::user();
            $token = Auth::refresh();
            $user['token'] = $token;
           return ApiResponse::success(new LoginResource($user), true);


    }

}
