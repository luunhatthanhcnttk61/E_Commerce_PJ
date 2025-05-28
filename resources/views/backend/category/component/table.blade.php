<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Danh mục cha</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent ? $category->parent->name : 'Không có' }}</td>
                <td>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" class="onoffswitch-checkbox js-switch" 
                                data-id="{{ $category->id }}"
                                id="status_{{ $category->id }}" 
                                {{ $category->status == 'active' ? 'checked' : '' }}>
                            <label class="onoffswitch-label" for="status_{{ $category->id }}">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
</div>