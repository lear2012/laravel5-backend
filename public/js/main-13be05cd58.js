var site = {

    init: function() {
        var path = url('path');
        console.log(path);
        switch(path){
            case '/wechat/register':
                this.initRegister();
                break;
            case '/wechat/login':
                break;
            default:
        }
    },

    initRegister: function() {
        console.log('init 1111');
        console.log(validator.isEmail('111@qq.com'));
        // captcha
        var that = this;
        $('.captcha').on('click', function(){
            that.refreshCaptcha();
        });
        // checkbox
        var onoff = true;
        $('.Radiobox').on('click',function(){
            if(onoff){
                $('.Radiobox i').removeClass('Radio')
            }else{
                $('.Radiobox i').addClass('Radio')
            }
            onoff = !onoff;
        });
        // close
        $('.close').bind('click',this.close);
        // submit
        $('.submit').on('click',function(event){
            $('.aleat').css({
                'display':'block',
                'top':'8rem'
            });
            var params = {};
            params.nick = $('#nick').val();
            params.mobile = $('#mobile').val();
            params.invite_no = $('#invite_no').val();


            $('#modal-content').html(
                '<div class="aleat-submit">'+
                '<img src="img/success_icon@2X.png" />'+
                '<p>入会成功</p>'+
                '<p>付费可正式成为可野人</p>'+
                '<button class="close">再逛逛</button>'+
                '<button>我付费,我光荣！</button>'+
                '</div>'
            );
            event.stopPropagation();
        });
        //协议提示框
        $('#Agreement').on('click',function(event){
            $('.aleat').css({
                'display':'block',
                'top':'5%'
            });
            $('#modal-content').html(
                '<div class="aleat-Agreement">'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '<p>4244223423432</p>'+
                '</div>'
            );
            //event.stopPropagation();
        });
    },

    close: function() {
        $('.aleat').css({
            'display':'none'
        });
        $('#modal-content').html('');
    },

    refreshCaptcha: function() {
        $('.captcha').attr('src', '/captcha/default' + '?t=' + Math.random());
    }

};

site.init();