<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->username }}</p>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li @if(Request::is('admin/expdriver*')) class="treeview active" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>老司机专栏</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/expdriver/home')) class="active" @endif>
                        <a href="{{ url('admin/expdriver/home') }}"><i class="fa fa-circle-o"></i>个人页面展示</a>
                    </li>
                </ul>
            </li>

            <li class="header">系统设置</li>
            <li @if(Request::is('admin/auth/*')) class="treeview active" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-gears"></i>
                    <span>用户系统管理</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/auth/user*')) class="active" @endif>
                        <a href="{{ route('admin.auth.user.index') }}"><i class="fa fa-user"></i> 用户管理</a>
                    </li>
                    <li @if(Request::is('admin/auth/role*')) class="active" @endif>
                        <a href="{{ route('admin.auth.role.index') }}"><i class="fa fa-group"></i> 角色管理</a>
                    </li>
                    <li @if(Request::is('admin/auth/permission*')) class="active" @endif>
                        <a href="{{ route('admin.auth.permission.index') }}"><i class="fa fa-flash"></i> 权限管理</a>
                    </li>
                </ul>
            </li>

            <li class="header">帮助</li>
            <li>
                <a href="https://almsaeedstudio.com/themes/AdminLTE/index.html" target="_blank">
                    <i class="fa fa-book"></i> <span>模板Demo</span>
                </a>
            </li>
            <li>
                <a href="https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html" target="_blank">
                    <i class="fa fa-book"></i> <span>模板使用文档</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>