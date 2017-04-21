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
        if((typeof $('.list-unstyled')) != 'object')
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

    init_datatable: function(theParams, type) {
        if(typeof $('#dataTable').attr('id') === 'undefined')
            return false;
        site._theTable = $('#dataTable').on('processing.dt', function (e, settings, processing ) {
            $('.loading > img').css('visibility', 'visible');
            setTimeout(function(){$('.loading > img').css( 'visibility', processing ? 'visible' :'hidden');}, 1000);
        }).DataTable({
            processing: false,
            serverSide: true,
            width: "90%",
            height: 'auto',
            ajax: theParams.ajax,
            columns: theParams.columns,
            language: theParams.language,
            order: [[ 0, "desc" ]]
        });
        // init the action buttons
        this.init_database_btns(type);
    },

    init_database_btns: function(type) {
        var that = this;
        $('#dataTable').on('draw.dt', function () {
            // 查看按钮
            if(typeof $('.show-btn').attr('class') !== 'undefined') {
                $('.show-btn').on('click', function () {
                    var data = that._theTable.row($(this).parents('tr')).data();
                    var params = [];
                    params[type] = data.id;
                    window.location.href =  laroute.route(type+'.show', params);
                    return;
                });
            }
            // 编辑按钮
            if(typeof $('.edit-btn').attr('class') !== 'undefined') {
                $('.edit-btn').on('click', function () {
                    var data = that._theTable.row($(this).parents('tr')).data();
                    var params = [];
                    params[type] = data.id;
                    window.location.href =  laroute.route(type+'.edit', params);
                    return;
                });
            }
            // 删除按钮
            if(typeof $('.del-btn').attr('class') !== 'undefined') {
                $('.del-btn').on('click', function () {
                    if (confirm('您确定要删除此条记录吗？')) {
                        var data = that._theTable.row($(this).parents('tr')).data();
                        var theForm = $(this).parent().parent().parent();
                        var params = [];
                        params[type] = data.id;
                        theForm.attr('action', laroute.route(type+'.destroy', params));
                        $('.adv_method', theForm).val('delete');
                        theForm.submit();
                    }
                    return;
                });
            }
        });

    },
};
$(document).ready(function(){
    site.init();
});
