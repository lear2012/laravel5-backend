<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyeLift extends Model
{
    use SoftDeletes;

    protected $table = 'keye_lifts';

    protected $dateFormat = 'U';
    //
    public function enrollment(){
        return $this->belongsTo('App\Models\KeyeEnrollment', 'enrollment_id');
    }

    protected $fillable = [
        'enrollment_id',
        'name',
        'mobile',
        'wechat'
    ];
}
