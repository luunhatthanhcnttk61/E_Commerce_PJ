<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="public/img/profile_small.jpg" />
                         </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                         </span> <span class="text-muted text-xs block">{{ Auth::user()->role }} <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route ('admin.auth.logout')}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="{{ route('client.home') }}" target="_blank">
                    <i class="fa fa-external-link"></i> 
                    <span class="nav-label">Xem Trang Chủ</span>
                </a>
            </li>
            <li class="active">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Danh Mục Quản Lý</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @if(Auth::user()->canManageUsers())
                    <li><a href="{{ route('admin.user.index') }}">Quản Lý Thành Viên</a></li>
                    @endif
                    <li><a href="{{ route('admin.product.index') }}">Quản Lý Sản Phẩm</a></li> 
                    <li><a href="{{ route('admin.category.index') }}">Quản Lý Danh Mục</a></li>
                    <li><a href="{{ route('admin.order.index') }}">Quản Lý Đơn Hàng</a></li>
                    <li><a href="{{ route('admin.customer.index') }}">Quản Lý Khách Hàng</a></li>
                    <li><a href="{{ route('admin.review.index') }}">Quản Lý Đánh Giá</a></li>
                    <li><a href="{{ route('admin.contact.index') }}">Quản Lý Liên Hệ</a></li>
                    <li><a href="{{ route('admin.setting.index') }}">Cài Đặt Hệ Thống</a></li>
                </ul>
            </li>
            
        </ul>

    </div>
</nav>