<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Khách hàng</th>
                <th>Đánh giá</th>
                <th>Nội dung</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr>
                <!-- Các cột dữ liệu -->
                <td>{{ $review->id }}</td>
                <td>{{ $review->product->name }}</td>
                <td>{{ $review->customer->name }}</td>
                <td>
                    <!-- Hiển thị sao đánh giá -->
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                </td>
                <td>{{ Str::limit($review->comment, 50) }}</td>
                
                <!-- Switch button trạng thái -->
                <td>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" 
                                   class="onoffswitch-checkbox js-switch" 
                                   data-id="{{ $review->id }}"
                                   id="status_{{ $review->id }}" 
                                   {{ $review->status == 'approved' ? 'checked' : '' }}>
                            <label class="onoffswitch-label" for="status_{{ $review->id }}">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </td>
                <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                
                <!-- Nút xem chi tiết -->
                <td>
                    <button type="button" 
                            class="btn btn-xs btn-primary view-review" 
                            data-toggle="modal" 
                            data-target="#reviewModal" 
                            data-review="{{ $review->toJson() }}">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Phân trang -->
    {{ $reviews->links() }}
</div>

<!-- Modal xem chi tiết -->
@include('backend.review.component.modal')