<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type ="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th class="text-center">Họ tên</th>
        <th class="text-center">Email</th>
        <th class="text-center">Số điện thoại</th>
        <th class="text-center">Địa chỉ</th>
        <th class="text-center">Tình trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($users) && is_object($users))
            @foreach ($users as $user )
            <tr>
                <td> 
                    <input type ="checkbox" value="" id="checkAll" class="input-checkbox checkBoxItem">
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>
                <td class="text-center">
                    <input type="checkbox" 
                    class="js-switch" 
                    data-id="{{ $user->id }}"
                    {{ $user->status == 1? 'checked' : '' }} />
                </td>
                <td class="text-center">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Bạn có chắc muốn xóa thành viên này?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{-- show số trang --}}
{{ $users->links('pagination::bootstrap-4') }}