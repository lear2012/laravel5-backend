<div class="form-group">
    {!! Form::label('title', '轮播图标题', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => '轮播图标题']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('cover_img', '图片', ['class' => 'col-lg-2 control-label static-label']) !!}
    <div class="col-lg-6">
        <div class="clearfix">
            <input type="file" name="file" id="file"  class="col-xs-10 col-sm-5" />
            <input type="hidden" name="cover_img" id="cover_img" value="" />
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('url', '链接url', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-3">
        {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'http://']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">是否启用</label>
    <div class="col-lg-3">
        @if(isset($item->id))
            <input type="checkbox" value="{{$item->getOriginal('active')}}" id="active" name="active" {{$item->getOriginal('active') == 1 ? 'checked' : ''}}/>
        @else
            <input type="checkbox" value="1" name="active" checked/>
        @endif
    </div>
</div><!--form control-->
@if(isset($item->id))
    <input type="hidden" name="id" value="{{$item->id}}" />
@else
    <input type="hidden" />
@endif

@section('scripts')
    {!! UEditor::js() !!}
    <script type="text/javascript">
        $(function () {
            site.init_checkbox();
            var page_img = '{!! isset($item->cover_img) ? $item->cover_img : '' !!}';
            $('#file').fileinput({
                language: 'zh',
                uploadUrl: "/admin/upload/map",
                uploadExtraData: {_token: '{{ csrf_token() }}'},
                initialCaption: "请选择图像",
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
                @if(isset($item->cover_img))
                initialPreview: [
                    page_img
                ],
                initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                initialPreviewFileType: 'image' // image is the default and can be overridden in config below
                @endif
            }).on('fileuploaded', function(event, data, previewId, index) {
                var response = data.response;
                $('#cover_img').val(response.data.image_path);
            });
        });

    </script>
@endsection
