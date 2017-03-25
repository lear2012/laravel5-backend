@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
<div class="information">
    <section>
        <div>
            <img class="portrait" src="{{ $user->profile->avatar }}" />
            <a href="{{ route('wechat.edit_profile', ['id' => $user->uid]) }}"><span class="join">编辑</span></a>
        </div>
        <div class="info">
            <p class="name">
                <span>{{ $user->username }}</span>
                <img src="{{ $user->profile->sex == 1 ? '/img/m.png' : '/img/f.png' }}"/>
            </p>
            <P class='Wechat-number text-hidden'>{{ $user->profile->wechat_no }}</P>
            <div class="Age-job">
                <span class="age">{{ $user->profile->keye_age ? $user->profile->keye_age.'可野龄' : '' }}</span>
                <span class="vehicle">{{ $user->vehicle }}</span>
            </div>
            @if($user->profile->quotation)
            <p class="autograph ">
                <img src="/img/yinh.png"/>
                {{ $user->profile->quotation }}
            </p>
            @endif
        </div>

    </section>
    @if($user->hasRole('exp_driver') && $user->profile->nest_info)
    <hr />
    <footer>
        <div id="nest_info">
            {!! $user->profile->nest_info !!}
        </div>
    </footer>
    @endif
</div>
@endsection

@section('scripts')

@endsection
