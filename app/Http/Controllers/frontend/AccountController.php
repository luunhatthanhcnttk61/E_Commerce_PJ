<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\OrderDetail;

class AccountController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('frontend.home.account');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $result = $this->userService->update(auth()->id(), $request->all());

        if($result) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật thông tin thất bại');
    }

    public function orders()
    {
        // $orders = auth()->user()->orders()->paginate(10);
        // return view('frontend.account.orders', compact('orders'));
        $orders = Order::where('user_id', auth()->id())
                   ->with('orderDetails.product')
                   ->latest()
                   ->get();

    return view('frontend.home.order', compact('orders'));
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses;
        return view('frontend.home.addresses', compact('addresses'));
    }

    public function password()
    {
        return view('frontend.home.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $result = $this->userService->update(auth()->id(), [
            'password' => Hash::make($request->password)
        ]);

        if($result) {
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
        }
        return redirect()->back()->with('error', 'Đổi mật khẩu thất bại');
    }
}