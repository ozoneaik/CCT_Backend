<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request): Response|Application|ResponseFactory
    {
        $credentials = $request->validated();
        // ตรวจสอบข้อมูลผู้ใช้จากฐานข้อมูลโดยใช้ Eloquent หรือ Query Builder
        $user = User::where('username', $credentials['username'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'error' => 'The Provided credentials are not correct',
                'message' => 'ผู้ใช้งานระบบหรือรหัสผ่านไม่ถูกต้อง'
            ], 422);
        }
//        $token = User::generateToken($user);
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token,
            'message' => 'เข้าสู่ระบบสำเร็จ'
        ]);
    }

    public function me(Request $request){
        return $request->user();
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function listUsers(): JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }

    public function createUser(Request $request){
        $request->validate([
            '*.username' => 'required',
            '*.name' => 'required',
            '*.password' => 'required',
        ]);
        $user = $request['User'];
        if (Hash::check($user['confirmPassword'],auth()->user()->password)){
            $new_user = new User();
            $new_user->name = $user['name'];
            $new_user->username = $user['username'];
            $new_user->password  = Hash::make($user['password']);
            $new_user->save();
            $message = 'สร้างผู้ใช้ '.$user['username'].' สำเร็จ';
            $status = 200;
        }else{
            $message = 'รหัสผ่าน admin ผิด';
            $status = 400;
        }
        return response()->json([
            'message' => $message
        ],$status);

    }

    public function updateUser(Request $request) : JsonResponse{
        $user = $request->UserUpdate;
        $status = 400;
        if (Hash::check($user['confirmPassword'],auth()->user()->password)) {
            $userUpdate = User::where('username',$user['username'])->first();
            $userUpdate->name = $user['name'];
            if (isset($user['password'])){
                $userUpdate->password = Hash::make($user['password']);
            }
            $userUpdate->save();
            $message = 'อัพเดทผู้ใช้ '.$user['username'].' สำเร็จ';
            $status = 200;
        }else{
            $message = 'รหัสผ่าน admin ผิด';
        }
        return response()->json([
            'message' => $message
        ],$status);
    }

    public function deleteUser($username): JsonResponse{
        try {
            $user = User::where('username',$username)->first();
            $user->delete();
            return response()->json([
                'message' => 'ลบผู้ใช้ '.$username.' สำเร็จ'
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }
}
