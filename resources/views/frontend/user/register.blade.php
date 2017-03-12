@extends('frontend.layouts.master')
@section('title')
可野会员注册
@endsection
@section('styles')
@endsection
@section('content')
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

    <div class="aleat" id="reg_success">
        <div class="aleat-submit">
            <img src="/img/success_icon@2X.png" />
            <p>入会成功</p>
            <p>付费可正式成为可野人</p>
            <button class="close">再逛逛</button>
            <button>我付费,我光荣！</button>
        </div>
    </div>
    <div class="aleat" id="reg_fail">
        <i class="close closeX">关闭</i>
        <div id="modal-content">
            <div class="aleat-submit">
                <img src="/img/success_icon@2X.png" />
                <p>注册失败</p>
                <p id="err_msg"></p>
            </div>
        </div>
    </div>

    <div class="aleat aleat-Agreement">
        <p>会员规则</p>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        alert(config);
        site.setRegisterPayConfig(config);
    });
//    var arrXB = [
//        {
//            text:'女',
//            code:0
//        },
//        {
//            text:'男',
//            code:1
//        }
//    ];

    //聚焦改变颜色
//    $(".form input").focusin(function() {
//        $(this).prev(".tit-s").css('color','#c6401c')
//        $(this).parent().parent().css('border-color','#c6401c')
//    });
//    $(".form input").focusout(function() {
//        $(this).prev(".tit-s").css('color','#fff')
//        $(this).parent().parent().css('border-color','rgba(255,255,255,0.5)')
//    });

    //下拉
    //select(arrXB,'#xb');
    function select(data,id){
        str ='';
        for(var i =0 ; i<data.length ; i++){
            str+='<li code='+data[i].code+'>'+data[i].text+'</li>';
        }
        $('.select').html(str);
        $('.select li').bind('click',function(){
            $(id).val($(this).text());
        })
        $(id).on('click',function(event){
            $('.select').css('display','block');
            $('.select').animate({
                'bottom':'0px'
            },500);
            event.stopPropagation();
        });
        $(document).on('click',function(event){
            $('.select').animate({
                'bottom':'-20rem'
            },500,function(){
                $('.select').css('display','none');
            });
            event.stopPropagation();
        })
        $('.select li').on('click',function(){
            $('.select').animate({
                'bottom':'-20rem'
            },500,function(){
                $('.select').css('display','none');
            });
        })

    }

</script>
@endsection