<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',

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
            $user->password = $req->password;
            if ($user->save()) {
                return response(['user' => new TaskResource($user), 'Msg' => 'Thankyou for registering!'], 201); 
            } else {
                return response()->json(['Msg' => 'User registration failed, Try again later.']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
