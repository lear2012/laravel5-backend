<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ !is_null(Auth::user()->userProfile) ? Auth::user()->userProfile->avatar : config('custom.default_avatar') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->username }}</p>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">


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


            <li class="header">其它</li>
            <li><a href="/admin/logout"><i class="fa fa-circle-o text-red"></i> <span>退出</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
