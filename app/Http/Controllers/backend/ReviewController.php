<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\ReviewServiceInterface as ReviewService;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
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

    public function index(Request $request)
    {
        $reviews = $this->reviewService->getReviews($request);
        $config = $this->config();
        $template = 'backend.review.index';
        
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'reviews'
        ));
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        
        $result = $this->reviewService->updateStatus($id, $status);
        
        return response()->json(['success' => $result]);
    }
}