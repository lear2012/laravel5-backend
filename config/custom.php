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
];
