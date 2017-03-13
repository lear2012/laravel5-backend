var site = {

    _payConfig: {},

    init: function() {
        var path = url('path');
        console.log(path);
        switch(path){
            case '/wechat/register':
                this.initRegister();
                break;
            case '/wechat/login':
                this.initLogin();
                break;
            default:
        }
    },

    initRegister: function() {
        // captcha
        var that = this;
        $('.captcha').on('click', function(){
            that.refreshCaptcha();
        });
        // checkbox
        var onoff = true;
        $('.Radiobox').on('click',function(){
            if(onoff){
                $('.Radiobox i').removeClass('Radio');
                $('#agree').val(0);
            } else {
                $('.Radiobox i').addClass('Radio');
                $('#agree').val(1);
            }
            onoff = !onoff;
        });
        // send sms
        $('#send_sms_btn').click(function(){
            if(!validator.isMobilePhone($('#mobile').val(), 'zh-CN')) {
                that.errorField($('#mobile'));
                return false;
            }
            that.clearField($('#mobile'));
            that.initTimer();
            $('#timer').show();
            $(this).hide();
        });

        // check captcha
        $('#captcha').keyup(function(event){
            that.checkImgCode();
        });
        // close
        $('.close').bind('click',this.close);
        // submit
        $('.submit').on('click',function(event){
            that.register();
            event.stopPropagation();
        });
        //协议提示框
        $('#Agreement').on('click',function(event){
            that.showMemberRule();
            event.stopPropagation();
        });
    },

    initLogin: function() {

    },

    initTimer: function() {
        $('.timer').countTo({
            from: 60,
            to: 0,
            speed: 60000,
            formatter: function (value, options) {
                return value.toFixed(options.decimals)+'';
            },
            onUpdate: function (value) {
                console.debug('update');
            },
            onComplete: function (value) {
                console.debug('complete');
                $('#send_sms_btn').show();
                $('#timer').hide();
            }
        });
    },

    errorField: function(elm) {
        elm.parent().parent().removeClass('success');
        elm.parent().parent().addClass('error');
    },

    successField:function(elm) {
        elm.parent().parent().removeClass('error');
        elm.parent().parent().addClass('success');
    },

    clearField:function(elm) {
        elm.parent().parent().removeClass('error');
        elm.parent().parent().removeClass('success');
    },

    clearAllField: function () {
        $('input').parent().parent().removeClass('error');
        $('input').parent().parent().removeClass('success');
        $('i', $('#cki')).removeClass('checkbox_err');
    },

    checkImgCode: function() {
        var that = this;
        // send rq to backend to sync the perms
        var data = {};
        data.captcha = $('#captcha').val();
        $.ajax({
            type: "GET",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: data, //json 数据
            url: '/wechat/checkImgCode',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                if(rs.errno == 0) {
                    that.successField($('#captcha'));
                } else {
                    that.errorField($('#captcha'));
                }

            }
        });
    },

    sendSms: function() {
        var that = this;
        // send rq to backend to sync the perms
        var data = {};
        data.mobile = $.trim($('#mobile').val());
        data.bg = 'register';
        $.ajax({
            type: "GET",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: data, //json 数据
            url: '/wechat/sendSms',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                if(rs.errno == 0) {
                    that.successField($('#mobile'));
                } else {
                    that.errorField($('#mobile'));
                }
            }
        });
    },

    register: function() {
        var that = this;
        var params = {};
        params.nick = $('#nick').val();
        params.mobile = $('#mobile').val();
        params.mb_verify_code = $.trim($('#mb_verify_code').val());
        params.invite_no = $('#invite_no').val();
        params.captcha = $.trim($('#captcha').val());
        params.agree = $('#agree').val();
        if(!this.checkRegister(params))
            return false;
        $.ajax({
            type: "POST",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: params, //json 数据
            url: '/wechat/register',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                if(rs.errno == 0) {
                    //$('#reg_success').show();
                    swal({
                        html: true,
                        title: "<p>注册成功</p>",
                        text: "<p>付费可正式成为可野人</p>",
                        type: 'success',
                        imageUrl: "/img/success_icon@2X.png",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "我付费,我光荣！",
                        cancelButtonText: "再逛逛",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }, function (isConfirm) {
                        if (isConfirm) {
                            that.payMemberFee();
                        } else {
                            window.location.href='/wechat/member_list';
                        }
                    });
                } else {
                    //$('#err_msg').html(rs.msg);
                    //$('#reg_fail').show();
                    swal({
                        html: true,
                        title: "出问题啦！",
                        text: rs.msg,
                        type: 'error',
                        imageUrl: "/img/success_icon@2X.png"
                    });
                }
            }
        });
    },

    checkRegister: function(params) {
        var that = this;
        this.clearAllField();
        if(params.nick == '') {
            that.errorField($('#nick'));
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            that.errorField($('#mobile'));
            return false;
        }
        if(params.mb_verify_code == '') {
            that.errorField($('#mb_verify_code'));
            return false;
        }
        if(params.captcha == '') {
            that.errorField($('#captcha'));
            return false;
        }
        if(params.agree != 1) {
            $('i', $('#cki')).addClass('checkbox_err');
            return false;
        }
        return true;
    },

    close: function() {
        $('.aleat').hide();
    },

    refreshCaptcha: function() {
        $('.captcha').attr('src', '/captcha/default' + '?t=' + Math.random());
    },

    showMemberRule: function() {
        swal({
            html: true,
            title: "会员规则",
            text: "Here's a custom image.",
            allowOutsideClick: true,
            confirmButtonText: '关闭',
            customClass: 'aleat'
            //imageUrl: "images/thumbs-up.jpg"
        });
    },

    showMessage: function(type, text) {
        // $.noty.defaults = {
        //     layout: 'top',
        //     theme: 'defaultTheme', // or relax
        //     type: type, // success, error, warning, information, notification
        //     text: text, // [string|html] can be HTML or STRING
        //
        //     dismissQueue: false, // [boolean] If you want to use queue feature set this true
        //     force: false, // [boolean] adds notification to the beginning of queue when set to true
        //     maxVisible: 5, // [integer] you can set max visible notification count for dismissQueue true option,
        //
        //     template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
        //
        //     timeout: false, // [integer|boolean] delay for closing event in milliseconds. Set false for sticky notifications
        //     progressBar: false, // [boolean] - displays a progress bar
        //
        //     animation: {
        //         open: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceInLeft'
        //         close: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceOutLeft'
        //         easing: 'swing',
        //         speed: 500 // opening & closing animation speed
        //     },
        //     closeWith: ['click'], // ['click', 'button', 'hover', 'backdrop'] // backdrop click will close all notifications
        //
        //     modal: false, // [boolean] if true adds an overlay
        //     killer: false, // [boolean] if true closes all notifications and shows itself
        //
        //     callback: {
        //         onShow: function() {},
        //         afterShow: function() {},
        //         onClose: function() {},
        //         afterClose: function() {},
        //         onCloseClick: function() {}
        //     },
        //
        //     buttons: false // [boolean|array] an array of buttons, for creating confirmation dialogs.
        // };
        var n = $('#message').noty({
            layout: 'top',
            theme: 'defaultTheme', // or relax
            type: type, // success, error, warning, information, notification
            text: text, //
            //template: '<div class="noty_message"><span class="noty_text"></span></div>',
            animation: {
                open: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceInLeft'
                close: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceOutLeft'
                easing: 'swing',
                speed: 500 // opening & closing animation speed
            },
            closeWith: ['click'],
            timeout: 3000,
            killer: true
        });
    },

    payMemberFee: function() {
        this._payConfig = config;
        wx.chooseWXPay({
            timestamp: this._payConfig.timestamp,
            nonceStr: this._payConfig.nonceStr,
            package: this._payConfig.package,
            signType: this._payConfig.signType,
            paySign: this._payConfig.paySign.toUpperCase(), // 支付签名
            success: function (res) {
                // 支付成功后的回调函数
                if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                    window.location.href='/wechat/member_list';
                    return false;
                } else if(res.err_msg == "get_brand_wcpay_request:fail" ) {
                    alert('支付失败，请稍后重试！');
                    return false;
                } else {
                    for(var i in res.err_msg){
                        alert.log(i);
                        alert.log(res.err_msg[i]);
                    }
                    return false;
                }
            }
        });
        wx.error(function(res){
            alert.log(i);
            alert.log(res.err_msg[i]);
            return false;
        });
    },

};

site.init();