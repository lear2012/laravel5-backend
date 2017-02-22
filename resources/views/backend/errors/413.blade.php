@extends('backend.layouts.master')
@section('pagecss')

@endsection

@section('content')
<div class="error-page">
        <h2 class="headline text-yellow"> 413</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> 您所请求的对象太大！</h3>
        </div>
        <!-- /.error-content -->
      </div>
@endsection