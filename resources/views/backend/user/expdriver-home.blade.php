@extends('backend.layouts.master')

@section('title', '编辑个人主页')

@section('styles')
    {!! UEditor::css() !!}
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-fileinput/css/fileinput.min.css') }}">
@endsection

@section('breadcrumb')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="/admin/dashboard">主页</a></li>
    <li><a>老司机专栏</a></li>
    <li>编辑个人主页</li>
@endsection

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑个人主页</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    {!! Form::model($user, ['route' => ['admin.expdriver.decorate.store'], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true]) !!}
                    {!! Form::hidden('_method', 'PUT') !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('username', '用户名', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-3">
                                <label class="static-text">{{ $user->username }}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('real_name', '真实姓名', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-3">
                                {!! Form::text('real_name', (isset($user->userProfile) ? $user->userProfile->real_name : ''), ['class' => 'form-control', 'placeholder' => '真实姓名']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', '密码', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-3">
                                <input type="password" placeholder="密码" id="password" name="password" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password_confirmation', '重复密码', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-3">
                                <input type="password" placeholder="请再次输入密码" id="password_confirmation" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('id_no', '身份证号码', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-3">
                                {!! Form::text('id_no', (isset($user->userProfile) ? $user->userProfile->id_no : ''), ['class' => 'form-control', 'placeholder' => '身份证号码']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('mobile', '手机号码', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-3">
                                {!! Form::text('mobile', (isset($user->userProfile) ? $user->userProfile->mobile : ''), ['class' => 'form-control', 'placeholder' => '手机号码']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('keye_age', '可野龄', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-3">
                                {!! Form::text('keye_age', (isset($user->userProfile) ? $user->userProfile->keye_age : ''), ['class' => 'form-control', 'placeholder' => '可野龄(按年计算)']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('quotation', '说句啥吧', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-6">
                                {!! Form::text('quotation', (isset($user->userProfile) ? $user->userProfile->quotation : ''), ['class' => 'form-control', 'placeholder' => '说句啥吧']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('avatar', '头像', ['class' => 'col-lg-2 control-label static-label']) !!}
                            <div class="col-lg-6">
                                <div class="clearfix">
                                    <input type="file" name="file" id="file"  class="col-xs-10 col-sm-5" />
                                    <input type="hidden" name="avatar" id="avatar"  value="{!! isset($user->userProfile->avatar) ? $user->userProfile->avatar : '' !!}" />
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            {!! Form::label('nest_info', '个人页面模板', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-8">
                                <div class="clearfix">
                                    {!! isset($user->userProfile) ? UEditor::content($user->userProfile->nest_info, ['id' => 'nest_info', 'name' => 'nest_info']) : UEditor::content('', ['id' => 'nest_info','name' => 'nest_info']) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete">删除</button>--}}
                        <a href="{{route('admin.auth.user.index')}}" class="btn bg-purple btn-flat margin">{{ trans('strings.return_button') }}</a>
                        <input type="submit" class="btn bg-purple btn-flat margin  pull-right" value="{{ trans('strings.save_button') }}" />
                    </div>
                    <!-- /.box-footer -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        {{-- Confirm Delete --}}
        @include('backend.layouts.partials.delete_modal', array('action' => route('admin.auth.user.destroy', $user->id)))
    </div>
@endsection

@section('scripts')
    {!! UEditor::js() !!}
    <script src="{{ asset('plugins/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-fileinput/js/locales/zh.js') }}"></script>

    {{--<script src="{{ asset('js/jquery-validate/jquery.validate.js') }}"></script>--}}
    {{--<script src="{{ asset('js/jquery-validate/additional-methods.js') }}"></script>--}}
    {{--<script src="{{ asset('js/jquery-validate/messages_zh.js') }}"></script>--}}

    <script type="text/javascript">
        $(function () {
            var page_img = '{!! isset($user->userProfile->avatar) ? $user->userProfile->avatar : '' !!}';
            $('#file').fileinput({
                language: 'zh',
                uploadUrl: "/admin/upload/avatar",
                uploadExtraData: {_token: '{{ csrf_token() }}'},
                initialCaption: "请选择头像",
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
                @if(isset($user->userProfile->avatar))
                initialPreview: [
                    page_img
                ],
                initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                initialPreviewFileType: 'image' // image is the default and can be overridden in config below
                @endif
            }).on('fileuploaded', function(event, data, previewId, index) {
                var response = data.response;
                $('#avatar').val(response.data.image_path);
            });
        });
        var ue = UE.getEditor('nest_info', {
            initialFrameHeight: 360
        }); //用辅助方法生成的话默认id是ueditor
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>
@endsection


