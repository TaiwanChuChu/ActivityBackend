<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Driver\FileDriver;
use App\Models\FileStorage;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    public function __construct(FileDriver $fileDriver)
    {
        $this->fileDriver = $fileDriver;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userInfo(Request $request)
    {
        return UserResource::collection(User::with('file_storages')->where('id', '=', $request->user()->toArray()['id'])->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //  /**
        //  * Get a validator for an incoming registration request.
        //  *
        //  * @param  array  $request
        //  * @return \Illuminate\Contracts\Validation\Validator
        //  */
        // $valid = validator($request->only('email', 'name', 'password','mobile'), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6',
        //     'mobile' => 'required',
        // ]);

        // if ($valid->fails()) {
        //     $jsonError = response()->json($valid->errors()->all(), 400);
        //     return \Response::json($jsonError);
        // }

        // $data = request()->only('email','name','password','mobile');

        // $user = User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        //     'mobile' => $data['mobile']
        // ]);

        // // And created user until here.

        // $client = Client::where('password_client', 1)->first();

        // // Is this $request the same request? I mean Request $request? Then wouldn't it mess the other $request stuff? Also how did you pass it on the $request in $proxy? Wouldn't Request::create() just create a new thing?

        // $request->request->add([
        //     'grant_type'    => 'password',
        //     'client_id'     => $client->id,
        //     'client_secret' => $client->secret,
        //     'username'      => $data['email'],
        //     'password'      => $data['password'],
        //     'scope'         => null,
        // ]);

        // // Fire off the internal request.
        // $token = Request::create(
        //     'oauth/token',
        //     'POST'
        // );
        // return \Route::dispatch($token);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
         // 如果有傳密碼，就先加密並將request中的password取代
         if($request->filled('password')) {
            $request->merge(['password' => \Hash::make($request->password)]);
        }

        $data = $request->only('u_no', 'name', 'password', 'email');

        User::insert($data);

        return response()->json(['msg' => 'ok'], 200);
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
    public function update(UserRequest $request, User $user)
    {
        // 如果有傳密碼，就先加密並將request中的password取代
        if($request->filled('password')) {
            $request->merge(['password' => \Hash::make($request->password)]);
        }

        if($request->has('headshot')) {
            if($request->hasFile('headshot') === false) {
                return response()->json(['message' => '未提供欲上傳檔案'], 400);
            } else {
                $options = [
                    'path' => 'FileStorage',
                    'token' => 'headshot',
                    'single' => true,
                ];
                if(count($err = $this->fileDriver->storage($request->file('headshot'), User::class, $user->id, $options)) > 0) {
                    return response()->json(['message' => '上傳失敗!', 'err' => $err], 400);
                }
            }
        }

        $data = $request->only('name', 'password', 'email');

        User::where('id', '=', $user->id)->update($data);

        return response()->json(['message' => '資料更新成功!'], 200);
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

    // 登出 撤銷令牌
    public function logout() {
        $origin_token =  auth()->user()->token();
        if($origin_token->revoke()) {
            $origin_token->delete();
            return response()->json(['msg' => '登出成功!'], 200);
        }
        return response()->json(['msg' => '登出失敗!'], 400);
    }
}
