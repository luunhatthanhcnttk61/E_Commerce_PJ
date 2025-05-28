<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Tiêu đề</th>
                <th>Trạng thái</th>
                <th>Ngày gửi</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->id }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->subject }}</td>
                <td>
                    <select class="form-control contact-status" data-id="{{ $contact->id }}">
                        <option value="new" {{ $contact->status == 'new' ? 'selected' : '' }}>Mới</option>
                        <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Đã đọc</option>
                        <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Đã trả lời</option>
                    </select>
                </td>
                <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <button type="button" class="btn btn-xs btn-primary view-contact" 
                            data-toggle="modal" data-target="#contactModal" 
                            data-contact="{{ $contact->toJson() }}">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $contacts->links() }}
</div>

@include('backend.contact.component.modal')