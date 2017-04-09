@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
    <div class="JoinKY">
        <header>
            <div>
                <img class="portrait" src="{{ $user->profile->avatar }}" />
                <img src="/img/left-arrow.png" class="return" />
            </div>
            <div class="info">
                <p class="name">
                    <span>{{ $user->username }}</span>
                    <img src="{{ $user->profile->sex == 1 ? '/img/m.png' : '/img/f.png' }}"/>
                    <span class="{{ $user->profile->is_verified ? 'verified' : '' }}" id="verified"></span>
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
                <li id="carno_notice">
                    <label>
                        <img src="{{asset('img/notice.png')}}" />
                        <ul>
                            <li>成为付费会员，我们会在俱乐部基地定制您的纪念车牌</li>
                        </ul>
                    </label>
                </li>
                <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                <li id="car_img_li">
                    <label>
                        <span class="tit-s">爱车风采</span>
                        <input class="Ainp inputfile" type="file" name="file[]" id="file" data-multiple-caption="{count}张图片选中" multiple />
                        <label for="file">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg>
                            <span class="static-text">请选择爱车图片</span>
                        </label>
                        <div class="loading ball-clip-rotate-multiple">
                            <div></div>
                            <div></div>
                        </div>
                    </label>
                </li>
                <li id="car_preview">
                    <label>
                        <span class="tit-s">&nbsp;</span>
                        <span id="car_img_preview"></span>
                    </label>
                </li>
                </form>
                @if($user->hasRole('register_member'))
                <li>
                    <label>
                        <span class="tit-s">邀请码</span>
                        <input class="Ainp" type="" name="invite_no" id="invite_no" value="{{$user->profile->invite_no}}" />
                    </label>
                </li>
                <li id="carno_notice">
                    <label>
                        <img src="{{asset('img/notice.png')}}" />
                        <ul>
                            <li>输入邀请码，1元即可成为可野人。</li>
                        </ul>
                    </label>
                </li>
                @endif
                @if($user->hasRole('paid_member'))
                <li class="member_no_li">
                    <label>
                        <span class="tit-s">可野会员编号</span>
                        @if($user->profile->member_no)
                            <span class="static-text">{{ $user->profile->member_no }}</span>
                        @else
                            <span class="member_no_prefix">KY.88</span>
                            <input class="Ainp" type="" name="member_no" id="member_no" value="{{substr($user->profile->member_no, 5)}}" />
                        @endif
                    </label>
                </li>
                @endif
                <li>
                    <label>
                        <span class="tit-s">收货地址</span>
                        <input placeholder="选填" class="Ainp" type="" name="address" id="address" value="{{$user->profile->address}}" />
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
                <li class="quotation">
                    <label>
                        <span class="tit-s">个性签名</span>
                        <input class="Ainp" type="" name="quotation" id="quotation" value="{{$user->profile->quotation}}" size="30"/>
                    </label>
                </li>
                @endif
            </ul>
            <div class="Agreement">
                <div class="Radiobox" id="cki">
                    <i class="Radio"></i>
                    <span>自取</span>
                </div>
            </div>
            <input type="hidden" name="self_get" id="self_get" value="1" />
            <input type="hidden" name="car_imgs" id="car_imgs" value="{{$user->profile->car_imgs}}" />
            <input type="hidden" name="uid" id="uid" value="{{$user->uid}}" />
            <button class="submit" id="save_profile_btn">保存</button>

        </section>
        <div class="Vehicle-information">
            <div class="myselect-close"><img src="/img/left-arrow.png" class="vehicle-close"></div>
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
                            <span class="tit-s">车型</span>
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
            <div class="myselect-close"><img src="/img/left-arrow.png" class="myselect-close"></div>
            <div class="brandList"></div>
        </div>
        <div class="seriesBox selectBox">
            <div class="myselect-close"><img src="/img/left-arrow.png" class="myselect-close"></div>
            <div class="seriesList"></div>
        </div>
        <div class="dateBox selectBox">
            <div class="myselect-close"><img src="/img/left-arrow.png" class="myselect-close"></div>
            <div class="dateList"></div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
