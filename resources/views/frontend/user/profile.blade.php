@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
<div id="img-full-view">
    <span class="modal-close-btn"></span>
    <img src="" />
</div>
<div class="information">
    <section>
        <div>
            <img class="portrait" src="{{ $user->profile->avatar }}" />
            @if(Auth::user() && Auth::user()->uid == $user->uid && Auth::user()->hasRole('paid_member'))
                <a href="{{ route('wechat.edit_profile', ['id' => $user->uid]) }}"><span class="join">编辑</span></a>
            @elseif(Auth::user() && Auth::user()->uid == $user->uid && Auth::user()->hasRole('register_member'))
                <a href="{{ route('wechat.edit_profile', ['id' => $user->uid, 'paying' => 1]) }}"><span class="join">加入可野人</span></a>
            @endif
            <img src="/img/left-arrow.png" class="return" />
        </div>
        <div class="info">
            <p class="name">
                <span>{{ $user->username }}</span>
                <img src="{{ $user->profile->sex == 1 ? '/img/m.png' : '/img/f.png' }}"/>
                @if($user->profile->is_verified)
                <span class="verified"></span>
                @endif
            </p>
            <p class='Wechat-number text-hidden'>{{ $user->profile->wechat_no }}</p>
            <div class="Age-job">
                <span class="age">{{ $user->profile->keye_age ? $user->profile->keye_age.'可野龄' : '' }}</span>
                <span class="car_no">{{ $user->profile->member_no }}</span>
            </div>
            <div>
                <span class="vehicle">{{ $user->vehicle }}</span>
            </div>
            @if($user->profile->quotation)
            <p class="autograph ">
                <img src="/img/yinh.png"/>
                {{ $user->profile->quotation }}
            </p>
            @endif
        </div>
        <div class="swiper-container" id="car_img_list">
            <div class="swiper-wrapper">
                @foreach($carImgs as $img)
                    <div class="swiper-slide">
                        <img src="{{$img}}" class="main-img" />
                    </div>
                @endforeach
            </div>
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
