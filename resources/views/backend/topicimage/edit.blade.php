@extends('backend.layouts.master')

@section('title', '编辑首页轮播图')

@section('styles')
@endsection

@section('breadcrumb')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="/admin/dashboard">主页</a></li>
    <li><a>首页轮播图管理</a></li>
    <li>编辑首页轮播图</li>
@endsection

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑首页轮播图</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::model($route, ['route' => ['admin.topicimage.update', $route->id], 'class' => 'form-horizontal', 'role' => 'form']) !!}
                    {!! Form::hidden('_method', 'PUT') !!}
                    <div class="box-body">
                        @include('backend.topicimage._form')
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete">删除</button>--}}
                        <a href="{{route('admin.keyeroutes.index')}}" class="btn bg-purple btn-flat margin">{{ trans('strings.return_button') }}</a>
                        <input type="submit" class="btn bg-purple btn-flat margin  pull-right" value="{{ trans('strings.save_button') }}" />
                    </div>
                    <!-- /.box-footer -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection


