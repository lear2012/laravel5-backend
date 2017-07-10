<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyeClub extends Model
{
    //
    use SoftDeletes;

    protected $table = 'keye_clubs';

    protected $dateFormat = 'U';

    protected $fillable = [
        'club_name',
        'name',
        'mobile',
        'status'
    ];
}
