<?php
return [
    'site_title' => '后台管理系统',
    'per_page' => 10,
    'uploads' => [
        'storage' => 'local',
        'web_path' => '/uploads',
        'images'  => '/uploads/images'
    ],
    'default_image' => '/uploads/images/default_image.jpg',
    'default_avatar' => '/img/avatar5.png',
    'static_domain' => '',

    //
    'register_member_code' => 2,
    'paid_member_code' => 3,
    'exp_driver_code' => 4,
    'admin_code' => 1,


    // limited actions
    'limited_ops' => [
        'sms_register' => 1,
        'id_card_verify' => 2,
    ],
    'ID_CARD_VERIFY_DAY_ALLOW' => 3, // 实名认证每天可以验证的次数
    'SMS_REGISTER_VERIFY_DAY_ALLOW' => 3, // 注册短信验证每天可以发送的次数
    'top_discount_user_count' => 50, // 前50个付费用户只需付费1元
    'full_member_fee' => 66600, // 全额付费用户需要666元
    'discount_member_fee' => 100, // 会员折扣价1元
    'MAIL_FROM' => '可野Club',
    'MEMBER_PAID_MAIL_SUBJECT' => '欢迎加入可野Club付费会员，成为可野人',
    'MEMBER_INVITATION_CODES_TEMPLATE_ID' => 'kYJXCZzUXn1uzjNK1phCA-JPGSaPyYk9tfAO9ILTxIk',
    'KY_MEMBER_NO_PREFIX' => 'KY.88',
    'car_img_width' => 180,
    'car_img_height' => 120,
    'car_img_max' => 9, // 最大上传车的图片数量
    'car_img_path' => '/uploads/images/car_imgs',
    'car_img_valid_ext' => [
        'jpg',
        'png',
        'jpeg'
    ],
    'avatar_img_width' => 160,
    'avatar_img_height' => 160,
    'order_valid_seconds' => (2*3600-10), // two hours

    'datatables' => [
        'search' => [
            'smart'            => true,
            'case_insensitive' => true,
            'use_wildcards'    => false,
        ],

        'fractal' => [
            'serializer' => 'League\Fractal\Serializer\DataArraySerializer',
        ],

        'script_template' => 'datatables::script',
        'language' => [
            'processing' => "处理中",
            'search' => "搜索&nbsp;:",
            'lengthMenu' => "每页 _MENU_ 条记录",
            'info' => "显示 _START_ 到 _END_ 共 _TOTAL_ 记录",
            'infoEmpty' => "没有任何记录",
            'infoFiltered' => "(从 _MAX_ 条记录中过滤)",
            'infoPostFix' => "",
            'loadingRecords' => "正在载入记录...",
            'zeroRecords' => "没有任何记录",
            'emptyTable' => "空表格",
            'paginate' => [
                'first' => "首页",
                'previous' => "上一页",
                'next' => "下一页",
                'last' => "末页"
            ],
            'aria' => [
                'sortAscending' => "升序",
                'sortDescending' => "降序"
            ]
        ]
    ],
    'lift_page_size' => 5
];
