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
    'top_discount_user_count' => 2, // 前50个付费用户只需付费1元
    'full_member_fee' => 60000, // 全额付费用户需要600元
    'discount_member_fee' => 100, // 会员折扣价1元
    'MAIL_FROM' => '可野Club',
    'MEMBER_PAID_MAIL_SUBJECT' => '欢迎加入可野Club付费会员，成为可野人',
    'MEMBER_INVITATION_CODES_TEMPLATE_ID' => 'kYJXCZzUXn1uzjNK1phCA-JPGSaPyYk9tfAO9ILTxIk',
    'KY_MEMBER_NO_PREFIX' => 'KY.88',
];
