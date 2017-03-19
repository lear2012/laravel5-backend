@extends('frontend.layouts.master')
@section('title')
可野会员注册
@endsection
@section('styles')
@endsection
@section('content')
<div class="register">
    <header>
        <img class="portrait" src="{{ $wechatUser->avatar }}" />
        <p class="sign">{{ $wechatUser->nickname }}</p>
    </header>
    <section style="padding-bottom: 2.4rem;">
            <ul class="form">
                <li>
                    <label>
                        <span class="tit-s">姓名</span>
                        <input class="Ainp" type="" name="nick" id="nick" value="" />
                    </label>
                </li>
                <li>
                    <label>
                        <span class="tit-s">手机号</span>
                        <input class="phone" type="" name="mobile" id="mobile" value="" />
                    </label>
                    <a class="But" href="javascript:;" id="send_sms_btn">发送验证码</a>
                    <span id="timer">
                        <span class="timer"></span><span class="timer_text">秒后可重新发送</span>
                    </span>
                </li>
                <li>
                    <label>
                        <span class="tit-s">验证码</span>
                        <input class="Ainp" type="" name="mb_verify_code" id="mb_verify_code" value="" />
                    </label>
                </li>
                <li>
                    <label>
                        <span class="tit-s">邀请码</span>
                        <input placeholder="选填" class="Ainp" type="" name="invite_no" id="invite_no" value="" />
                    </label>
                </li>
                <li>
                    <div id="captcha_label">
                        <input placeholder="图片校验码" class="Ainp" type="" name="captcha" id="captcha" value="" />
                        <img src="{!! captcha_src() !!}" class="captcha" title="看不清？点击换另一张" alt="验证码" />
                    </div>
                </li>

            </ul>
            <div class="Agreement">
                <div class="Radiobox" id="cki">
                    <i class="Radio"></i>
                    <span>同意</span><a id="Agreement">会员规则</a>
                </div>
            </div>
            <input type="hidden" name="agee" id="agree" value="1" />
            <button class="submit" id="register_btn">提交成为会员</button>

    </section>

    <ul class="select">
        <li></li>
    </ul>
</div>
@endsection

@section('scripts')
@endsection