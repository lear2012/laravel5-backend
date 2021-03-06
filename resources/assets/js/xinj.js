var mySwiper;
var signed = false;
!function(name, context, definition) {
    if (typeof module !== "undefined")
        module.exports = definition(name, context);
    else if (typeof define === "function" && typeof define.amd === "object")
        define(definition);
    else
        context[name] = definition(name, context)
}("toast", this, function(name, context) {
    var Toast = function(o) {
        o || (o = {});
        this.timeout = "timeout"in o ? o.timeout : 2500;
    };
    Toast.prototype = {
        constructor: Toast,
        show: function(msg) {

            var html = '';
            var msg = msg ? msg : '';
            var body = document.body;
            var toast = document.getElementById('customToast');
            html += '<div id="customToast" style={display:"block"}>';
            // html += '<div class="weui-mask_transparent"></div>';
            html += '<div class="weui-toast">';
            html += '<i class="weui-loading weui-icon_toast"></i>';
            html += '<p id="customToast_Content"  class="weui-toast__content">'+msg+'</p>';
            html += '</div>';
            html += '</div>';


            if(!toast) {
                var div = document.createElement("div");
                div.innerHTML = html;
                body.appendChild(div);
            }else {
                var content = document.getElementById('customToast_Content');
                toast.style.display = 'block';
                content.innerHTML = msg;
            }
        },
        hide: function() {
            var toast = document.getElementById('customToast');
            if(toast) {
                toast.style.display = 'none';
            }
        }
    };
    return new Toast
});

window.onload = function() {

    var startY, endY, player, mySwiper2;

    var player = videojs('video', {}, function onPlayerReady() {
        // this.play();
        $('#video-next').hide();
    });

    player.on('play', function() {
        $('#video-next').hide();
    });

    player.on('ended', function() {
        // console.log('ended');
        player.exitFullWindow();
        player.exitFullscreen(); // ios取消全屏
        player.currentTime(0);
        $('#video').hide();
        $('#video-next').show();
    });

    mySwiper = new Swiper ('.swiper-v', {
        direction: 'vertical',
        watchSlidesProgress: true,
        watchSlidesVisibility: true,
        observer: true,
        lazyLoading: true,
        onInit: function(swiper) {
            swiperAnimateCache(swiper); //隐藏动画元素
            swiperAnimate(swiper); //初始化完成开始动画
        },
        onSlideChangeStart: function(swiper){
            if(swiper.previousIndex == 1)
                player.pause();
        },
        onSliderMove: function (swiper) {
            if(swiper.activeIndex == 6 && !signed){
                swiper.lockSwipeToNext();
            } else {
                swiper.unlockSwipeToNext();
            }
        },
        onSlideChangeEnd: function(swiper){
            swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
        },
        onTransitionStart: function(swiper) {
            //console.log(swiper.activeIndex);
            if(swiper.activeIndex == 0) {
                $('#video').show();
                player.play();
            }
        },
        onTransitionEnd: function(swiper) {
            if(swiper.activeIndex !== 0) {
                $('#video').hide();
                player.pause();
            }
        },
        onClick: function(swiper) {
            if(swiper.activeIndex === 0) {
                if($('#video').css('display') === 'none') {
                    mySwiper.slideNext();
                }
            }
        },
        onImagesReady: function(swiper) {
            toast.hide();
        },
    });

    $('.next').on('click', function(){
        mySwiper.slideNext();
    });

    // 报名
    var $signUp = $('.sign-up');
    var $recruit = $('.recruit');

    $('.button1').on('click', function() {
        $signUp.show().addClass('slide-left');
        $recruit.hide().removeClass('slide-left');
    });

    $('.sign-up .icon-close').on('click', function(event) {
        $signUp.removeClass('slide-left');
        setTimeout(function() {
            $signUp.hide();
        }, 500);
    });

    // 招募
    $('.button2').on('click', function() {
        $signUp.hide().removeClass('slide-left');
        $recruit.show().addClass('slide-left');
    });

    $('.recruit .icon-close').on('click', function(event) {
        $recruit.removeClass('slide-left');
        setTimeout(function() {
            $recruit.hide();
        }, 500);
    });

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
        elm.removeClass('success');
        elm.addClass('error');
    },

    successField:function(elm) {
        elm.removeClass('error');
        elm.addClass('success');
    },

    clearField:function(elm) {
        elm.removeClass('error');
        elm.removeClass('success');
    },

    clearAllField: function () {
        $('input').removeClass('error');
        $('input').removeClass('success');
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
                    signed = true;
                    $('.sign-up').hide();
                    $('.recruit').hide();
                    mySwiper.unlockSwipeToNext();
                    mySwiper.slideNext();
                }
            });
        });
    },

    checkRegister: function(params) {
        var that = this;
        this.clearAllField();
        if(params.name == '') {
            //that.errorField();
            $('#name', $('.sign-up')).css('border-bottom', '1px solid red');
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            //that.errorField($('#mobile', $('.sign-up')));
            $('#mobile', $('.sign-up')).css('border-bottom', '1px solid red');
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
                    signed = true;
                    $('.sign-up').hide();
                    $('.recruit').hide();
                    mySwiper.unlockSwipeToNext();
                    mySwiper.slideNext();
                }
            });
        });
    },

    checkCameraRegister: function(params) {
        var that = this;
        this.clearAllField();
        if(params.name == '') {
            //that.errorField($('#name', $('.recruit')));
            $('#mobile', $('.recruit')).css('border-bottom', '1px solid red');
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            //that.errorField($('#mobile', $('.recruit')));
            $('#mobile', $('.recruit')).css('border-bottom', '1px solid red');
            return false;
        }
        return true;
    },

};
$(document).ready(function(){
    xinjiang_activity.init();
});
