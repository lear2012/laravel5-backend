@extends('frontend.layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
    <style>
        #captcha_label input {
        }
        #captcha_label img {
            margin-top:20px;
            cursor:pointer;
        }
        #Agreement {margin-left:5px;}
        .Radio {
            margin-right:20px;}
    </style>
@endsection
@section('content')
    <header>
        <img class="portrait" src="img/f746272283fbfc990e6c24f75fe3d917bf36f6cd30f55-4Pvaxw_fw658.jpg" />
        <p class="sign">十五字十五字十五字</p>
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
                <a class="But" href="javascript:;">发送验证码</a>
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
                    <input placeholder="图片校验码" class="Ainp" type="" name="" id="" value="" />
                    <img src="{!! captcha_src() !!}" title="看不清？点击换另一张" alt="验证码" onclick="refreshCaptcha()"/>
                </div>
            </li>

        </ul>
        <div class="Agreement">
            <div class="Radiobox">
                <i class="Radio"></i>
                <span>同意</span><a id="Agreement">会员规则</a>

            </div>
        </div>


        <button class="submit">提交成为会员</button>

    </section>

    <ul class="select">
        <li></li>
    </ul>

    <div class="aleat">
        <i class="close closeX">关闭</i>
        <div id="modal-content"></div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
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