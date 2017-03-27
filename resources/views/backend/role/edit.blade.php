@extends('backend.layouts.master')

@section('title', '编辑角色')

@section('styles')
@endsection

@section('breadcrumb')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="/admin/dashboard">主页</a></li>
    <li><a>角色管理</a></li>
    <li>编辑角色</li>
@endsection

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑角色</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::model($role, ['route' => ['admin.auth.role.update', $role->id], 'class' => 'form-horizontal', 'role' => 'form']) !!}
                    {!! Form::hidden('_method', 'PUT') !!}
                    <div class="box-body">
                        @include('backend.role._form')
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete">删除</button>--}}
                        <a href="{{route('admin.auth.role.index')}}" class="btn bg-purple btn-flat margin "><i class="fa fa-arrow-left"></i>{{ trans('strings.return_button') }}</a>
                        <button type="submit" class="btn bg-purple btn-flat margin  pull-right"><i class='fa fa-save'></i>&nbsp;&nbsp;{{ trans('strings.save_button') }}</button>
                    </div>
                    <!-- /.box-footer -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        {{-- Confirm Delete --}}
        @include('backend.layouts.partials.delete_modal', array('action' => route('admin.auth.role.destroy', $role->id)))
    </div>
@endsection

@section('scripts')

@endsection

