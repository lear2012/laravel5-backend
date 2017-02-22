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
        'uid',
        'real_name',
        'id_no',
        'mobile',
        'member_no',
        'invite_no',
        'keye_age',
        'quotation',
        'nest_info',
        'avatar',
        'wechat_id',
        'wechat_no',
        'sex',
        'province',
        'city',
        'dist',
        'address',
        'brand',
        'series',
        'year'
    ];

    protected $guarded = [];

        
}