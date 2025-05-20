<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        if(Auth::id() > 0){
            return redirect()->route('dashboard.index');
        }

        return view('backend.auth.login');
    }

    public function register()
    {
        if(Auth::id() > 0){
            return redirect()->route('dashboard.index');
        }

        return view('backend.auth.register');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required',
                        'string',
                        'email',
                        'max:255',
                        'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'
                    ],
            'password' => 'required|string|min:8',
            'email.regex' => 'Email phải có định dạng @gmail.com',
        ]);
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email này chưa được đăng ký!']);
        }
        if (Auth::attempt($data)) {
            return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công!');
        } else {
            return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['password' => 'Mật khẩu không chính xác!']);
        }
    }

    public function storeRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required',
                        'string',
                        'email',
                        'max:255',
                        'unique:users',
                        'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'
                    ],
            'password' => 'required|string|min:8',

            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'email.regex' => 'Email phải có định dạng @gmail.com',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự'
            
        ]);

        if(!$request->input('checkbox')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['checkbox' => 'Vui lòng đồng ý với điều khoản sử dụng']);
        }

        // if($request->input('checkbox')){
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                
            ]);
            return redirect()->route('auth.index')
        ->with('success', 'Đăng ký tài khoản thành công. Vui lòng đăng nhập.');

    }


    public function logout(Request $request)
    {
        //auth()->logout();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.index')->with('success', 'Đăng xuất thành công!');
        //return view('backend.auth.login');
    }
}
