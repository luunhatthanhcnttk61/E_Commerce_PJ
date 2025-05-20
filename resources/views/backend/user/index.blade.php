<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ config('apps.user.title') }}</h2>
        <ol class="breadcrumb" style="margin-bottom: 10px">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>{{ config('apps.user.title') }}</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ config('apps.user.tableHeading') }}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="filter-wrapper">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <div class="perpage">
                            <div class="uk-flex uk-flex-middle uk-flex-between">
                                <select name="perpage" class="form-control input-sm perpage filter mr10 >
                                    @for ($i=1; $i <= 20; $i++)
                                        <option value="{{ $i }} style="height: 35px"" >{{ $i }} bản ghi</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="action">
                            <div class="uk-flex uk-flex-middle">
                                <select name="user_catalogue_id" class="form-control mr10">
                                    <option value="0" selected="selected">Chọn Nhóm thành viên</option>
                                    <option value="1">Quản trị viên</option>
                                </select>
                                <div class="uk-search uk-flex uk-flex-middle mr10">
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            name="keyword" 
                                            value="" 
                                            placeholder="Nhập từ khóa tìm kiếm" 
                                            class="form-control"
                                            >
                                        <span class="input-group-btn">
                                            <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm" type="button">Tìm kiếm</button>
                                        </span>
                                    </div>
                                </div>
                                <a href="" class="btn btn-danger"><i class="fa fa-plus mr5"></i>Thêm mới thành viên</a>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <tr>
                            <td> 
                                <input type ="checkbox" value="" id="checkAll" class="input-checkbox checkBoxItem">
                            </td>
                            <td>LNT</td>
                            <td>lnt@gmail.com</td>
                            <td>0987654321</td>
                            <td>123 Đường k, Phường N, Quận M, Thành phố H</td>
                            <td class="text-center">
                                <input type="checkbox" class="js-switch" checked />
                            </td>
                            <td class="text-center">
                                <a href="" class="btn btn-succcess"><i class="fa fa-edit"></i></a>
                                <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var elem = document.querySelector('.js-switch');
        var swithchery = new Switchery(elem, { color: '#1AB394' });
    })
</script>