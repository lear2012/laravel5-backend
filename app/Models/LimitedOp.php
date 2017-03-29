<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LimitedOp extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $fillable = [
        'identifier',
        'action_type',
        'content',
    ];
}
