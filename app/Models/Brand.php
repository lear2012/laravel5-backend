<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    //
    use SoftDeletes;

    protected $table = 'brands';

    protected $dateFormat = 'U';

    protected $fillable = [
        'code',
        'name',
        'detail',
        'active',
    ];

    public function series()
    {
        return $this->hasMany('App\Models\Sery', 'brand_id', 'id');
    }

}
