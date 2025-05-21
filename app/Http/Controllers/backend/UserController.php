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
    }
    public function index()
    {
        $users = $this->userService->paginate();

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
}
