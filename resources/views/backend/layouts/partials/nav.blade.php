        <div id="navbar" class="navbar navbar-default">
            <script type="text/javascript">
                try{ace.settings.check('navbar' , 'fixed')}catch(e){}
            </script>

            <div class="navbar-container" id="navbar-container">
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">收缩侧边栏</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
                </button>

                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            <i class="fa fa-leaf"></i>
                            {{ trans('strings.backend.dashboard_title') }}
                        </small>
                    </a>
                </div>

                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">

                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="/avatars/user.jpg" alt="Jason's Photo">
                                <span class="user-info">
                                    <small>{{ trans('strings.backend.WELCOME') }},</small>
                                    {{ Auth::user()->username }}
                                </span>
                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>

                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href="{{ url('/admin/auth/user/change-password', Auth::user()->id) }}">
                                        <i class="ace-icon fa fa-lock"></i>
                                        修改密码
                                    </a>
                                </li>

                                {{--<li>--}}
                                    {{--<a href="{{ url('admin/user/setting') }}">--}}
                                        {{--<i class="ace-icon fa fa-cog"></i>--}}
                                        {{--设置--}}
                                    {{--</a>--}}
                                {{--</li>--}}

                                {{--<li>--}}
                                    {{--<a href="{{ url('admin/user/profile') }}">--}}
                                        {{--<i class="ace-icon fa fa-user"></i>--}}
                                        {{--个人资料--}}
                                    {{--</a>--}}
                                {{--</li>--}}

                                {{--<li class="divider"></li>--}}

                                <li>
                                    <a href="{{ url('admin/logout') }}">
                                        <i class="ace-icon fa fa-power-off"></i>
                                        退出
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- /.navbar-container -->
        </div>