<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ReviewServiceInterface;
use Illuminate\Http\Request;

class FrontendReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewServiceInterface $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        $data = [
            'product_id' => $request->product_id,
            'customer_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending' 
    ];

        $review = $this->reviewService->createReview($data);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi');
    }
}