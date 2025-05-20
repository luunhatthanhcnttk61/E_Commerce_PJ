<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {


        $config = $this->config();
        $template = 'backend.user.index';
        return view ('backend.dashboard.layout', compact(
            'template',
            'config',
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
