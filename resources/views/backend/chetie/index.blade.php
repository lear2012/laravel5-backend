@extends('backend.layouts.master')

@section('title', '自驾报名列表')

@section('styles')
    <!-- DataTables -->
@endsection

@section('page_title')
    车贴申请列表
@endsection

@section('page_description')
    车贴申请列表
@endsection

@section('breadcrumb')
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">报名及车贴管理</a></li>
        <li class="active">车贴申请列表</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="box box-success">
                <div class="box-header">

                </div>
                <!-- /.box-header -->
                <div class="table-responsive padding15 mart12">
                    <table id="dataTable" class="table table-striped table-hover table-bordered gytable  mart20" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ trans('message.id') }}</th>
                            <th>{{ trans('message.name') }}</th>
                            <th>{{ trans('message.mobile') }}</th>
                            <th>{{ trans('message.brand') }}</th>
                            <th>{{ trans('message.route_start') }}</th>
                            <th>{{ trans('message.route_end') }}</th>
                            <th>{{ trans('message.address') }}</th>
                            <th>{{ trans('message.detail') }}</th>
                            <th>{{ trans('message.created_at') }}</th>
                            <th>{{ trans('message.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

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
            chetie_page.init();
        });
    </script>
@endsection

