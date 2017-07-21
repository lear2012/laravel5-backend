var round_china = {

    _rid: '', // 用于thumbup的路线id

    _page: 1, // 页码

    _enrollment_id: '', // 搭车时选择的Enrollment ID

    _cars: [],

    init: function() {
        if ($('.home').length > 0) {
            var myLazyLoad = new LazyLoad();
            this.init_swiper();
            this.init_thumbup();
            this.bind_main_thumbup();
            this.bind_route_thumbup();

        } else {
            this.init_back();
            this.init_regrules();
            // init normal checkbox/select
            this.init_checkbox();
            //this.init_normal_select();
            // form submit bind
            this.init_selfreg_submit();
            this.init_liftreg_submit();
            this.init_clubreg_submit();
            this.init_apply_chetie_submit();
            // lift reg
            this.bind_car_select();
            this.init_search_cars();
            this.init_more_cars();
            this.init_more_selfreg_cars();
            this.bind_lift_next();
        }
        this.init_share_btns();
    },

    init_checkbox: function() {
        $('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange',
            increaseArea: '20%' // optional
        });
        $('input[type=checkbox]').on('ifChanged', function(event){
            var val = $(this).val() == 1 ? 0 : 1;
            $(this).val(val);
        });
    },

    init_normal_select: function() {
        if ($('.select2').length > 0)
            $('.select2').select2({
                language: "zh-CN",
                minimumResultsForSearch: Infinity
            });
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

    init_back: function() {
        $('.icon-back').on('click', function (event) {
            if($(this).hasClass('lift-back')) {
                $('.enroll-lift').show();
                $('.enroll-lift-next').animate({left:'9rem'}, 500);
            } else {
                window.location.href = '/roundchina';
                return;
            }
        });
    },

    init_regrules: function () {
        $('#reg_rules').on('click', function (event) {
            $('#rules').show();
        });
    },

    showRegRule: function() {
        var text = this.getRegText();
        swal({
            html: true,
            title: "报名须知",
            text: text,
            allowOutsideClick: true,
            confirmButtonText: '关闭',
            confirmButtonColor: '#f7b000',
            customClass: 'memberRules'
            //imageUrl: "images/thumbs-up.jpg"
        });
    },

    getRegText: function () {
        var html = '';

    },

    init_thumbup: function() {
        $('.icon-like').on('click', function(){
            var route_id = $(this).attr('id');
            if(!$.isNumeric(route_id))
                return;
            $.ajax({
                type: "POST",
                dataType: "json", //dataType (xml html script json jsonp text)
                data: data, //json 数据
                url: '/roundchina/thumbup/'+route_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {

                    } else {

                    }
                }
            });
        });
    },

    init_selfreg_submit: function() {
        var that = this;
        $('#selfreg_submit').on('click', function(){
            var data = {};
            data.name = $.trim($('#name').val());
            data.mobile = $.trim($('#mobile').val());
            data.wechat_no = $.trim($('#wechat_no').val());
            data.brand = $.trim($('#brand').val());
            data.start = $.trim($('#addr_start').val());
            data.end = $.trim($('#addr_end').val());
            data.lift = $.trim($('#carry').val()) == '是' ? 1 : 0;
            data.available_seats = $.trim($('#available_seats').val());
            data.agree = $.trim($('#agree').val());
            if(!that.checkRegister(data))
                return false;
            //return;
            $.ajax({
                type: "POST",
                dataType: "json", //dataType (xml html script json jsonp text)
                data: data, //json 数据
                url: '/roundchina/save_selfreg',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {
                        that.showSuccess(rs);
                    } else {
                        that.showError(rs);
                    }
                }
            });
        });
    },

    checkRegister: function(params) {
        var that = this;
        var error = {};
        this.clearAllField();
        if(params.name == '') {
            that.errorField($('#name'));
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            that.errorField($('#mobile'));
            return false;
        }
        // if(params.wechat_no == '') {
        //     that.errorField($('#wechat_no'));
        //     return false;
        // }
        if(params.start == '') {
            that.errorField($('#start'));
            return false;
        }
        if(params.end == '') {
            that.errorField($('#end'));
            return false;
        }
        if(params.brand == '') {
            that.errorField($('#brand'));
            return false;
        }
        if(params.agree != 1) {
            error.msg = '您必须同意报名须知才可以报名！';
            that.showError(error);
            return false;
        }
        return true;
    },

    init_liftreg_submit: function() {
        var that = this;
        $('#liftreg_submit').on('click', function(){
            var data = {};
            data.enrollment_id = that._enrollment_id;
            data.name = $.trim($('#name').val());
            data.mobile = $.trim($('#mobile').val());
            data.wechat_no = $.trim($('#wechat_no').val());
            data.agree = $.trim($('#agree').val());
            if(!that.checkLiftReg(data))
                return false;
            //return;
            $.ajax({
                type: "POST",
                dataType: "json", //dataType (xml html script json jsonp text)
                data: data, //json 数据
                url: '/roundchina/save_liftreg',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {
                        var liftModal = $('#lift_modal');
                        if(that._cars.length == 0)
                            that._cars = firstPageCars.data;
                        var car = _.find(that._cars, function(car){
                            return car.id == data.enrollment_id
                        });
                        $('.name', liftModal).html(car.name);
                        $('.wechat_no', liftModal).html(car.wechat_no);
                        $('.mobile', liftModal).html(car.mobile);
                        liftModal.show();
                    } else {
                        that.showError(rs);
                    }
                }
            });
        });

        $('.icon-close', $('#lift_modal')).on('click', function(){
            window.location.href = '/roundchina';
            return false;
        });
    },

    checkLiftReg: function(params) {
        var that = this;
        var error = {};
        this.clearAllField();
        if(params.name == '') {
            that.errorField($('#name'));
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            that.errorField($('#mobile'));
            return false;
        }
        // if(params.wechat_no == '') {
        //     that.errorField($('#wechat_no'));
        //     return false;
        // }
        if(params.agree != 1) {
            error.msg = '您必须同意报名须知才可以报名！';
            that.showError(error);
            return false;
        }
        return true;
    },

    init_clubreg_submit: function() {
        var that = this;
        $('#clubreg_submit').on('click', function(){
            var data = {};
            data.club_name = $.trim($('#club_name').val());
            data.name = $.trim($('#name').val());
            data.mobile = $.trim($('#mobile').val());
            data.agree = $.trim($('#agree').val());
            if(!that.checkClubReg(data))
                return false;
            //return;
            $.ajax({
                type: "POST",
                dataType: "json", //dataType (xml html script json jsonp text)
                data: data, //json 数据
                url: '/roundchina/save_clubreg',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {
                        that.showSuccess(rs);
                    } else {
                        that.showError(rs);
                    }
                }
            });
        });
    },

    checkClubReg: function(params) {
        var that = this;
        var error = {};
        this.clearAllField();
        if(params.club_name == '') {
            that.errorField($('#club_name'));
            return false;
        }
        if(params.name == '') {
            that.errorField($('#name'));
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            that.errorField($('#mobile'));
            return false;
        }
        if(params.agree != 1) {
            error.msg = '您必须同意报名须知才可以报名！';
            that.showError(error);
            return false;
        }
        return true;
    },

    init_more_cars: function() {
        var that = this;
        $('#more_cars').on('click', function(){
            that.get_cars();
        });
    },

    init_search_cars: function() {
        var that = this;
        $('#search_cars').on('click', function(){
            that._page = 0;
            $('#car_list').html('');
            that.get_cars();
        });
    },

    get_cars: function() {
        var that = this;
        var data = {};
        data.keyword = $.trim($('#keyword').val());
        $.ajax({
            type: "GET",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: data, //json 数据
            url: '/roundchina/get_available_cars?page='+(++that._page),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                if(rs.errno == 0) {
                    var html = that.get_cars_html(rs.data.data);
                    if(that._cars.length == 0)
                        that._cars = firstPageCars.data;
                    that._cars = that._cars.concat(rs.data.data);
                    if(html) {
                        $('#car_list').append(html);
                        that.bind_car_select();
                    } else {
                        rs.msg = '没有更多的可选车辆！';
                        that.showError(rs);
                    }
                } else {
                    that.showError(rs);
                }
            }
        });
    },

    get_cars_html: function(data) {
        if(data.length == 0)
            return '';
        var html = '';
        for(var i in data) {
            var rest = parseInt(data[i].available_seats) - parseInt(data[i].seats_taken);
            html += '<div class="enroll-item" enrollment_id="'+data[i].id+'">';
            html += '<p class="item-top">';
            html += '<span>车型：' + data[i].brand + '</span>';
            html += '<span>已搭载<b>'+data[i].seats_taken+'人</b>/剩余<b>'+ rest > 0 ? rest : 0 +'人</b></span>';
            html += '</p>';
            html += '<p class="item-bottom">';
            html += data[i].start+'<span></span>'+data[i].end;
            html += '</p>';
            html += '</div>';
        }
        return html;
    },

    init_more_selfreg_cars: function() {
        var that = this;
        $('#more_selfreg_cars').on('click', function(){
            that.get_selfreg_cars();
        });
    },

    get_selfreg_cars: function() {
        var that = this;
        var data = {};
        $.ajax({
            type: "GET",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: data, //json 数据
            url: '/roundchina/get_more_cars?page='+(++that._page),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                if(rs.errno == 0) {
                    var html = that.get_cars_html(rs.data.data);
                    if(that._cars.length == 0)
                        that._cars = firstPageCars.data;
                    that._cars = that._cars.concat(rs.data.data);
                    if(html) {
                        $('#car_list').append(html);
                        that.bind_car_select();
                    } else {
                        rs.msg = '没有更多车辆！';
                        that.showError(rs);
                    }
                } else {
                    that.showError(rs);
                }
            }
        });
    },
    
    bind_car_select: function() {
        var that = this;
        $('.enroll-item').on('click', function (event) {
            $('.enroll-item').removeClass('select');
            $(this).addClass('select');
            that._enrollment_id = $(this).attr('enrollment_id');
        });
    },
    bind_lift_next: function() {
        var that = this;
        $('#lift_next').on('click', function (event) {
            if($('.select', $('#car_list')).length == 0) {
                var rs = {};
                rs.msg = '请选择一辆您想搭的车辆！';
                that.showError(rs);
            } else {
                $('.enroll-lift').hide();
                $('.enroll-lift-next').animate({left: 0}, 500);
            }
        });
    },

    thumbup: function(rid, event) {
        var that = this;
        var data = {};
        var url = '';
        if($.isNumeric(rid))
            url = '/roundchina/thumbup/'+rid;
        else
            url = '/roundchina/thumbup';
        $.ajax({
            type: "POST",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: data, //json 数据
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                if(rs.errno == 0) {
                    var c = parseInt($('.thumbupcount').html());
                    $('.thumbupcount').html(c+1);
                    if(rid == '') {
                        $('.main-icon-hand').removeClass('icon-hand');
                        $('.main-icon-hand').addClass('icon-hand-active');
                    } else {
                        var elm = $('div[route_id='+rid+']', $('.route')).get();
                        $('.icon-like', elm).addClass('icon-like-active');
                        $('.icon-like', elm).removeClass('icon-like');
                    }
                } else {
                    that.showError(rs);
                }
            }
        });
        event.preventDefault();
    },
    
    bind_main_thumbup: function () {
        var that = this;
        $('.main-icon-hand').on('click', function (event) {
            that.thumbup('', event);
        });
    },

    bind_route_thumbup: function () {
        var that = this;
        $('.icon-like', $('.route')).on('click', function (event) {
            var rid = $(this).parent().parent().attr('route_id');
            if(rid == undefined) {
                rid = $(this).parent().parent().parent().attr('route_id');
            }
            that.thumbup(rid, event);
        });
    },

    init_share_btns:function () {

    },

    init_swiper: function () {
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            slidesPerView: 1,
            paginationClickable: true,
            spaceBetween: 10,
            loop: true,
            autoplay: 2500
        });
    },

    init_apply_chetie_submit: function() {
        var that = this;
        $('#apply_chetie_submit').on('click', function(){
            var data = {};
            data.name = $.trim($('#name').val());
            data.mobile = $.trim($('#mobile').val());
            data.brand = $.trim($('#brand').val());
            data.start = $.trim($('#addr_start').val());
            data.end = $.trim($('#addr_end').val());
            data.address = $.trim($('#address').val());
            data.detail = $.trim($('#detail').val());
            if(!that.checkApplyChetie(data))
                return false;
            //return;
            $.ajax({
                type: "POST",
                dataType: "json", //dataType (xml html script json jsonp text)
                data: data, //json 数据
                url: '/roundchina/save_apply_chetie',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
                success: function(rs) {//成功获得的也是json对象
                    if(rs.errno == 0) {
                        that.showSuccess(rs);
                    } else {
                        that.showError(rs);
                    }
                }
            });
        });
    },

    checkApplyChetie: function(params) {
        var that = this;
        var error = {};
        this.clearAllField();
        if(params.name == '') {
            that.errorField($('#name'));
            return false;
        }
        if(!validator.isMobilePhone(params.mobile, 'zh-CN')) {
            that.errorField($('#mobile'));
            return false;
        }
        if(params.brand == '') {
            that.errorField($('#brand'));
            return false;
        }
        if(params.start == '') {
            that.errorField($('#start'));
            return false;
        }
        if(params.end == '') {
            that.errorField($('#end'));
            return false;
        }
        if(params.address == '') {
            that.errorField($('#address'));
            return false;
        }
        return true;
    },

};
$(document).ready(function(){
    round_china.init();
});
