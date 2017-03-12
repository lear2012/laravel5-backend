var site = {

    _theTable: '',  // the datatables object if we have datatable

    _currentRow: '', // current row obj if we have datatable

    _newPerms: [], // used for update the datatable row data

    _roles: [], // used to store roles with its perms


    init: function() {
        this.ops_alert();
        this.init_select();
        this.init_checkbox();
    },

    init_checkbox: function() {
        if($('.js-switch').length > 0) {
            $(".js-switch").bootstrapSwitch('state', $('.js-switch').prop('checked'));
        } else {
            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-purple',
                radioClass: 'iradio_square-purple',
                increaseArea: '20%' // optional
            });
        }
    },

    init_select: function() {
        if ($('#role_selection').length == 0)
            return;
        var selected = $('#role_ids').val();
        var sel = $("#role_selection").select2({
            language: "zh-CN"
        });
        if (selected != ''){
            sel.val(selected.split(',')).trigger("change");
        }
        $('#role_selection').on('change', function(){
            $('#role_ids').val($(this).val());
        });
    },

    init_fileinput: function() {
        if ($('.img').length == 0)
            return;
        $(".img").fileinput({'showUpload':false,language:'zh'});
    },

    init_normal_select: function() {
        if ($('.select2').length > 0)
            $('.select2').select2({
                language: "zh-CN"
            });
    },

    init_nav: function(pageStaff) {
        var curNav = pageStaff.curNav;
        var curManage = pageStaff.curManage;
        var hasChannel = true;
        console.log(pageStaff);
        $('#content-nav').click(function(){
            if($(this).next().length == 0) {
                hasChannel = false;
                site.ops_alert('error|您必须先创建栏目才能添加内容！');
            }
        });
        if(!hasChannel)
            return false;
        if(curNav)
            $('#'+curNav+'-nav').length > 0 && $("#" + curNav + '-nav').click();
        if(curManage) {
            $('#' + curManage + '-manage').length > 0 && $("#" + curManage + '-manage').click();
        }
        return true;
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
            // 分配权限按钮
            if($('.assign-perms-btn').length > 0) {
                that.bind_assing_perms_btn();
                that.init_assign_perms_modal();
            }
            // 推送配置修改
            if($('.deliver-config-btn').length > 0) {
                that.bind_deliver_config_btn();
            }
        });

    },

    bind_assing_perms_btn: function() {
        var that = this;
        $('.assign-perms-btn').on('click', null, function (e) {
            var data = that._theTable.row($(this).parents('tr')).data();
            that._roles[data.id] = data;
            that._currentRow = that._theTable.row($(this).parents('tr'));
            $('#assign-perms-modal').attr('itemId', data.id);
            that.check_modal_perms(data);
        });
    },

    bind_deliver_config_btn: function() {
        var that = this;
        $('.deliver-config-btn').on('click', null, function (e) {
            var data = that._theTable.row($(this).parents('tr')).data();
            var params = {};
            params.siteconfig = data.id;
            params.from = 'servicepoint';
            window.location.href = laroute.route('siteconfig.edit', params);
        });
    },

    check_modal_perms: function(data) {
        var len = data.permissions.length;
        // uncheck all perms
        $('.perms').iCheck('uncheck');
        if(len > 0) {
            for(var i=0;i< len;i++) {
                $('#perm'+ data.permissions[i].id).iCheck('check');
            }
        }
    },

    init_assign_perms_modal: function() {
        var that = this;
        // 分配权限
        $('.modal-confirm', $('#assign-perms-modal')).on('click', function(){
            var checkedPermIds = ''; // selected perm ids
            var checkedInputs = $('input[class=perms]'); // all perms
            // get all the selected perms
            for(var i=0;i<checkedInputs.length;i++){
                if(checkedInputs[i].checked) {
                    checkedPermIds += checkedInputs[i].id.substr(4) + ",";
                    that._newPerms.push(checkedInputs[i]);
                }
            }
            // prepare the data
            var data = {};
            data.roleId = $('#assign-perms-modal').attr('itemId');
            data.permIds = checkedPermIds !='' ? checkedPermIds.substr(0, checkedPermIds.length-1) : '';

            // send request to backend
            that.sync_perms(data);
        });
        $('#assign-perms-modal').on('hidden.bs.modal', function (e) {
            // rebind click event, cause if modal content updated, the click event not fired
            $('.assign-perms-btn').unbind('click');
            that.bind_assing_perms_btn();
            that._currentRow = '';
            that._newPerms = [];
        });
    },

    sync_perms: function(data) {
        var that = this;
        // send rq to backend to sync the perms
        $.ajax({
            type: "POST",
            dataType: "json", //dataType (xml html script json jsonp text)
            data: data, //json 数据
            url: laroute.route('role.assign_perms'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function(rs) {//成功获得的也是json对象
                var result = rs.rs == 0 ? 'success' : 'error';
                $('#assign-perms-modal').modal('hide');
                $('#jsmsg').html(result+'|'+rs.msg);
                that.ops_alert();
                that.redraw_datatable_row_data();
            }
        });
    },

    redraw_datatable_row_data: function() {
        var that = this;
        // redraw the row's data
        var data = that._currentRow.data();
        var perms = [];
        for(var i=0;i<that._newPerms.length;i++) {
            var tmp = {};
            tmp.id = that._newPerms[i].id.substr(4);
            tmp.display_name = $('#perm'+tmp.id).parent().parent().text();
            perms.push(tmp);
        }
        data.permissions = []; // clear it first
        data.permissions = perms;
        that._currentRow.data(data);
        that._currentRow.invalidate();
        //that._theTable.draw();
    }
};
$(document).ready(function(){
    site.init();
});