<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserProfile
 */
class UserProfile extends Model
{
    use SoftDeletes;

    protected $table = 'user_profiles';

    protected $dateFormat = 'U';

    protected $fillable = [
        'user_id',
        'real_name',
        'id_no',
        'member_no',
        'invite_no',
        'keye_age',
        'quotation',
        'nest_info',
        'avatar',
        'wechat_id',
        'wechat_nick',
        'wechat_no',
        'sex',
        'province',
        'city',
        'dist',
        'address',
        'brand',
        'series',
        'model',
        'year',
        'buy_year',
        'self_get',
        'is_verified',
        'car_no',
        'car_imgs',
    ];

    protected $guarded = [];

        
}
