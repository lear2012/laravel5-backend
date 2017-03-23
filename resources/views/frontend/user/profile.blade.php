@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
<div class="information">
    <section>
        <img class="portrait" src="{{ $user->profile->avatar }}" />
        <div class="info">
            <p class="name">
                <span>{{ $user->username }}</span>
                <img src="{{ $user->sex == 1 ? '/img/m.png' : '/img/f.png' }}"/>
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
    @if($user->hasRole('exp_driver'))
    <hr />
    <footer>
        <div id="nest_info">
            {{ $user->profile->nest_info }}
        </div>
    </footer>
    @endif
</div>
@endsection

@section('scripts')

@endsection