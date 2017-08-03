window.onload = function() {
    var startY, endY;

    // 内层swiper
    var mySwiper2 = new Swiper ('.swiper-h', {
        direction: 'horizontal',
        // loop: false,
        spaceBetween: 50,
        autoplay: 3000,
        autoplayStopOnLast: true,
        autoplayDisableOnInteraction: false,
        watchSlidesProgress: true,
        watchSlidesVisibility: true,
        observer: true,  // 解决子swiper自动播放后, 父swiper动画不能正常显示的问题
        observeParents: true, // 解决子swiper自动播放后, 父swiper动画不能正常显示的问题
        onInit: function(swiper) {
            // swiperAnimateCache(swiper); //隐藏动画元素
            // swiperAnimate(swiper); //初始化完成开始动画
        },
        onSlideChangeEnd: function(swiper){
            swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
        },
        onClick: function(swiper) {
            if(swiper.activeIndex === 4) {
                mySwiper.slideNext();
            }
        },
    });

    // 外层swiper
    var mySwiper = new Swiper ('.swiper-v', {
        direction: 'vertical',
        watchSlidesProgress: true,
        watchSlidesVisibility: true,
        observer: true,
        onInit: function(swiper) {
            // swiperAnimateCache(swiper); //隐藏动画元素
            swiperAnimate(swiper); //初始化完成开始动画
        },
        onSlideChangeEnd: function(swiper){
            swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画

            // 荐路者
            if(swiper.activeIndex === 2) {
                mySwiper2.startAutoplay();
            }else {
                mySwiper2.stopAutoplay();
                mySwiper2.slideTo(0);
            }

            if(swiper.activeIndex == 1) {
                $('#video').show();
                player.play();
                player.pause();
                player.play();
            }else {
                // $('#video').show();
                player.pause();
            }
        },
        onSlideChangeStart: function(swiper){
        },
        onClick: function(swiper) {
            if(swiper.activeIndex === 0) {
                mySwiper.slideNext();
            }else if(swiper.activeIndex === 1) {
                if($('#video').css('display') === 'none') {
                    mySwiper.slideNext();
                }
            }
        },
    });



    mySwiper2.stopAutoplay();

    // 报名
    var $signUp = $('.sign-up');

    $('.button1').on('click', function() {
        $signUp.show().addClass('slide-left');
    });

    $('.sign-up .icon-close').on('click', function(event) {
        $signUp.removeClass('slide-left');
        setTimeout(function() {
            $signUp.hide();
        }, 500);
    });

    $('.sign-up .submit').on('click', function() {
        $signUp.hide();
        $('.end').show();
    });

    // 招募
    var $recruit = $('.recruit');

    $('.button2').on('click', function() {
        $recruit.show().addClass('slide-left');
    });

    $('.recruit .icon-close').on('click', function(event) {
        $recruit.removeClass('slide-left');
        setTimeout(function() {
            $recruit.hide();
        }, 500);
    });

    $('.recruit .submit').on('click', function() {
        $recruit.hide();
        $('.end').show();
    });

    // 视频
    // var player = new EZUIPlayer('video');
    //
    // player.on('play', function(){
    //   console.log('play');
    //   // $('.video-wrap').show();
    // });
    // player.on('pause', function(){
    //   console.log('pause');
    // });
    // player.on('ended', function(){
    //   console.log('ended');
    // });
    var player = videojs('video', {autoplay: false}, function onPlayerReady() {
        // player.enterFullscreen();
        // player.enterFullWindow();
        //this.play();
        this.load();
        console.log('play');
    });

    player.on('ended', function() {
        // console.log('ended');
        player.exitFullWindow();
        player.exitFullscreen(); // ios取消全屏
        player.currentTime(0);
        $('#video').hide();
    });
};
