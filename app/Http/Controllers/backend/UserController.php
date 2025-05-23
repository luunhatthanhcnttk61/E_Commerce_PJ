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
        $keyword = $request->input('keyword');
        $perpage = $request->input('perpage', 10); // mặc định 10 nếu không có giá trị

        $query = User::query();
        
        if(!empty($keyword)) {
            $query->where('name', 'like', '%' . trim($keyword) . '%');
        }

        $users = $query->paginate($perpage);
        //$users = $this->userService->paginate();

        /*phân trang cho user */
        // $users = User::paginate(3);

        $config = $this->config();
        $template = 'backend.user.index';
        return view ('backend.dashboard.layout', compact(
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
    public function createUser()
    {
        $config = $this->config();
        $template = 'backend.user.createUser';
        return view ('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }
    public function storeUser(Request $request)
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
    $user = $this->userService->createUser([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'phone' => $request->phone,
        'address' => $request->address,
        'status' => 1,
    ]);
    //kiểm tra user có được tạo thành công hay không
    if ($user) {
        return redirect()->route('user.index')->with('success', 'Thêm thành viên thành công');
        } else {
        return redirect()->back()->with('error', 'Thêm thành viên thất bại')->withInput();
        }
    }
    public function editUser($id)
    {
        $user = $this->userService->findById($id);
        if(!$user){
            return redirect()->back()->with('error', 'Không tìm thấy người dùng');
        }

        $config = $this->config();
        $template = 'backend.user.editUser';
        return view ('backend.dashboard.layout', compact(
            'template',
            'config',
            'user',
        ));
    }
    public function updateUser(Request $request, $id)
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

    $result = $this->userService->updateUser($id, $data);
    if($result){
        return redirect()->route('user.index')->with('success', 'Cập nhật thành viên thành công');
    }

    return rediract()->back()->with('error', 'Cập nhật thành viên thất bại')->withInput();
    }
    public function deleteUser($id)
    {
        $result = $this->userService->deleteUser($id);
        if($result){
            return redirect()->route('user.index')->with('success', 'Xóa thành viên thành công');
        }
        return redirect()->back()->with('error', 'Xóa thành viên thất bại');
    }

    public function updateStatus(Request $request)
{
    $result = $this->userService->updateUser($request->user_id, [
        'status' => $request->status
    ]);

    return response()->json([
        'success' => $result
    ]);
}
}
