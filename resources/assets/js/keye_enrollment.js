var enrollments_page = {

    _theTable: '',  // the datatables object if we have datatable

    _currentRow: '', // current row obj if we have datatable

    _params: [], // the datatables params

    _cols: [
        {key: 'id', data: 'id', name: 'id', searchable: false},
        {key: 'name', data: 'name', name: 'name'},
        {key: 'mobile', data: 'mobile', name: 'mobile'},
        {key: 'start', data: 'start', name: 'start'},
        {key: 'end', data: 'end', name: 'end'},
        {key: 'wechat_no', data: 'wechat_no', name: 'wechat_no'},
        {key: 'brand', data: 'brand', name: 'brand'},
        {key: 'series', data: 'series', name: 'series'},
        {key: 'year', data: 'year', name: 'year'},
        {key: 'available_seats', data: 'available_seats', name: 'available_seats'},
        {key: 'created_at', data: 'created_at', name: 'created_at'}
    ],

    init: function() {
        this.init_datatable();
        //this.init_dt_btns();
    },

    init_datatable: function () {
        var params = {};
        params.ajax = "/admin/keyeenrollments/search";
        params.columns = this._cols;
        params.colDefs = [
            {
                "render": function (data, type, row) {
                    return moment.unix(data).format('YYYY-MM-DD HH:mm:ss');
                },
                "targets": [10]
            }
        ];
        params.language = {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Chinese.json"
        };
        // params.columns.push(
        //     {
        //         "class": "details-control",
        //         "orderable": false,
        //         "searchable": false,
        //         "data": null,
        //         "render": function (data, type, row) {
        //             var html = '';
        //             html += '<a href="javascript:;" class="edit btn btn-xs"><i class="fa fa-edit" aria-hidden="true"></i>编辑</a>';
        //             if(data.active == 1)
        //                 html += '<a href="javascript:;" class="deactive-route btn btn-xs"><i class="fa fa-lock" aria-hidden="true"></i>禁用</a>';
        //             else
        //                 html += '<a href="javascript:;" class="active-route btn btn-xs"><i class="fa fa-unlock" aria-hidden="true"></i>启用</a>';
        //             return html;
        //         }
        //     }
        // );
        if (typeof $('#dataTable').attr('id') === 'undefined')
            return false;
        if (this._theTable)
            this._theTable.destroy();
        this._theTable = $('#dataTable').DataTable({
            columnDefs: params.colDefs,
            searching: true,
            processing: false,
            serverSide: true,
            width: "90%",
            height: 'auto',
            ajax: {
                url: params.ajax,
                data: function (d) {
                    d.export = $('#export').val();
                },
            },
            columns: params.columns,
            language: params.language,
            order: [[0, "desc"]],
            dom: '<"toolbar">rtip',
        })
    },

    init_dt_btns: function() {
        var that = this;
        $('#dataTable').on('draw.dt', function () {
            $('.edit').on('click', null, function (e) {
                var data = that._theTable.row($(this).parents('tr')).data();
                that._currentRow = that._theTable.row($(this).parents('tr'));
                window.location.href = '/admin/keyeroutes/'+data.id+'/edit';
                return;
            });

            $('.deactive-route').on('click', null, function (e) {
                var data = that._theTable.row($(this).parents('tr')).data();
                that._currentRow = that._theTable.row($(this).parents('tr'));
                swal({
                        title: "您确定要禁用该记录吗?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "禁用",
                        cancelButtonText: "取消",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            that.active_route(data, 0);
                        }
                    });
                e.stopPropagation();
                return true;
            });

            $('.active-route').on('click', null, function (e) {
                var data = that._theTable.row($(this).parents('tr')).data();
                that._currentRow = that._theTable.row($(this).parents('tr'));
                swal({
                        title: "您确定要启用该记录吗?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "启用",
                        cancelButtonText: "取消",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            that.active_route(data, 1);
                        }
                    });
                e.stopPropagation();
                return true;
            });
        });
    },

    active_route: function (data, val) {
        var that = this;
        var params = {};
        params.val = val;
        params.id = data.id;
        $.ajax({
            type: "POST",
            data: params,
            dataType: "json", //dataType (xml html script json jsonp text)
            url: '/admin/keyeroutes/active',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //beforeSend: bstool.submit_loading, //执行ajax前执行loading函数.直到success
            success: function (rs) {//成功获得的也是json对象
                if (rs.errno == 0) {
                    //swal.close();
                    var text = params.val == 1 ? '启用改条目成功!' : '禁用该条目成功!';
                    site.showSuccess(text);
                    that._theTable.draw();
                    // check if to show new btn
                    // if (moment.unix(data.start_date).format('YYYY-MM-DD') == moment.unix(parseInt($('#start_date').val())).format('YYYY-MM-DD')) {
                    //     $('#new_presell_btn').show();
                    // }
                    return;
                } else {
                    site.showError(rs.msg);
                    return false;
                }
            }
        });
    }
};
