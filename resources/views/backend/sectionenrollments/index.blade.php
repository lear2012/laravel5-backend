@extends('backend.layouts.master')

@section('title', $sectionName.'报名列表')

@section('styles')
    <!-- DataTables -->
@endsection

@section('page_title')
    {{$sectionName}}报名列表
@endsection

@section('page_description')
    {{$sectionName}}报名列表
@endsection

@section('breadcrumb')
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">报名管理</a></li>
        <li class="active">自驾报名列表</li>
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
                            <th>{{ trans('message.wechat_no') }}</th>
                            <th>{{ trans('message.brand') }}</th>
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
            section_enrollment.init();
        });
    </script>
@endsection

