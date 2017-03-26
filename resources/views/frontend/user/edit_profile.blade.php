@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
    <div class="JoinKY">
        <header>
            <img class="portrait" src="{{ $user->profile->avatar }}" />
            <p class="name">
                <span>{{ $user->username }}</span>
                <img src="{{ $user->profile->sex == 1 ? '/img/m.png' : '/img/f.png' }}"/>
            </p>
            <P class='Wechat-number text-hidden'>{{ $user->profile->wechat_no }}</P>
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
                    <a class="But" href="javascript:;" id="id_verify_btn">实名认证</a>
                </li>
                <li class="sel-left carinfo">
                    <label>
                        <span class="tit-s">车辆信息</span>
                        <input readonly="readonly" class="Ainp" type="" name="vehicle" id="vehicle" value="{{$user->vehicle}}" />
                    </label>
                </li>
                <li>
                    <label>
                        <span class="tit-s">收货地址</span>
                        <input placeholder="选填" class="Ainp" type="" name="address" id="address" value="{{$user->address}}" />
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
            <button class="submit" id="register_btn">保存</button>

        </section>
        <div class="Vehicle-information">
            <ul class="form">
                <li class="sel-left brand">
                    <label>
                        <span class="tit-s ">品牌</span>
                        <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                    </label>
                </li>
                <li class="sel-left">
                    <label>
                        <span class="tit-s">车系</span>
                        <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                    </label>
                </li>
                <li class="sel-left">
                    <label>
                        <span class="tit-s">型号</span>
                        <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                    </label>
                </li>
                <li class="sel-left">
                    <label>
                        <span class="tit-s">使用时间</span>
                        <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                    </label>
                </li>
            </ul>
        </div>
        <div class="brandBox">
            {{--<label class="search-box">--}}
                {{--<input placeholder="搜索" class="Ainp search" type="" name="" id="" value="" />--}}
                {{--<span class="tit-s search-but">搜索</span>--}}
            {{--</label>--}}
            <div class="brandList"></div>
        </div>
        <div class="seriesBox"></div>
        <div class="motomodelBox"></div>
    </div>
@endsection

@section('scripts')

@endsection
