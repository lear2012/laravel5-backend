<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sery extends Model
{
    //
    use SoftDeletes;

    protected $table = 'series';

    protected $dateFormat = 'U';

    protected $fillable = [
        'code',
        'brand_id',
        'name',
        'detail',
        'active',
    ];

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function motomodels()
    {
        return $this->hasMany('App\Models\Motomodel', 'sery_id', 'id');
    }

}
