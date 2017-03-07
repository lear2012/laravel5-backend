<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - 管理后台</title>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ elixir('css/all_bk.css') }}" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

    <!-- Header -->
    @include('backend.layouts.partials.header')

    <!-- Sidebar -->
    @include('backend.layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page_title')
                <small>@yield('page_description')</small>
            </h1>
            <ol class="breadcrumb">
                @yield('breadcrumb')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @include('backend.layouts.partials.errors')
            @include('backend.layouts.partials.success')

            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    @include('backend.layouts.partials.footer')

    @include('backend.layouts.partials.control_sidebar')
</div>
<!-- ./wrapper -->
<div id="jsmsg">{{Session::get('jsmsg')}}</div>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->

<script src="{{ elixir('js/all_bk.js') }}"></script>
@yield('scripts')
<script src="{{ elixir('js/my.js') }}"></script>
</body>
</html>
