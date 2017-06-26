var site = {

    _theTable: '',  // the datatables object if we have datatable

    _currentRow: '', // current row obj if we have datatable

    _newPerms: [], // used for update the datatable row data

    _roles: [], // used to store roles with its perms

    normal_init: function() {
        this.ops_alert();
        this.init_select();
        //this.init_normal_select();
        this.init_checkbox();
    },

    init: function() {
        var path = url('path');
        switch(path){
            case '/admin/login':
                this.initLogin();
                break;
            default:
                this.normal_init();
        }
    },

    initLogin: function() {
        var that = this;
        this.init_checkbox();
        $('.captcha').on('click', function(){
            that.refreshCaptcha();
        });
    },

    refreshCaptcha: function() {
        $('.captcha').attr('src', '/captcha/default' + '?t=' + Math.random());
    },

    init_checkbox: function() {
        $('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-purple',
            radioClass: 'iradio_square-purple',
            increaseArea: '20%' // optional
        });
        $('input[type=checkbox]').on('ifChanged', function(event){
            var val = $(this).val() == 1 ? 0 : 1;
            $(this).val(val);
        });
    },

    init_fileinput: function() {
        if ($('.img').length == 0)
            return;
        $(".img").fileinput({'showUpload':false,language:'zh'});
    },

    init_select: function() {
        if ($('#role_selection').length == 0)
            return;
        var selected = $('#role_ids').val();
        var sel = $("#role_selection").select2({
            language: "zh-CN",
            minimumResultsForSearch: Infinity
        });
        if (selected != ''){
            sel.val(selected.split(',')).trigger("change");
        }
        $('#role_selection').on('change', function(){
            $('#role_ids').val($(this).val());
        });
        $("#sex").select2({
            language: "zh-CN",
            minimumResultsForSearch: Infinity
        });
    },

    init_normal_select: function() {
        if ($('.select2').length > 0)
            $('.select2').select2({
                language: "zh-CN"
            });
    },

    ops_alert: function() {
        var jsmsg = $('#jsmsg').html();
        if(jsmsg != '') {
            var msgArr = jsmsg.split('|');
            if(msgArr[1] != '') {
                var color = '#00C0EF';
                switch(msgArr[0]) {
                    case 'success':
                        color = '#00A65A';//#27ae60
                        break;
                    case 'error':
                        color = '#DD4B39';
                        break;
                    default:
                }
                $.amaran({
                    content: {
                        message: msgArr[1],
                        color:color
                    },
                    position: 'top right',
                    inEffect: "fadeIn",
                    outEffect: "fadeOut",
                    closeButton:true
                });
            }
        }
        return true;
    },

    showError: function (msg) {
        swal({
            html: true,
            title: "出问题啦！",
            text: msg,
            type: 'error',
            confirmButtonText: '关闭'
        });
    },

    showSuccess: function (msg) {
        swal({
            html: true,
            title: "操作成功！",
            text: msg,
            type: 'success',
            confirmButtonText: '关闭'
        });
    },
};
$(document).ready(function(){
    site.init();
});
