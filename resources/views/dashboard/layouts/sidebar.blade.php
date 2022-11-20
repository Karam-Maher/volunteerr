<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('admin-asset/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">لوحة التحكم</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin-asset/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>
        @endauth
        <!-- Sidebar user panel (optional) -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            لوحة التحكم
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            فئات العمل التطوعي
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('dashboard.categories.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض الفئات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('dashboard.categories.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>انشاء فئة</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('dashboard.categories.trash')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>سلة المحذوفات</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الاعمال التطوعية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('dashboard.posts.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض الاعمال</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('dashboard.posts.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>انشاء عمل</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('dashboard.posts.trash')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>سلة المحذوفات</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
