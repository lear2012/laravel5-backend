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
<script>

</script>