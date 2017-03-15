@extends('frontend.layouts.master')
@section('styles')
    <style type="text/css">
        .headline {
            position: absolute;
            top:10%;
            text-align:center;
            font-size:40px;
        }
        .error-content {
            font-size:30px;
            color:white;
            position: absolute;
            top:25%;
            margin:10px;
        }
    </style>
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 401 </h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> 您无权限访问该页面或对象！</h3>
        </div>
        <!-- /.error-content -->
    </div>
@endsection