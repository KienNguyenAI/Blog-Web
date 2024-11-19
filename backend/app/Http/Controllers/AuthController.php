<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate email
        $validated = $request->validate([
            'email' => 'required|unique:users,email|email',
            "username" => 'required|unique:users,username',
            "name" => 'required',
            "password" => 'required|confirmed|min:8',

        ], [
            'email.required' => 'Nhập email',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email không hợp lệ',

            'username.required' => 'Nhập tên tài khoản',
            'username.unique' => 'Tên tài khoản đã tồn tại',

            'name.required' => 'Nhập tên tài khoản',
            'password.required' => 'Nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu không khớp',
        ]);

        // Tạo người dùng mới
        $user = User::create([
            'avatar' => '',
            'email' => $validated['email'],
            'username' => $validated['username'],
            'name' => $validated['name'],
            'password' => Hash::make($validated['password']),
            'roles_id' => "3"
        ]);

        return response()->json([
            'message' => 'Tạo tài khoản thành công',
            'user' => $user,
        ], 201);
    }
    public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'username_or_email' => 'required',
            'password' => 'required|min:8',
        ], [
            'username_or_email'  => "Nhập tên tài khoản hoặc Email",
            'password.required' => 'Nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $usernameOrEmail = $request->input('username_or_email');
        $password = $request->input('password');


        $user = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $usernameOrEmail)->first()
            : User::where('username', $usernameOrEmail)->first();


        if (!$user) {
            return response()->json(['errors' => ['username_or_email' => ['Tên tài khoản hoặc email không đúng']]], 401);
        }


        if (!Hash::check($password, $user->password)) {
            return response()->json(['errors' => ['password' => ['Mật khẩu không đúng']]], 401);
        }


        Auth::login($user);


        return response()->json(['message' => 'Đăng nhập thành công', 'user' => $user], 200);
    }
    public function resetPass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',  // Kiểm tra email hợp lệ và tồn tại trong DB
            'password' => 'required|confirmed|min:8',        // Mật khẩu mới phải xác nhận và có ít nhất 8 ký tự
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.confirmed' => 'Mật khẩu mới và xác nhận mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();


        if (!$user) {
            return response()->json(['message' => 'Email không tồn tại.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Mật khẩu đã được cập nhật thành công.'], 200);
    }
}
