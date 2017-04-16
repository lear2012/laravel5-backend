<div class="form-group">
    {!! Form::label('username', '用户名', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => '用户名']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('email', 'Email', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
    </div>
</div><!--form control-->

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
    {!! Form::label('real_name', '真实姓名', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('real_name', (isset($user->profile) ? $user->profile->real_name : ''), ['class' => 'form-control', 'placeholder' => '真实姓名']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label">性别</label>
    <div class="col-lg-3">
        @if(isset($user->id))
            <input type="checkbox" value="{{$user->sex}}" id="sex" name="sex" {{$user->sex == 1 ? 'checked' : ''}}/>
        @else
            <input type="checkbox" value="1" name="sex" checked/>
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('id_no', '身份证号码', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('id_no', (isset($user->profile) ? $user->profile->id_no : ''), ['class' => 'form-control', 'placeholder' => '身份证号码']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('mobile', '手机号码', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('mobile', (isset($user->mobile) ? $user->mobile : ''), ['class' => 'form-control', 'placeholder' => '手机号码']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('member_no', '会员编号', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('member_no', (isset($user->profile) ? $user->profile->member_no : ''), ['class' => 'form-control', 'placeholder' => '会员编号']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('keye_age', '可野龄', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('keye_age', (isset($user->profile) ? $user->profile->keye_age : ''), ['class' => 'form-control', 'placeholder' => '可野龄(按年计算)']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('quotation', '说句啥吧', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-6">
        {!! Form::text('quotation', (isset($user->profile) ? $user->profile->quotation : ''), ['class' => 'form-control', 'placeholder' => '说句啥吧']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('avatar', '头像', ['class' => 'col-lg-2 control-label static-label']) !!}
    <div class="col-lg-6">
        <div class="clearfix">
            <input type="file" name="file" id="file"  class="col-xs-10 col-sm-5" />
            <input type="hidden" name="avatar" id="avatar" value="" />
        </div>
    </div>
</div>


<div class="form-group">
    {!! Form::label('nest_info', '个人页面模板', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-8">
        <div class="clearfix">
            {!! isset($user->profile) ? UEditor::content($user->profile->nest_info, ['id' => 'nest_info', 'name' => 'nest_info']) : UEditor::content('', ['id' => 'nest_info','name' => 'nest_info']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label">角色</label>
    <div class="col-lg-3">
        <select id="role_selection" class="form-control role-select" multiple="multiple" name="assignees_roles[]">
        @if (count($roles) > 0)
            @foreach($roles as $role)
                <option value="{{$role->id}}" {{in_array($role->id, $userRoles) ? 'selected' : ''}}>{!! $role->display_name !!}</option>
            @endforeach
        @endif
        </select>
    </div>
</div><!--form control-->
<div class="form-group">
    <label class="col-lg-2 control-label">是否推至首页</label>
    <div class="col-lg-3">
        @if(isset($user->id))
            <input type="checkbox" value="{{$user->is_front}}" id="is_front" name="is_front" {{$user->is_front == 1 ? 'checked' : ''}}/>
        @else
            <input type="checkbox" value="1" name="is_front" checked/>
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">是否启用</label>
    <div class="col-lg-3">
        @if(isset($user->id))
            <input type="checkbox" value="{{$user->getOriginal('status')}}" id="status" name="status" {{$user->getOriginal('status') == 1 ? 'checked' : ''}}/>
        @else
            <input type="checkbox" value="1" name="status" checked/>
        @endif
    </div>
</div><!--form control-->
@if(isset($user->id))
    <input type="hidden" name="id" value="{{$user->id}}" />
    <input type="hidden" name="role_ids" id="role_ids" value="{{$roleIds}}" />
@else
    <input type="hidden" name="role_ids" id="role_ids" value="" />
@endif

@section('scripts')
    {!! UEditor::js() !!}
    <script type="text/javascript">
        $(function () {
            var page_img = '{!! isset($user->profile->avatar) ? $user->profile->avatar : '' !!}';
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
                @if(isset($user->profile->avatar))
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
