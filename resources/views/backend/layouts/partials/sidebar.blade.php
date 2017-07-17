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

            <li class="header">环中国自驾活动管理</li>
            <li @if(Request::is('admin/site*')) class="treeview active" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span>首页设置</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/site/config')) class="active" @endif>
                        <a href="{{ route('admin.site.config') }}"><i class="fa fa-map"></i> 设置首页地图</a>
                    </li>
                </ul>
            </li>
            <li @if(Request::is('admin/topicimage*')) class="treeview active" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-road"></i>
                    <span>首页轮播图管理</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/topicimage')) class="active" @endif>
                        <a href="{{ route('admin.topicimage.index') }}"><i class="fa fa-road"></i> 首页轮播图列表</a>
                    </li>
                    <li @if(Request::is('admin/topicimage/create')) class="active" @endif>
                        <a href="{{ route('admin.topicimage.create') }}"><i class="fa fa-plus"></i> 添加首页轮播图</a>
                    </li>
                </ul>
            </li>
            <li @if(Request::is('admin/keyeroutes*')) class="treeview active" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-road"></i>
                    <span>路段管理</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/keyeroutes')) class="active" @endif>
                        <a href="{{ route('admin.keyeroutes.index') }}"><i class="fa fa-road"></i> 路段列表</a>
                    </li>
                    <li @if(Request::is('admin/keyeroutes/create')) class="active" @endif>
                        <a href="{{ route('admin.keyeroutes.create') }}"><i class="fa fa-plus"></i> 添加路段</a>
                    </li>
                </ul>
            </li>

            <li @if(Request::is('admin/keyeenrollments*') || Request::is('admin/keyelifts*') || Request::is('admin/keyeclubs*')) class="treeview active" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-registered"></i>
                    <span>报名管理</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/keyeenrollments')) class="active" @endif>
                        <a href="{{ route('admin.keyeenrollments.index') }}"><i class="fa fa-car"></i> 自驾报名列表</a>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/keyelifts')) class="active" @endif>
                        <a href="{{ route('admin.keyelifts.index') }}"><i class="fa fa-cab"></i> 搭车报名列表</a>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/keyeclubs')) class="active" @endif>
                        <a href="{{ route('admin.keyeclubs.index') }}"><i class="fa fa-bandcamp"></i> 俱乐部报名列表</a>
                    </li>
                </ul>
            </li>

            <li @if(Request::is('admin/keyecontacts*')) class="treeview active" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-meetup"></i>
                    <span>联系可野</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/keyecontacts')) class="active" @endif>
                        <a href="{{ route('admin.keyecontacts.index') }}"><i class="fa fa-link"></i> 商务洽谈</a>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li @if(Request::is('admin/keyecontacts/contactus')) class="active" @endif>
                        <a href="{{ route('admin.keyecontacts.contactus') }}"><i class="fa fa-phone"></i> 联系我们</a>
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


            <li class="header">其它</li>
            <li><a href="/admin/logout"><i class="fa fa-circle-o text-red"></i> <span>退出</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
