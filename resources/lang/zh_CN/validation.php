<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute必须接受.',
    'active_url'           => ':attribute不是一个合法的URL.',
    'after'                => ':attribute 必须是一个大于:date的日期.',
    'alpha'                => ':attribute只能包含字母.',
    'alpha_dash'           => ':attribute只能包含字母，数字和中划线.',
    'alpha_num'            => ':attribute只能包含字母和数字.',
    'array'                => ':attribute必须是一个数组.',
    'before'               => ':attribute必须是一个在:date之前的日期.',
    'between'              => [
        'numeric' => ':attribute必须在:min到:max之间.',
        'file'    => ':attribute必须在:min到:max kilobytes之间.',
        'string'  => ':attribute必须在:min到:max个字符之间.',
        'array'   => ':attribute必须在:min到:max之间.',
    ],
    'boolean'              => ':attribute必须是true或者false.',
    'confirmed'            => '两次:attribute输入不一致',
    'date'                 => ':attribute不是一个合法的日期格式.',
    'date_format'          => ':attribute必须是:format格式.',
    'different'            => ':attribute和:other必须不一样.',
    'digits'               => ':attribute必须是:digits位数字.',
    'digits_between'       => ':attribute必须是介于:min和:max的数字.',
    'distinct'             => ':attribute值重复了.',
    'email'                => ':attribute必须是一个合法的电子邮箱地址.',
    'exists'               => '您选择的:attribute不正确.',
    'filled'               => ':attribute是必须的.',
    'image'                => ':attribute必须是图片文件.',
    'in'                   => ':attribute不合法.',
    'in_array'             => ':attribute必须是:other里的值.',
    'integer'              => ':attribute必须是个整数.',
    'ip'                   => ':attribute必须是合法的IP地址.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute不能大于:max.',
        'file'    => ':attribute不能大于:max kilobytes.',
        'string'  => ':attribute不能大于:max个字符.',
        'array'   => ':attribute不能多于:max.',
    ],
    'mimes'                => ':attribute允许的文件格式: :values.',
    'min'                  => [
        'numeric' => ':attribute至少为:min.',
        'file'    => ':attribute至少为:min kilobytes.',
        'string'  => ':attribute至少为:min个字符.',
        'array'   => ':attribute至少为:min.',
    ],
    'not_in'               => '您选择的:attribute不合法.',
    'numeric'              => ':attribute必须是数字.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute格式不正确.',
    'required'             => ':attribute是必须填写的.',
    'required_if'          => '当:other值为:value时:attribute是必须填写的.',
    'required_unless'      => '除非:other在:values这些值里，:attribute是必须填写的.',
    'required_with'        => '当值:values出现时:attribute是必须填写的.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute与:other必须匹配.',
    'size'                 => [
        'numeric' => ':attribute长度必须为:size.',
        'file'    => ':attribute必须为:size kilobytes.',
        'string'  => ':attribute必须为:size个字符.',
        'array'   => '=:attribute必须包含:size个.',
    ],
    'string'               => ':attribute必须是个字符串.',
    'timezone'             => ':attribute必须是个合法的时区.',
    'unique'               => ':attribute已经被使用.',
    'url'                  => ':attribute格式不正确.',
    'captcha'  => '验证码错误',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'password' => '密码',
        'email' => '电子邮箱地址',
        'name' => '名称',
        'display_name' => '显示名称',
        'role_ids' => '用户角色',
        'channel_id' => '栏目',
        'pos' => '位置',
        'channel_type' => '栏目类型',
        'img' => '图片',
        'from' => '投诉类型',
        'mobile' => '手机号',
    ],

];
