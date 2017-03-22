<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motomodel extends Model
{
    //
    use SoftDeletes;

    protected $table = 'motomodels';

    protected $dateFormat = 'U';

    protected $fillable = [
        'code',
        'sery_id',
        'name',
        'detail',
        'active',
    ];

    public function sery()
    {
        return $this->belongsTo('App\Models\Sery', 'sery_id');
    }

}
