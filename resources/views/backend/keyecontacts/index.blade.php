@extends('backend.layouts.master')

@section('title', '商务洽谈')

@section('styles')
    <!-- DataTables -->
@endsection

@section('page_title')
    商务洽谈
@endsection

@section('page_description')
    商务洽谈列表
@endsection

@section('breadcrumb')
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">商务洽谈</a></li>
        <li class="active">商务洽谈列表</li>
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
                            <th>{{ trans('message.company_name') }}</th>
                            <th>{{ trans('message.name') }}</th>
                            <th>{{ trans('message.phone') }}</th>
                            <th>{{ trans('message.content') }}</th>
                            <th>{{ trans('message.created_at') }}</th>
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
            contacts_page.init();
        });
    </script>
@endsection

