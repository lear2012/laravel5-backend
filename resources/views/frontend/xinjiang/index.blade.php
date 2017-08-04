@extends('frontend.layouts.xinjiang')

@section('content')
    <div class="swiper-container swiper-v">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide-1"></div>
            <div class="swiper-slide slide-2">
                <video id="video" controls class="video-js vjs-default-skin vjs-big-play-centered" preload="auto" data-setup='{"poster":"http://keye.liaollisonest.com/images/xinjiang/slide-1.jpg"}'>
                    <source src="./video/video.mp4" type="video/mp4">
                </video>
                <div class="video-wrap"></div>
                <span class="next hide" id="video-next"></span>
            </div>
            <div class="swiper-slide slide-3-0">
                <img src="images/xinjiang/slide-3-0-1.png" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.3s"/>
            </div>
            <div class="swiper-slide slide-3-1">
                <img src="images/xinjiang/slide-3-1-1.png" class="text1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"/>
                <img src="images/xinjiang/slide-3-1-2.png" class="text2 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"/>
            </div>
            <div class="swiper-slide slide-3-2">
                <img src="images/xinjiang/slide-3-2-1.png" class="text1 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"/>
                <img src="images/xinjiang/slide-3-2-2.png" class="text2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"/>
            </div>
            <div class="swiper-slide slide-3-3">
                <img src="images/xinjiang/slide-3-3-1.png" class="text1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"/>
                <img src="images/xinjiang/slide-3-3-2.png" class="text2 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"/>
            </div>
            <div class="swiper-slide slide-3-4">
                <img src="images/xinjiang/slide-3-4-1.png" class="text1 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"/>
                <img src="images/xinjiang/slide-3-4-2.png" class="text2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"/>
                <span class="next"></span>
            </div>

            <div class="swiper-slide slide-4">
                <span class="button1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"></span>
                <span class="button2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.5s" swiper-animate-delay="0.5s"></span>
                <div class="sign-up">
                    <img class="title" src="images/xinjiang/title-1.png" alt="">
                    <span class="icon-close"></span>
                    <div class="form">
                        <input type="text" placeholder="姓名" id="name">
                        <input type="text" placeholder="联系方式" id="mobile">
                        <input type="text" placeholder="微信号" id="wechat_no">
                        <input type="text" placeholder="车型" id="brand">
                        <div class="submit" id="selfreg_submit">提交信息</div>
                    </div>
                </div>
                <div class="recruit">
                    <img class="title" src="images/xinjiang/title-2.png" alt="">
                    <span class="icon-close"></span>
                    <div class="form">
                        <p class="form-text">若你也喜欢自驾旅游，并且有视频拍摄经验欢迎加入与可野一起记录环中国边境线新疆段食色之旅可野负责你的车辆食宿，你负责沿途拍摄记录</p>
                        <input type="text" placeholder="姓名" id="name">
                        <input type="text" placeholder="联系方式" id="mobile">
                        <div class="submit" id="camera_reg_submit">提交信息</div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide slide-5">
                <p class="info">感谢您参与本活动，稍后我们会与您联系！</p>
                <a class="button" href="http://keye.liaollisonest.com/roundchina"></a>
                <p class="contact">联系方式：151-0118-5962</p>
            </div>
        </div>
    </div>
@endsection
