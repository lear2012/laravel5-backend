@extends('backend.layouts.master')

@section('title', '路段管理')

@section('styles')
    <!-- DataTables -->
@endsection

@section('page_title')
    路段管理
@endsection

@section('page_description')
    路段列表
@endsection

@section('breadcrumb')
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">路段管理</a></li>
        <li class="active">路段列表</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                        <a href="/admin/keyeroutes/create" class="btn bg-purple btn-flat margin"><i class="fa fa-plus"></i>添加路段</a>
                    </h3>
                </div>
                <div class="table-responsive padding15 mart12">
                    <table id="dataTable" class="table table-striped table-hover table-bordered gytable  mart20" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ trans('message.id') }}</th>
                            <th>{{ trans('message.route_title') }}</th>
                            <th>{{ trans('message.route_start') }}</th>
                            <th>{{ trans('message.route_end') }}</th>
                            <th>{{ trans('message.cover_img') }}</th>
                            <th>{{ trans('message.route_url') }}</th>
                            <th>{{ trans('message.ord') }}</th>
                            <th>{{ trans('message.votes') }}</th>
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
            routes_page.init();
        });
    </script>
@endsection

