<div class="category-sidebar">
    <h4 class="sidebar-title">Danh mục sản phẩm</h4>
    <ul class="category-list">
        @foreach($categories as $cat)
            <li class="category-item {{ isset($category) && $cat->id == $category->id ? 'active' : '' }}">
                <a href="{{ route('client.category.show', $cat->slug) }}" class="category-link">
                    {{ $cat->name }}
                    <span class="product-count">({{ $cat->products_count }})</span>
                </a>
                @if($cat->children && count($cat->children) > 0)
                    <ul class="subcategory-list">
                        @foreach($cat->children as $child)
                            <li class="category-item {{ isset($category) && $child->id == $category->id ? 'active' : '' }}">
                                <a href="{{ route('client.category.show', $child->slug) }}" class="category-link">
                                    {{ $child->name }}
                                    <span class="product-count">({{ $child->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

    @if(isset($category))
    <div class="price-filter mt-4">
        <h4 class="sidebar-title">Lọc theo giá</h4>
        <form action="{{ route('client.category.show', $category->slug) }}" method="GET">
            <div class="price-range">
                <input type="number" name="price_from" class="form-control mb-2" placeholder="Giá từ" 
                    value="{{ request('price_from') }}">
                <input type="number" name="price_to" class="form-control" placeholder="Giá đến"
                    value="{{ request('price_to') }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm mt-2">Lọc</button>
        </form>
    </div>
    @endif
</div>