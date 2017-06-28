<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyeEnrollment extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $fillable = [
        'name',
        'mobile',
        'start',
        'end',
        'wechat_no',
        'brand',
        'series',
        'year',
        'available_seats',
    ];
}
