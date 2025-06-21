<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.home.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Kiểm tra nếu không phải customer thì logout và báo lỗi
            if (Auth::user()->role !== 'customer') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản này không có quyền truy cập.',
                ]);
            }
            return redirect()->intended(route('client.home'))
                        ->with('success', 'Đăng nhập thành công');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->except('password'));
    }

    public function showRegistrationForm()
    {
        return view('frontend.home.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer' // Luôn set role là customer
        ]);

        // Tạo customer record tương ứng
        Customer::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'status' => 'active'
        ]);

        Auth::login($user);

        return redirect()->route('client.home')
                        ->with('success', 'Đăng ký thành công');
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('client.home')
                        ->with('success', 'Đăng xuất thành công');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            
            // Tìm user theo email
            $user = User::where('email', $socialUser->email)->first();
            
            if (!$user) {
                // Tạo user mới
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'customer'
                ]);

                // Tạo customer tương ứng
                Customer::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => 'active'
                ]);
            }

            Auth::login($user);
            return redirect()->route('client.home')->with('success', 'Đăng nhập thành công');

        } catch (\Exception $e) {
            return redirect()->route('client.auth.login')
                ->with('error', 'Đăng nhập không thành công, vui lòng thử lại.');
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback() 
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
            
            // Tìm user theo email
            $user = User::where('email', $socialUser->email)->first();
            
            if (!$user) {
                // Tạo user mới
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'customer'
                ]);

                // Tạo customer tương ứng
                Customer::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => 'active'
                ]);
            }

            Auth::login($user);
            return redirect()->route('client.home')->with('success', 'Đăng nhập thành công');

        } catch (\Exception $e) {
            return redirect()->route('client.auth.login')
                ->with('error', 'Đăng nhập không thành công, vui lòng thử lại.');
        }
    }
}