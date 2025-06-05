<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><input type="checkbox" id="checkAll" class="input-checkbox"></th>
            <th>Mã SP</th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Tồn kho</th>
            <th>Nổi bật</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($products) && count($products) > 0)
            @foreach($products as $product)
            <tr>
                <td><input type="checkbox" value="{{ $product->id }}" class="checkBoxItem"></td>
                <td>{{ $product->code }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" style="max-width: 50px;">
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price) }}đ</td>
                <td>{{ $product->inventory }}</td>
                <td>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" class="onoffswitch-checkbox js-switch-product-featured" 
                                   {{ $product->featured ? 'checked' : '' }}
                                   data-id="{{ $product->id }}" 
                                   id="featured{{ $product->id }}"
                                   {{ $product->featured ? 'checked' : '' }}>
                            {{-- <label class="onoffswitch-label" for="featured{{ $product->id }}"></label> --}}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" class="onoffswitch-checkbox js-switch-product-status" 
                                   //{{ $product->status ? 'checked' : '' }}
                                   data-id="{{ $product->id }}" 
                                   id="status{{ $product->id }}"
                                   {{ $product->status ? 'checked' : '' }}>
                            {{-- <label class="onoffswitch-label" for="status{{ $product->id }}"></label> --}}
                        </div>
                    </div>
                </td>
                <td>
                    <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-success btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Bạn có chắc muốn xóa?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9" class="text-center">Không có dữ liệu</td>
            </tr>
        @endif
    </tbody>
</table>
{{ $products->links('pagination::bootstrap-4') }}