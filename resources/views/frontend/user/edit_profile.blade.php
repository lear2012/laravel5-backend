@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
    <div class="JoinKY">
        <header>
            <div><img class="portrait" src="{{ $user->profile->avatar }}" /></div>
            <div class="info">
                <p class="name">
                    <span>{{ $user->username }}</span>
                    <img src="{{ $user->profile->sex == 1 ? '/img/m.png' : '/img/f.png' }}"/>
                    <span class="verified">
                    @if($user->profile->is_verified)
                    已认证
                    @endif
                    </span>
                </p>
                <p class='Wechat-number text-hidden'>{{ $user->profile->wechat_no }}</p>
            </div>
        </header>
        <section style="padding-bottom: 2.4rem;">
            <ul class="form" id="profile_form">
                <li>
                    <label>
                        <span class="tit-s">真实姓名</span>
                        <input class="Ainp" type="" name="real_name" id="real_name" value="{{$user->profile->real_name}}" />
                    </label>
                </li>
                <li>
                    <label>
                        <span class="tit-s">身份证号</span>
                        <input class="phone" type="" name="id_no" id="id_no" value="{{$user->profile->id_no}}" />
                    </label>
                    @if(!$user->profile->is_verified)
                    <a class="But" href="javascript:;" id="id_verify_btn">实名认证</a>
                    @endif
                    <span id="timer">
                        重新发送(<span class="timer"></span>)<span class="timer_text">秒后可</span>
                    </span>
                </li>
                <li class="sel-left carinfo">
                    <label>
                        <span class="tit-s">车辆信息</span>
                        <input readonly="readonly" class="Ainp" type="" name="vehicle" id="vehicle" value="{{$user->vehicle}}" />
                    </label>
                </li>
                <li>
                    <label>
                        <span class="tit-s">车牌号</span>
                        <input class="Ainp" type="" name="car_no" id="car_no" value="{{$user->profile->car_no}}" />
                    </label>
                </li>
                <li id="profile_notice">
                    <label>
                        <img src="{{asset('img/notice.png')}}" />
                        <ul>
                            <li>可野付费会员可拥有可野会员编号，目前可选择001-150之间的编号。</li>
                            <li class="not-first">可野付费会员可填写收货地址来获取会员福利，也可自取。</li>
                        </ul>
                    </label>
                </li>
                @if($user->hasRole('paid_member'))
                <li class="member_no_li">
                    <label>
                        <span class="tit-s">可野会员编号</span><span class="member_no_prefix">KY.88</span>
                        <input class="Ainp" type="" name="member_no" id="member_no" value="{{substr($user->profile->member_no, 5)}}" />
                    </label>
                </li>
                @endif
                <li>
                    <label>
                        <span class="tit-s">收货地址</span>
                        <input placeholder="选填" class="Ainp" type="" name="address" id="address" value="{{$user->profile->address}}" />
                    </label>
                </li>

            </ul>
            <div class="Agreement">
                <div class="Radiobox" id="cki">
                    <i class="Radio"></i>
                    <span>自取</span>
                </div>
            </div>
            <input type="hidden" name="self_get" id="self_get" value="1" />
            <button class="submit" id="save_profile_btn">保存</button>

        </section>
        <div class="Vehicle-information">
            <div><img src="/img/left-arrow.png" class="vehicle-close"></div>
            <div>
                <ul class="form" id="vehicle-select-form">
                    <li class="sel-left brand">
                        <label>
                            <span class="tit-s ">品牌</span>
                            <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                        </label>
                    </li>
                    <li class="sel-left series">
                        <label>
                            <span class="tit-s">车系</span>
                            <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                        </label>
                    </li>
                    <li class="sel-left motomodel">
                        <label>
                            <span class="tit-s">型号</span>
                            <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                        </label>
                    </li>
                    <li class="sel-left buy-date">
                        <label>
                            <span class="tit-s">购买时间</span>
                            <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                        </label>
                    </li>
                    <li class="complete-btn"><a href="javascript:;" id="complete-btn">完成</a></li>
                </ul>
            </div>
        </div>
        <div class="brandBox selectBox">
            {{--<label class="search-box">--}}
                {{--<input placeholder="搜索" class="Ainp search" type="" name="" id="" value="" />--}}
                {{--<span class="tit-s search-but">搜索</span>--}}
            {{--</label>--}}
            <div><img src="/img/left-arrow.png" class="myselect-close"></div>
            <div class="brandList"></div>
        </div>
        <div class="seriesBox selectBox">
            <div><img src="/img/left-arrow.png" class="myselect-close"></div>
            <div class="seriesList"></div>
        </div>
        <div class="motomodelBox selectBox">
            <div><img src="/img/left-arrow.png" class="myselect-close"></div>
            <div class="motomodelList"></div>
        </div>
        <div class="dateBox selectBox">
            <div><img src="/img/left-arrow.png" class="myselect-close"></div>
            <div class="dateList"></div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
