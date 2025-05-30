<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ config('apps.category.title') }}</h2>
        <ol class="breadcrumb" style="margin-bottom: 10px">
            <li>
                <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>{{ config('apps.category.title') }}</strong>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Quản lý danh mục</h5>
            </div>
            <div class="ibox-content">
                @include('backend.category.component.filter')
                @include('backend.category.component.table')
            </div>
        </div>
    </div>
</div>