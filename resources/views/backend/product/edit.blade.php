<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Cập nhật sản phẩm</h5>
            </div>
            <div class="ibox-content">
                <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Mã sản phẩm</label>
                        <input type="text" name="code" value="{{ old('code', $product->code) }}" class="form-control">
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Giá</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="number" name="inventory" value="{{ old('inventory', $product->inventory) }}" class="form-control">
                        @error('inventory')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Sản phẩm nổi bật</label>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="featured" class="onoffswitch-checkbox js-switch" 
                                       {{ old('featured', $product->featured) ? 'checked' : '' }}
                                    id="featured" value="1" {{ $product->featured ? 'checked' : '' }}>
                                <label class="onoffswitch-label" for="featured"></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Hình ảnh</label>
                        @if($product->image)
                            <div>
                                <img src="{{ asset($product->image) }}" style="max-width: 100px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href ="{{ route('admin.product.index') }}" class="btn btn-default">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>