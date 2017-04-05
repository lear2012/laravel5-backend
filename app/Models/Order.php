<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $primaryKey = 'id';

    protected $fillable = [
        'oid',
        'title',
        'detail',
        'amount',
        'wechat_openid',
        'wechat_no',
        'memo',
        'order_type',
        'status',
        'pay_at'
    ];

}
