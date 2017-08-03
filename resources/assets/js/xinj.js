window.onload = function() {

    var startY, endY, player;

    player = videojs('video', {autoplay: false}, function onPlayerReady() {
        this.load();
    });
    player.on('ended', function() {
        player.exitFullWindow();
        player.exitFullscreen(); // ios取消全屏
        player.currentTime(0);
        $('#video').hide();
    });

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
            } else {
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

    // $('.sign-up .submit').on('click', function() {
    //     $signUp.hide();
    //     $('.end').show();
    // });

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

    // $('.recruit .submit').on('click', function() {
    //     $recruit.hide();
    //     $('.end').show();
    // });
};

var xinjiang_activity = {

    _rid: '', // 用于thumbup的路线id

    _page: 1, // 页码

    _enrollment_id: '', // 搭车时选择的Enrollment ID

    _cars: [],

    init: function() {
        this.init_selfreg_submit();
        this.init_camera_reg_submit();
    },

    showError: function(rs) {
        swal({
            html: true,
            title: "出问题啦！",
            text: rs.msg,
            type: 'error',
            confirmButtonText: '关闭',
            confirmButtonColor: '#fc9d2b',
            cancelButtonColor: '#fc9d2b',
        });
    },

    showSuccess: function(rs) {
        swal({
            html: true,
            title: '',
            text: rs.msg,
            type: 'success',
            confirmButtonText: '关闭',
            confirmButtonColor: '#fc9d2b',
            cancelButtonColor: '#fc9d2b',
        }, function (isConfirm) {
            window.location.href = '/roundchina';
        });
    },

    errorField: function(elm) {
        elm.parent().removeClass('success');
        elm.parent().addClass('error');
    },

    successField:function(elm) {
        elm.parent().removeClass('error');
        elm.parent().addClass('success');
    },

    clearField:function(elm) {
        elm.parent().removeClass('error');
        elm.parent().removeClass('success');
    },

    clearAllField: function () {
        $('input').parent().removeClass('error');
        $('input').parent().removeClass('success');
        //$('i', $('#cki')).removeClass('checkbox_err');
    },

    init_selfreg_submit: function() {
        var that = this;
        $('#selfreg_submit').on('click', function(){
            var data = {};
            data.name = $.trim($('#name', $('.sign-up')).val());
            data.mobile = $.trim($('#mobile', $('.sign-up')).val());
            data.wechat_no = $.trim($('#wechat_no', $('.sign-up')).val());
            data.brand = $.trim($('#brand', $('.sign-up')).val());
            data.section_id = 1;
            if(!that.checkRegister(data))
                return false;
            //return;
            $.ajax({
                type: "POST",
                dataType: "json", //dataType (xml html script json jsonp text)
                data: data, //json 数据
                url: '/xinjiang/save_selfreg',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {
                        //that.showSuccess(rs);
                        $('.sign-up').fadeOut();
                        $('.end').fadeIn();
                    } else {
                        //that.showError(rs);
                        alert(rs.msg);
                        return false;
                    }
                }
            });
        });
    },

    checkRegister: function(params) {
        var that = this;
        this.clearAllField();
        if(params.name == '') {
            that.errorField($('#name', $('.sign-up')));
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            that.errorField($('#mobile', $('.sign-up')));
            return false;
        }
        return true;
    },

    init_camera_reg_submit: function() {
        var that = this;
        $('#camera_reg_submit').on('click', function(){
            var data = {};
            data.name = $.trim($('#name', $('.recruit')).val());
            data.mobile = $.trim($('#mobile', $('.recruit')).val());
            data.section_id = 1;
            console.log(data);
            if(!that.checkCameraRegister(data))
                return false;
            //return;
            $.ajax({
                type: "POST",
                dataType: "json", //dataType (xml html script json jsonp text)
                data: data, //json 数据
                url: '/xinjiang/save_camera_reg',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {
                        //that.showSuccess(rs);
                        $('.recruit').fadeOut();
                        $('.end').fadeIn();
                    } else {
                        alert(rs.msg);
                        return false;
                    }
                }
            });
        });
    },

    checkCameraRegister: function(params) {
        var that = this;
        this.clearAllField();
        if(params.name == '') {
            that.errorField($('#name', $('.recruit')));
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            that.errorField($('#mobile', $('.recruit')));
            return false;
        }
        return true;
    },

};
$(document).ready(function(){
    xinjiang_activity.init();
});
