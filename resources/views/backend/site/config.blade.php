@extends('backend.layouts.master')

@section('title', '设置首页地图')

@section('styles')

@endsection

@section('breadcrumb')
    <li>
        <i class="ace-icon fa fa-home home-icon"></i>
        <a href="/admin/dashboard">主页</a>
    </li>
    <li>
        <a>设置</a>
    </li>
    <li>
        设置首页地图
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">设置首页地图</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => 'admin.site.store_config', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('map_img', '首页地图图片', ['class' => 'col-lg-2 control-label static-label']) !!}
                        <div class="col-lg-6">
                            <div class="clearfix">
                                <input type="file" name="file" id="file"  class="col-xs-10 col-sm-5" />
                                <input type="hidden" name="map_img" id="map_img" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <input type="submit" class="btn bg-purple btn-flat margin pull-right" value="{{ trans('strings.save_button') }}" />
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            var page_img = '{!! isset($siteConfig['map_img']) ? $siteConfig['map_img'] : '' !!}';
            $('#file').fileinput({
                language: 'zh',
                uploadUrl: "/admin/upload/map",
                uploadExtraData: {_token: '{{ csrf_token() }}'},
                initialCaption: "请选择首页地图",
                allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
                maxFilePreviewSize: 10240,
                dropZoneTitle: '',
                showClose: false,
                layoutTemplates: {
                    progress: '',
                    footer:''
                },
                previewSettings: {
                    image: {width: "100px", height: "160px"},
                    html: {width: "213px", height: "160px"},
                    text: {width: "160px", height: "136px"},
                    video: {width: "213px", height: "160px"},
                    audio: {width: "213px", height: "80px"},
                    flash: {width: "213px", height: "160px"},
                    object: {width: "213px", height: "160px"},
                    other: {width: "160px", height: "160px"}
                },
                caption: '<div tabindex="-1" class="form-control file-caption {class}"></div>',
                @if(isset($siteConfig['map_img']))
                initialPreview: [
                    page_img
                ],
                initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                initialPreviewFileType: 'image' // image is the default and can be overridden in config below
                @endif
            }).on('fileuploaded', function(event, data, previewId, index) {
                var response = data.response;
                $('#map_img').val(response.data.image_path);
            });
        });

    </script>
@endsection

