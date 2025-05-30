<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface as UserService;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('admin')->except(['index']);
    }

    public function index(Request $request)
    {
         // Kiểm tra quyền xem danh sách
        if (!auth()->user()->canViewUsers()) {
            return redirect()->route('admin.dashboard.index')
                           ->with('error', 'Bạn không có quyền truy cập');
        }

        $keyword = $request->input('keyword');
        $perpage = $request->input('perpage', 10);

        $query = User::query();
        
        if(!empty($keyword)) {
            $query->where('name', 'like', '%' . trim($keyword) . '%');
        }

        // Nếu là admin thì xem được tất cả, không phải admin thì chỉ xem được user thường
        if (!auth()->user()->isAdmin()) {
            $query->where('role', 'client');
        }

        $users = $query->paginate($perpage);

        $config = $this->config();
        $template = 'backend.user.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'users',
        ));

    }

    private function config(){
        return [
            'js' => [
                '/backends/js/plugins/switchery/switchery.js',
                    ],
            'css' => [
                '/backends/css/plugins/switchery/switchery.css'
            ]
        ];
    }
    public function create()
    {
        if (!auth()->user()->canManageUsers()) {
            return redirect()->route('admin.user.index')
                        ->with('error', 'Bạn không có quyền thêm thành viên');
        }

        $config = $this->config();
        $template = 'backend.user.create';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ], [
        'name.required' => 'Vui lòng nhập họ tên',
        'email.required' => 'Vui lòng nhập email',
        'email.email' => 'Email không đúng định dạng',
        'email.unique' => 'Email đã tồn tại',
        'password.required' => 'Vui lòng nhập mật khẩu',
        'password.min' => 'Mật khẩu tối thiểu 8 ký tự',
    ]);
    //tạo user
    $user = $this->userService->create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'phone' => $request->phone,
        'address' => $request->address,
        'status' => 1,
    ]);
    //kiểm tra user có được tạo thành công hay không
    if ($user) {
        return redirect()->route('admin.user.index')
                       ->with('success', 'Thêm thành viên thành công');
    } else {
        return redirect()->back()->with('error', 'Thêm thành viên thất bại')->withInput();
        }
    }
    public function edit($id)
    {
        $user = $this->userService->findById($id);
        if(!$user){
            return redirect()->back()->with('error', 'Không tìm thấy người dùng');
        }

        $config = $this->config();
        $template = 'backend.user.edit';
        return view ('backend.dashboard.layout', compact(
            'template',
            'config',
            'user',
        ));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        'password' => 'nullable|string|min:8',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ]);
    $data = $request->except('password');
    if($request->filled('password')){
        $data['password'] = bcrypt($request->password);
    }

    $result = $this->userService->update($id, $data);
    if($result){
        return redirect()->route('admin.user.index')
                       ->with('success', 'Cập nhật thành viên thành công');
    }

    return rediract()->back()->with('error', 'Cập nhật thành viên thất bại')->withInput();
    }

    public function delete($id)
    {
        $result = $this->userService->delete($id);
        if($result){
            return redirect()->route('admin.user.index')->with('success', 'Xóa thành viên thành công');
        }
        return redirect()->back()->with('error', 'Xóa thành viên thất bại');
    }

    public function updateStatus(Request $request)
{
    if (!auth()->user()->canManageUsers()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện thao tác này'
            ]);
        }

        $result = $this->userService->update($request->user_id, [
            'status' => $request->status
        ]);

        return response()->json([
            'success' => $result
        ]);

    return response()->json([
        'success' => $result
    ]);
}
}
