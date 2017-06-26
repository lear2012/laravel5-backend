var contacts_page = {

    _theTable: '',  // the datatables object if we have datatable

    _currentRow: '', // current row obj if we have datatable

    _params: [], // the datatables params

    _cols: [
        {key: 'id', data: 'id', name: 'id', searchable: false},
        {key: 'company_name', data: 'company_name', name: 'company_name'},
        {key: 'name', data: 'name', name: 'name'},
        {key: 'phone', data: 'phone', name: 'phone'},
        {key: 'content', data: 'content', name: 'content'},
        {key: 'created_at', data: 'created_at', name: 'created_at'},
    ],

    _contactus_cols: [
        {key: 'id', data: 'id', name: 'id', searchable: false},
        {key: 'name', data: 'name', name: 'name'},
        {key: 'phone', data: 'phone', name: 'phone'},
        {key: 'content', data: 'content', name: 'content'},
        {key: 'created_at', data: 'created_at', name: 'created_at'},
    ],

    init: function() {
        this.init_datatable();
    },

    init_datatable: function () {
        var params = {};
        params.ajax = "/admin/keyecontacts/search";
        params.columns = this._cols;
        params.colDefs = [
            {
                "render": function (data, type, row) {
                    return data.length>20 ? data.substring(0,20)+'...' : data;
                },
                "targets": 4
            },
            {
                "render": function (data, type, row) {
                    return moment.unix(data).format('YYYY-MM-DD HH:mm:ss');
                },
                "targets": 5
            },
        ];
        params.language = {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Chinese.json"
        };
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

    init_contactus_datatable: function () {
        var params = {};
        params.ajax = "/admin/keyecontacts/searchContact";
        params.columns = this._contactus_cols;
        params.colDefs = [
            {
                "render": function (data, type, row) {
                    return data.length>20 ? data.substring(0,20)+'...' : data;
                },
                "targets": 3
            },
            {
                "render": function (data, type, row) {
                    return moment.unix(data).format('YYYY-MM-DD HH:mm:ss');
                },
                "targets": 4
            },
        ];
        params.language = {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Chinese.json"
        };
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
};
