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
                        <label>Danh mục <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $parent)
                                @if($parent->children->count())
                                    <optgroup label="{{ $parent->name }}">
                                        @foreach($parent->children as $child)
                                            <option value="{{ $child->id }}"
                                                {{ old('category_id', $product->category_id ?? '') == $child->id ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="{{ $parent->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                    <div class="form-group">
                        <label for="discount_percent">Giảm giá (%)</label>
                        <input type="number" step="0.01" name="discount_percent" class="form-control" value="{{ old('discount_percent', $product->discount_percent ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="discount_end_at">Hạn khuyến mãi đến</label>
                        <input type="datetime-local" name="discount_end_at" class="form-control" value="{{ old('discount_end_at', isset($product->discount_end_at) ? \Carbon\Carbon::parse($product->discount_end_at)->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href ="{{ route('admin.product.index') }}" class="btn btn-default">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>