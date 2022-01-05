<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TaskResource;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;

class JWTController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'contact']]);
    }

    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $user = new User();
            $user->first_name = $req->first_name;
            $user->last_name = $req->last_name;
            $user->status = 1;
            $user->role = 5;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            if ($user->save()) {
                return response(['user' => new TaskResource($user), 'msg' => 'Thankyou for registering.', 'error' => 0], 201);
            } else {
                return response()->json(['msg' => 'User registration failed, Try again later.', 'error' => 1]);
            }
        }
    }

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            if (!$token = auth()->guard('api')->attempt($validator->validated())) {
                return response()->json(['error' => 'Unauthorized User'], 401);
            }
            return $this->respondWithToken($token);
        }
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'error' => 0,
            'message' => 'Logged in',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function contact(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $con = new Contact();
            $con->name = $req->name;
            $con->email = $req->email;
            $con->subject = $req->subject;
            $con->message = $req->message;
            if ($con->save()) {
                return response(['contact' => new TaskResource($con), 'msg' => "Your message is recorded. We'll connect back with you soon!", 'error' => 0], 201);
            } else {
                return response()->json(['msg' => 'Sending message failed, Try again later.', 'error' => 1]);
            }
        }
    }

    public function profile()
    {
        return response()->json(auth()->guard('api')->user());
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    public function logout()
    {
        auth()->guard('api')->logout();
        return response()->json(['msg' => 'Logged Out']);
    }
}
