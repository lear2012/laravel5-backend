@extends('frontend.layouts.master')

@section('styles')
@endsection
@section('content')
<header>
    <h2>老司机</h2>
    <div class="swiper-container">
        <i class="swiper-button-next"></i>
        <div class="swiper-wrapper">
            @foreach($expDrivers as $user)
                <div class="swiper-slide"><a href="{{ route('wechat.profile', ['id' => $user->uid]) }}"><img src="{{ ($user && $user->profile) ? $user->profile->avatar : config('custom.default_avatar') }}" class="main-img" id="user{{$user->uid}}"></a></div>
            @endforeach
        </div>
        <i class="swiper-button-prev"></i>
    </div>
    <div class="info" id="info_board">
        <p class="name"></p>
        <div class="Age-job">
            <span class="vehicle"></span>
            <span class="age">12</span>
        </div>
        <p class="autograph"></p>
    </div>
</header>

<section>
    <h2>可野人</h2>
    <ul class="user-list">
        @foreach($paidMembers as $user)
            <li>
                <img src="{{ ($user && $user->profile) ? $user->profile->avatar : '' }}" />
                <p>{{ ($user && $user->profile) ? $user->profile->wechat_no : '' }}</p>
                <span>{{ ($user && $user->profile) ? $user->profile->keye_age : '' }}</span>
            </li>
        @endforeach
    </ul>
</section>

<footer>

</footer>
@endsection
@section('scripts')
@endsection