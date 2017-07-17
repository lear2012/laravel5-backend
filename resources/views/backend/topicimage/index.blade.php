@extends('backend.layouts.master')

@section('title', '轮播图列表')

@section('styles')
    <!-- DataTables -->
@endsection

@section('page_title')
    首页轮播图管理
@endsection

@section('page_description')
    轮播图列表
@endsection

@section('breadcrumb')
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">首页轮播图管理</a></li>
        <li class="active">轮播图列表</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                        <a href="/admin/topicimage/create" class="btn bg-purple btn-flat margin"><i class="fa fa-plus"></i>添加轮播图</a>
                    </h3>
                </div>
                <div class="table-responsive padding15 mart12">
                    <table id="dataTable" class="table table-striped table-hover table-bordered gytable  mart20" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ trans('message.id') }}</th>
                            <th>{{ trans('message.title') }}</th>
                            <th>{{ trans('message.image') }}</th>
                            <th>{{ trans('message.url') }}</th>
                            <th>{{ trans('message.created_at') }}</th>
                            <th>{{ trans('message.updated_at') }}</th>
                            <th>{{ trans('message.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.box-header -->
            </div>

            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div>
        <input type="hidden" id="export" value="" />
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            topic_image_page.init();
        });
    </script>
@endsection

