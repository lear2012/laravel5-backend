<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChetieApply extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $table = 'chetie_applys';

    protected $fillable = [
        'name',
        'mobile',
        'brand',
        'start',
        'end',
        'address',
        'detail',
        'status'
    ];
}
