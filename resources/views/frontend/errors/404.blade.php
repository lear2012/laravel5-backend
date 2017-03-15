@extends('frontend.layouts.master')
@section('styles')
<style type="text/css">
    .headline {
        top:40%;
        text-align:center;
        font-size:20px;
    }
</style>
@endsection

@section('content')
<div class="error-page">
        <h2 class="headline text-yellow"> 4041</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> 您所访问的页面或者对象已经不存在！</h3>
        </div>
        <!-- /.error-content -->
      </div>
@endsection