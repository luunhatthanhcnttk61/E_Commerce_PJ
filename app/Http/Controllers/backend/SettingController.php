<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\SettingServiceInterface as SettingService;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    private function config()
    {
        return [
            'js' => [
                '/backends/js/plugins/switchery/switchery.js',
            ],
            'css' => [
                '/backends/css/plugins/switchery/switchery.css'
            ]
        ];
    }

    public function index()
    {
        $settings = $this->settingService->getAllSettings();
        $config = $this->config();
        $template = 'backend.setting.index';
        
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'settings'
        ));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        $result = $this->settingService->updateSettings($data);
        
        if($result) {
            return redirect()->back()->with('success', 'Cập nhật thành công');
        }
        return redirect()->back()->with('error', 'Có lỗi xảy ra');
    }
}