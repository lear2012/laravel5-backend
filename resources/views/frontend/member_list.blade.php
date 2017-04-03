@extends('frontend.layouts.master')

@section('styles')
@endsection
@section('content')
<div class="homepage">
    <header>
        <h2>老司机</h2>
        @if(Auth::user())
            <a href="{{ route('wechat.profile', ['id' => $loginUser->uid]) }}"><i class="user-icon" ></i></a>
        @else
            <a href="{{ route('wechat.member_register') }}"><span class="join">加入</span></a>
        @endif
        <div class="swiper-container" id="expdriver_list">

            <div class="swiper-wrapper">
                @foreach($expDrivers as $user)
                    <div class="swiper-slide">
                        <img src="{{ ($user && $user->profile) ? $user->profile->avatar : config('custom.default_avatar') }}" class="main-img" id="user{{$user->uid}}" />
                    </div>
                @endforeach
            </div>

        </div>
        <div class="info" id="info_board">
            <p class="name">
                <span class="username"></span>
                <img class="sex" src="" />
            </p>
            <P class='Wechat-number text-hidden'></P>
            <div class="Age-job">
                <span class="age"></span>
                <span class="vehicle"></span>
            </div>
            <p class="autograph text-hidden">
            </p>
        </div>

    </header>

    <section>
        <h2>可野人</h2>
        <ul class="user-list">
            @if(Auth::user() && Auth::user()->hasRole('paid_member'))
                <li class="bor-color">
                    <a href="{{ route('wechat.profile', ['id' => $loginUser->uid]) }}"><img src="{{ $loginUser ? $loginUser->profile->avatar : $loginUser->avatar }}" /></a>
                    <p>{{ $loginUser->username }}</p>
                    <span>{{ $loginUser->profile->keye_age > 0 ? $loginUser->profile->keye_age.'可野龄' : '&nbsp;' }}</span>
                </li>
            @elseif(Auth::user() && Auth::user()->hasRole('register_member'))
                <li>
                    <div class='add-bg'>
                        <a href="{{ route('wechat.edit_profile', ['id' => $loginUser->uid]) }}">+</a>
                    </div>
                    <img src="{{ $loginUser->avatar }}" />
                    <p>{{ $loginUser->nickname }}</p>
                    <span><a href="{{ route('wechat.edit_profile', ['id' => $loginUser->uid]) }}">加入可野人</a></span>
                </li>
            @else
                <li>
                    <div class='add-bg'>
                        <a href="{{ route('wechat.member_register') }}">+</a>
                    </div>
                    <img src="{{ $loginUser->avatar }}" />
                    <p>{{ $loginUser->nickname }}</p>
                    <span>&nbsp;</span>
                </li>
            @endif
            @foreach($paidMembers as $user)
                @if($user->uid != $loginUser->uid)
                <li>
                    <a href="{{ route('wechat.profile', ['id' => $user->uid]) }}"><img src="{{ ($user && $user->profile) ? $user->profile->avatar : config('custom.default_avatar') }}" /></a>
                    <p>{{ ($user && $user->profile->wechat_no) ? $user->profile->wechat_no : '&nbsp;' }}</p>
                    <span>{{ ($user && $user->profile->keye_age > 0) ? $user->profile->keye_age.'可野龄' : '&nbsp;' }}</span>
                </li>
                @endif
            @endforeach
        </ul>
    </section>

    <footer>

    </footer>
</div>
@endsection
@section('scripts')
@endsection
