<div class="product-reviews">
    <!-- Hiển thị đánh giá -->
    @if($reviews->count() > 0)
        <div class="reviews-list mb-4">
        @foreach($reviews as $review)
                <div class="review-item border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="user-info">
                            <strong>{{ $review->customer->name ?? 'Khách hàng ẩn danh' }}</strong>
                            <div class="text-muted small">{{ $review->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" ></i>
                            @endfor
                        </div>
                    </div>
                    <div class="review-content mt-2">
                        {{ $review->comment }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
    @endif

    <!-- Form đánh giá -->
    <div class="review-form">
        <h4>Gửi đánh giá của bạn</h4>
        <form action="{{ route('client.review.store') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="mb-3">
                <label class="form-label">Đánh giá <span class="text-danger">*</span></label>
                <div class="rating-select">
                    @for($i = 5; $i >= 1; $i--)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                            <label class="form-check-label" for="rating{{ $i }}">{{ $i }} sao</label>
                        </div>
                    @endfor
                </div>
                @error('rating')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung đánh giá <span class="text-danger">*</span></label>
                <textarea name="comment" rows="4" class="form-control @error('comment') is-invalid @enderror" required></textarea>
                @error('comment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
        </form>
    </div>
</div>