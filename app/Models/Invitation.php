<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $fillable = [
        'user_id',
        'invited_user_id',
        'invitation_code',
        'used',
        'active',
    ];

    public static function codeValid($code) {
        return Invitation::where('invitation_code', '=', $code)
                        ->where('used', '!=', 1)
                        ->where('active', '=', 1)
                        ->whereNull('deleted_at')
                        ->first();
    }
}
