var site = {

    _payConfig: {},

    _centerSlideIndex: 0,

    init: function() {
        var path = url('path');
        if(_.startsWith(path, '/wechat/register')) {
            this.initRegister();
        } else if(_.startsWith(path, '/wechat/login')) {
            this.initLogin();
        } else if(_.startsWith(path, '/wechat/member_list')) {
            this.initMemberList();
        } else if(_.startsWith(path, '/wechat/join_club')) {
            this.initJoinClub();
        } else if(_.startsWith(path, '/wechat/edit_profile')) {
            this.initEditProfile();
        } else {

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
            that.sendSms();
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

    initMemberList: function() {
        if(expDrivers.length == 0)
            return false;
        var that = this;
        var expSize = _.keys(expDrivers).length;
        this._centerSlideIndex = Math.floor(expSize/2);
        var mySwiper = new Swiper(".swiper-container", {
            slidesPerView: 5,
            centeredSlides: true,
            initialSlide :that._centerSlideIndex,
            autoplayDisableOnInteraction : false,
            spaceBetween: 0,
            slidesOffsetBefore:1,
            slidesOffsetAfter:1,
            loop: true,
            onInit: function(swiper){
                //Swiper初始化了
                var theDrivers = _.values(expDrivers);
                var theCenterDriver = theDrivers[that._centerSlideIndex];
                that.setExpDriverInfo(theCenterDriver);
            },
            visibilityFullFit: true,
            autoResize: false,
            watchSlidesProgress: !0,
            pagination: ".swiper-pagination",
            paginationClickable: !0,
            prevButton:'.swiper-button-prev',
            nextButton:'.swiper-button-next',
            slideToClickedSlide: false,
            onTransitionEnd: function(swiper) {
                that.renderActiveExpdriver(swiper);
            },
            onClick: function(swiper, event) {
                var uid = _.replace(event.target.id, /[a-zA-Z]+/g, '');
                window.location.href = '/wechat/profile/'+uid;
                return true;
            }
        });
    },

    renderActiveExpdriver: function(swiper){
        var activeId = $('.swiper-slide-active img').attr('id');
        var uid = _.replace(activeId, /[a-zA-Z]+/g, '');
        var user = _.find(expDrivers, function(item){
            return item.uid == uid;
        });
        if(user == undefined)
            return false;
        this.setExpDriverInfo(user);
    },

    setExpDriverInfo: function(user) {
        $('#info_board').hide().fadeIn();
        $('.username', $('#info_board')).text(user.username);
        $('.Wechat-number', $('#info_board')).text(user.nickname);
        if(user.profile.sex == 1) {
            $('.sex', $('#info_board')).attr('src', '/img/m.png');
        } else {
            $('.sex', $('#info_board')).attr('src', '/img/f.png');
        }
        if(user.vehicle)
            $('.vehicle', $('#info_board')).text(user.vehicle);
        if(parseInt(user.profile.keye_age) > 0)
            $('.age', $('#info_board')).text(user.profile.keye_age+'可野龄');
        if(user.profile.quotation)
            $('.autograph', $('#info_board')).html('<img src="/img/yinh.png"/>'+user.profile.quotation);
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
                //console.debug('update');
            },
            onComplete: function (value) {
                //console.debug('complete');
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
        params.nick = $.trim($('#nick').val());
        params.mobile = $.trim($('#mobile').val());
        // params.password = $.trim($('#password').val());
        // params.password_confirmation = $.trim($('#password_confirmation').val());
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
                    that.showError(rs);
                }
            }
        });
    },

    showError: function(rs) {
        swal({
            html: true,
            title: "出问题啦！",
            text: rs.msg,
            type: 'error'
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
        // if($.trim(params.password) == ''){
        //     that.errorField($('#password'));
        //     return false;
        // }
        // if($.trim(params.password_confirmation) != $.trim(params.password)){
        //     that.errorField($('#password'));
        //     that.errorField($('#password_confirmation'));
        //     return false;
        // }

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
                if(res.errMsg == "chooseWXPay:ok" ) {
                    window.location.href='/wechat/member_list';
                    return false;
                } else if(res.err_msg == "chooseWXPay:fail" ) {
                    alert('支付失败，请稍后重试！');
                    window.location.href='/wechat/member_list';
                    return false;
                } else {
                    alert(JSON.stringify(res, null, 4));
                    return false;
                }
            }
        });
        wx.error(function(res){
            alert(JSON.stringify(res, null, 4));
            return false;
        });
    },

    initEditProfile: function () {
        var that = this;

        $('.carinfo').on('click',function(){
            $('.Vehicle-information').css('left','0px');
            if($('.brandList').html() == '') {
                for (var i in brands) {
                    var str = '';
                    for (var j in brands[i]) {
                        str += '<li class="aLi" code="' + brands[i][j].code + '">' + brands[i][j].name + '</li>'
                    }
                    var oSection = $('<section nav-title=' + i + ' id=' + i + '><h2>' + i + '</h2>' + str + '</section>');
                    $('.brandList').append(oSection);
                }
            }
        });

        //点击召唤品牌信息
        $('.brand').on('click',function(){
            $('.brandBox').css('left','0px');
            alphabetNav.init('nav-title');
            $('.brandBox .brandList .aLi').unbind('click').on('click',function(event){
                var code = $(this).attr('code');
                $('.brand input').val($(this).html());
                $('.brandBox').css('left','15rem');
                $('.alphabetList').hide();
                // send ajax to get series
                $.ajax({
                    type: "GET",
                    dataType: "json", //dataType (xml html script json jsonp text)
                    url: '/get_series/'+code,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                    success: function(rs) {//成功获得的也是json对象
                        if(rs.errno == 0) {
                            that.setSeriesHtml(rs.data);
                        } else {
                            that.showError(rs);
                        }
                    }
                });

                event.stopPropagation();
            })
        });

        $('.series').click(function(){
            $('.seriesBox').css('left','0px');
            $('.myselect', $('.seriesBox')).show();
        });

        $('.myselect-close').click(function(){
            $('.selectBox').css('left','15rem');
        });
        $('.vehicle-close').click(function(){
            $('.Vehicle-information').css('left','15rem');
        });

    },

    setSeriesHtml: function(data) {
        var that = this;
        var str = '<ul class="myselect">';
        for(var i in data){
            str +='<li class="aLi" code="'+data[i].code+'">'+data[i].name+'</li>';
        }
        str += '</ul>';
        $('.seriesList').html(str);
        // bind event
        $('.seriesBox .seriesList .aLi').unbind('click').on('click',function(event) {
            var code = $(this).attr('code');
            $('.series input').val($(this).html());
            $('.seriesBox').css('left', '15rem');
            // send ajax to get series
            $.ajax({
                type: "GET",
                dataType: "json", //dataType (xml html script json jsonp text)
                url: '/get_models/'+code,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {
                        that.setMotomodels(rs.data);
                    } else {
                        that.showError(rs);
                    }
                }
            });

            event.stopPropagation();
        });
    },

    setMotomodels: function(data) {
        var str = '<ul class="myselect">';
        for(var i in data){
            str +='<li class="aLi" code="'+data[i].code+'">'+data[i].name+'</li>';
        }
        str += '</ul>';
        $('.motomodelList').html(str);
        // bind event
        $('.motomodelBox .motomodelList .aLi').unbind('click').on('click',function(event) {
            $('.motomodel input').val($(this).html());
            $('.motomodelBox').css('left', '15rem');
            event.stopPropagation();
        });
    }

};

site.init();
