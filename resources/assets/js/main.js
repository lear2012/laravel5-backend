var site = {

    _payConfig: {},

    _centerSlideIndex: 0,

    vehicleInfo: {},

    init: function() {
        var path = url('path');
        if(_.startsWith(path, '/wechat/register')) {
            this.initRegister();
        } else if(_.startsWith(path, '/wechat/login')) {
            this.initLogin();
        } else if(_.startsWith(path, '/wechat/member_list')) {
            this.initMemberList();
        } else if(_.startsWith(path, '/wechat/edit_profile')) {
            this.initEditProfile();
        } else if(_.startsWith(path, '/wechat/profile')) {
            this.initProfile();
        } else {

        }
    },

    initRegister: function() {
        // captcha
        var that = this;
        $('.captcha').on('click', function(){
            that.refreshCaptcha();
        });
        this.initSingleCheckbox($('#agree'));
        // send sms
        $('#send_sms_btn').click(function(){
            if(!validator.isMobilePhone($('#mobile').val(), 'zh-CN')) {
                that.errorField($('#mobile'));
                return false;
            }
            that.clearField($('#mobile'));
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
        // 邀请码
        $('#invite_no').on('blur',function(event){
            that.checkInvitationCode();
            event.stopPropagation();
        });
    },

    initLogin: function() {

    },

    checkInvitationCode: function() {
        var that = this;
        // send rq to backend to sync the perms
        var data = {};
        data.code = $('#invite_no').val();
        if($.trim(data.code) == '')
            return false;
        $.ajax({
            type: "POST",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: data, //json 数据
            url: '/wechat/get_invitation_payconfig',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                if(rs.errno == 0) {
                    that.successField($('#invite_no'));
                } else {
                    that.showError(rs);
                }
            }
        });
    },

    initMemberList: function() {
        var myLazyLoad = new LazyLoad();
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
                //$('.swiper-slide-active').css('width', '180px');
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
                //$('.swiper-slide-active').css('width', '180px');
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

    initTimer: function(elm) {
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
                elm.show();
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
        if($.trim(data.mobile) == '' || !$.isNumeric(data.mobile))
            return false;
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
                    that.initTimer($('#send_sms_btn'));
                    $('#timer').show();
                    $('#send_sms_btn').hide();
                    that.successField($('#mobile'));
                } else {
                    that.showError(rs);
                }
            }
        });
    },

    verifyID: function(params) {
        var that = this;
        $.ajax({
            type: "POST",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: params, //json 数据
            url: '/wechat/verify_id',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                if(rs.errno == 0) {
                    //that.initTimer($('#id_verify_btn'));
                    //$('#timer').show();
                    $('#id_verify_btn').hide();
                    //that.successField($('#id_no'));
                    $('#verified').addClass('verified');
                } else {
                    that.showError(rs);
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
                    that.showPayModal({from:'register'});
                } else {
                    that.showError(rs);
                }
            }
        });
    },

    showPayModal: function(params) {
        var that = this;
        var title = '';
        var loc = '/wechat/member_list';
        switch(params.from) {
            case 'register':
                title = "<p>注册成功，接着看如何成为可野人，享受可野人福利</p>";
                break;
            case 'profile':
                title = "<p>付费成为可野人，享受可野人福利</p>";
                loc = '/wechat/edit_profile?id='+params.uid;
                break;
            default:
        }
        swal({
            html: true,
            title: title,
            text: that.getPayMemberText(),
            imageUrl: "/img/success_icon@2X.png",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "我付费,我光荣！",
            cancelButtonText: "再逛逛",
            closeOnConfirm: false,
            closeOnCancel: false,
            customClass: 'memberRules'
        }, function (isConfirm) {
            if (isConfirm) {
                that.payMemberFee(loc);
            } else {
                window.location.href=loc;
            }
        });
    },

    showError: function(rs) {
        swal({
            html: true,
            title: "出问题啦！",
            text: rs.msg,
            type: 'error',
            confirmButtonText: '关闭'
        });
    },

    checkRegister: function(params) {
        var that = this;
        var error = {};
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
            error.msg = '您必须同意注册须知才可以注册！';
            that.showError(error);
            return false;
        }
        return true;
    },

    checkProfile: function(params) {
        var that = this;
        var error = {};
        this.clearAllField();
        if(params.real_name == '') {
            that.errorField($('#real_name'));
            return false;
        }
        if(params.id_no == '') {
            that.errorField($('#id_no'));
            return false;
        }
        if(params.car_no == '') {
            that.errorField($('#car_no'));
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
        var text = this.getMemberText();
        swal({
            html: true,
            title: "注册须知",
            text: text,
            allowOutsideClick: true,
            confirmButtonText: '关闭',
            confirmButtonColor: '#f7b000',
            customClass: 'memberRules'
            //imageUrl: "images/thumbs-up.jpg"
        });
        $('.memberRules').scrollTop(0)
    },

    getMemberText: function() {
        var str = '<div class="rule-content">';
        str += '<p>一、遵守中华人民共和国有关法律、法规，承担一切因您的行为而直接或间接引起的法律责任。</p>'+
            '<p>二、在可野Club发表言论请注意以下几条规定，若有违反，本坛有权删除。<br />'+
            '1 、反对国家宪法所确定的基本原则的；<br />'+
            '2 、危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；<br />'+
            '3 、损害国家荣誉和利益的；<br />'+
            '4 、煽动民族仇恨、民族歧视，破坏民族团结的；<br />'+
            '5 、破坏国家宗教政策，宣扬邪教和封建迷信的；<br />'+
            '6 、散布谣言，扰乱社会秩序，破坏社会稳定的；<br />'+
            '7 、散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；<br />'+
            '8 、侮辱或者诽谤他人，侵害他人合法权益的；<br />'+
            '9 、含有法律、行政法规禁止的其他内容的；<br />'+
            '10、请勿张贴未经公开报道、未经证实的消息；亲身经历者请注明；<br />'+
            '11、请勿张贴宣扬种族歧视、破坏民族团结的言论和消息；<br />'+
            '12、请注意使用文明用语，任何人不得以任何原因对任何一位网友进行人身攻击、谩骂、诋毁的言论；<br />'+
            '13、未经管理人员同意，请勿张贴任何形式的广告；<br />'+
            '14、非官方信息可野Club不承担责任。</p>'+
            '<p>三、ID注册和使用昵称注意事项：<br />'+
            '1、请勿以党和国家领导人或其他名人的真实姓名、字、号、艺名、笔名注册和使用昵称；<br />'+
            '2、请勿以国家组织机构或其他组织机构的名称注册和使用昵称；<br />'+
            '3、请勿注册和使用与其他网友相同、相仿的名字或昵称；<br />'+
            '4、请勿注册和使用不文明、不健康的ID和昵称；<br />'+
            '5、请勿注册和使用易产生歧义、引起他人误解的ID和昵称。<br />'+
            '四、签名档填写注意事项：<br />'+
            '1、签名档内容规定与上贴规定一致，要积极健康；<br />'+
            '2、签名档中不能超链接其他网站、文章和音乐；<br />'+
            '3、为方便阅读，请尽量使签名档不超过4行。</p>'+
            '<p>五、请注意版权问题：<br />'+
            '1、可野出品原创文章欢迎大家分享，但如用于个人或企业平台，请注明原始出处、作者及时间，否则本站有权责令删除；<br />' +
            '2、转发文章时请注意原发表单位的版权声明，并负担由此可能产生的版权责任。<br />' +
            '3、您在可野Club社群中发表的原创文字及图片，本站有权转载或引用；<br />' +
            '4、您注册了可野Club会员或可野人，即表明您已阅读并接受了上述各项条款；<br />' +
            '5、本站拥有管理页面和ID及昵称的一切权力，请网友服从本站管理，如对管理有意见请用发邮件向论坛管理员（ruochen.lang@wisdommer.com）反映。</p>';
        return str+'</div>';
    },

    getPayMemberText: function() {
        var str = '<div class="rule-content">';
        str += '<p>一、申请条件：</p>'+
            '1 、填写个人、车辆信息等入会完整信息<br />'+
            '2 、交纳入会费600元（赠送定制金属车贴，专属会员编号，车牌号定制展览，3个1元推荐名额及各种服务、活动、优惠等）<br />'+
            '<p>二、付费成为可野人专享<br />'+
            '1 、专属会员编号、特别定制高档金属车贴（印有会员编号）、车牌号定制展览<br />'+
            '2 、可野老司机线下party、可野798全球自驾主题空间沙龙等活动永久免费参加<br />'+
            '3 、老司机专属自驾路线体验等产品会员永久优惠（8折）<br />'+
            '4 、可野特种自驾旅游产品会员永久优惠（8折）<br />'+
            '5 、所有可野出品、合作基地服务等享有会员专属优惠<br />'+
            '6 、可野合作代理商品（轮胎、旅游基地等）会员专属优惠<br />'+
            '7 、可野线上线下“会员板”发起活动、发布信息、自驾搭车找人等互动权益<br />'+
            '8 、可野798全球自驾主题空间场地活动使用会员专享5折优惠<br />'+
            '9 、可以免费申请在可野798全球自驾主题空间进行摄影展、产品展等个人自驾越野相关的展览展示活动<br />'+
            '可野798全球自驾主题空间自驾资料、地图免费查阅及自驾咨询服务<br />';
        return str+'</div>';
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

    payMemberFee: function(loc) {
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
                    window.location.href=loc;
                    return false;
                } else if(res.err_msg == "chooseWXPay:fail" ) {
                    alert('支付失败，请稍后重试！');
                    window.location.href=loc;
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

    initProfile: function() {
        $('.return').on('click', function(e){
            window.location.href = '/wechat/member_list';
        });
    },

    initEditProfile: function () {
        var that = this;
        this.initDateBox(); // init the date box
        this.initSingleCheckbox($('#self_get')); // init the checkbox
        $('input[readonly]').on('focus', function(ev) {
            $(this).trigger('blur');
        });
        $('.return').on('click', function(e){
            window.location.href = '/wechat/profile/'+$('#uid').val();
            return;
        });
        // id verify
        $('#id_verify_btn').click(function(){
            var params = {};
            params.real_name = $.trim($('#real_name').val());
            params.id_no = $.trim($('#id_no').val());
            if(params.real_name == '') {
                that.errorField($('#real_name'));
                return false;
            }
            if(params.id_no == '') {
                that.errorField($('#id_no'));
                return false;
            }
            that.clearField($('#real_name'));
            that.clearField($('#id_no'));
            that.verifyID(params);
        });
        // init carinfo select box
        $('.carinfo').on('click',function(e){
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

        // init brand click to show select box
        $('.brand').on('click',function(e){
            $('.brandBox').css('left','0px');
            alphabetNav.init('nav-title');
            $('.alphabetList').show();
            $('.brandBox .brandList .aLi').unbind('click').on('click',function(event){
                var code = $(this).attr('code');
                $('.brand input').val($(this).html());
                that.vehicleInfo.brand = $(this).html();
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
            });
            e.stopPropagation();
        });
        // init series click to show select box
        $('.series').click(function(e){
            $('.seriesBox').css('left','0px');
            $('div', $('.seriesBox')).css('position', 'absolute');
            $('.myselect', $('.seriesBox')).show();
            e.stopPropagation();
        });
        // init buy-date click to show select box
        $('.buy-date').click(function(e){
            $('.dateBox').css('left','0px');
            $('div', $('.dateBox')).css('position', 'absolute');
            $('.myselect', $('.dateBox')).show();
            e.stopPropagation();
        });
        // init close box click
        $('.myselect-close').click(function(){
            $('.selectBox').css('left','15rem');
            $('.alphabetList').hide();
        });
        // init carinfo select box close
        $('.vehicle-close').click(function(){
            $('.Vehicle-information').css('left','15rem');
        });
        // init complete box close
        $('.complete-btn').click(function(){
            var vehicleInfo = that.getVehicleInfo();
            $('#vehicle').val(vehicleInfo);
            $('.Vehicle-information').css('left','15rem');
        });
        // 邀请码
        $('#invite_no').on('blur',function(event){
            that.checkInvitationCode();
            event.stopPropagation();
        });
        // init save button
        $('#save_profile_btn').click(function(){
            var data = {};
            data.real_name = $.trim($('#real_name').val());
            data.id_no = $.trim($('#id_no').val());
            data.address = $.trim($('#address').val());
            data.vehicle = $.trim($('#vehicle').val());
            data.brand = $.trim(that.vehicleInfo.brand);
            data.sery = $.trim(that.vehicleInfo.sery);
            data.buy_year = $.trim(that.vehicleInfo.buyyear);
            data.car_no = $.trim($('#car_no').val());
            data.member_no = $.trim($('#member_no').val());
            data.self_get = $('#self_get').val();
            data.quotation = $.trim($('#quotation').val());
            data.invite_no = $.trim($('#invite_no').val());
            if(!that.checkProfile(data))
                return false;
            // send ajax to save profile info
            $.ajax({
                type: "POST",
                data: data,
                dataType: "json", //dataType (xml html script json jsonp text)
                url: '/wechat/save_profile',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {
                        if(userIsRegister)
                            that.showPayModal({from:'profile', uid: rs.data});
                        else {
                            window.location.href = '/wechat/profile/'+rs.data;
                            return;
                        }
                    } else {
                        that.showError(rs);
                    }
                }
            });
        });
    },

    getVehicleInfo: function () {
        var ret = '';
        if(this.vehicleInfo.brand != undefined)
            ret += this.vehicleInfo.brand;
        if(this.vehicleInfo.sery != undefined)
            ret += '-'+this.vehicleInfo.sery;
        if(this.vehicleInfo.buyyear != undefined)
            ret += '-'+this.vehicleInfo.buyyear;
        return ret;
    },

    setSeriesHtml: function(data) {
        var that = this;
        var str = '<ul class="myselect">';
        for(var i in data){
            str +='<li class="aLi" code="'+data[i].code+'">'+data[i].name+'</li>';
        }
        str +='<li class="aLi" code="0">其它</li>';
        str += '</ul>';
        $('.seriesList').html(str);
        // bind event
        $('.seriesBox .seriesList .aLi').unbind('click').on('click',function(event) {
            var code = $(this).attr('code');
            $('.series input').val($(this).html());
            that.vehicleInfo.sery = $(this).html();
            $('.seriesBox').css('left', '15rem');
            event.stopPropagation();
        });
    },

    initDateBox: function() {
        var that = this;
        var str = '<ul class="myselect">';
        var curYear = new Date().getFullYear();
        for(var i=curYear;i>1949;i--) {
            str +='<li class="aLi" year="'+i+'">'+i+'</li>';
        }
        str += '</ul>';
        $('.dateList').html(str);
        // bind event
        $('.dateBox .dateList .aLi').unbind('click').on('click',function(event) {
            $('.buy-date input').val($(this).html());
            that.vehicleInfo.buyyear = $(this).html();
            $('.dateBox').css('left', '15rem');
            event.stopPropagation();
        });
    },

    initSingleCheckbox: function(elm) {
        // checkbox
        var onoff = true;
        $('.Radiobox').on('click',function(){
            if(onoff){
                $('.Radiobox i').removeClass('Radio');
                elm.val(0);
            } else {
                $('.Radiobox i').addClass('Radio');
                elm.val(1);
            }
            onoff = !onoff;
        });
    }

};

site.init();
