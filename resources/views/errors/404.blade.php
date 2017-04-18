@extends('frontend.layouts.master')
@section('styles')
    <style type="text/css">
        .headline {
            top:10%;
            text-align:center;
            font-size:1rem;
            padding-bottom:.6rem;
            color: #f7b000;
        }
        .error-content {
            font-size:.5rem;
            color: #f7b000;
            position: absolute;
            top:25%;
            margin:.6rem;
            font-weight:lighter;
        }
    </style>
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 404 </h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> 您所访问的页面或者对象已经不存在，请返回！</h3>
        </div>
        <!-- /.error-content -->
    </div>
@endsection
