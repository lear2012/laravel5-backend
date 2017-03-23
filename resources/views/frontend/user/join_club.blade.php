@extends('frontend.layouts.master')
@section('title')
    可野会员注册
@endsection
@section('styles')
@endsection
@section('content')
    <div class="JoinKY">
        <header>
            <img class="portrait" src="{{ $wechatUser->avatar }}" />
            <p class="sign">{{ $wechatUser->nickname }}</p>
        </header>
        <section style="padding-bottom: 2.4rem;">
            <ul class="form" id="join_form">
                <li>
                    <label>
                        <span class="tit-s">真实姓名</span>
                        <input placeholder="真实姓名" class="Ainp" type="" name="real_name" id="real_name" value="" />
                    </label>
                </li>
                <li>
                    <label>
                        <span class="tit-s">身份证号</span>
                        <input class="Ainp" type="" name="id_no" id="id_no" value="" />
                    </label>
                </li>
                <li class="sel-left carinfo">
                    <label>
                        <span class="tit-s">车辆信息</span>
                        <input readonly="readonly" class="Ainp" type="" name="" id="" value="" />
                    </label>
                </li>
                <li>
                    <label>
						<span class="tit-s">收货地址</span>
                        <input class="Ainp" type="" name="" id="" value="" />
                    </label>
                </li>
            </ul>
            <button class="submit">提交，成为可野人</button>

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
                        <input readonly="readonly" class="Ainp" type="" name="motomodel" id="" value="" />
                    </label>
                </li>
                <li class="sel-left">
                    <label>
                        <span class="tit-s">购买时间</span>
                        <input readonly="readonly" class="Ainp" type="" name="buy_date" id="buy_date" value="" />
                    </label>
                </li>
            </ul>
        </div>
        <div class="brandBox">
            <label class="search-box">
                <input placeholder="搜索" class="Ainp search" type="" name="search" id="search" value="" />
                <span class="tit-s search-but">搜索</span>
            </label>
            <div class="brandList">

            </div>
        </div>

        <ul class="select">
            <li></li>
        </ul>
    </div>
@endsection

@section('scripts')
@endsection