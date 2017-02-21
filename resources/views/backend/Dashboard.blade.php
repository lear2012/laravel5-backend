@extends('backend.layouts.master')

@section('title', '可野管理后台')

@section('page_title')
    Dashboard
@stop

@section('breadcrumb')
    <li>
        <a href="{{ url('admin/dashboard') }}">主页</a>
    </li>
    <li>
        <a>仪表盘</a>
    </li>
@endsection

@section('content')

    <!-- Main row -->
        <h4 class="siteh4">欢迎进入可野俱乐部后台管理系统</h4>
    <!-- /.row -->
@endsection

