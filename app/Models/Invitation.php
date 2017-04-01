<?php

namespace App\Models;

use App\Mail\InvitationCodes;
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

    public static function generateInvitationCodes($c, &$codes=[], $user_id=0) {
        if(!$c || !is_numeric($c))
            $c = 1;
        if(count($codes) == (int)$c)
            return $codes;
        //
        $str = strtoupper(str_random(6));
        // check existence of this code
        $invitation = Invitation::where('invitation_code', '=', $str)->first();
        if($invitation) {
            // 如果存在重新生成
            self::generateInvitationCodes($c, $codes, $user_id);
        } else {
            // 否则生成邀请码
            $invitation = new Invitation();
            $invitation->user_id = $user_id;
            $invitation->invitation_code = $str;
            $invitation->used = 0;
            $invitation->active = 1;
            $invitation->save();
            $codes[] = $str;
            self::generateInvitationCodes($c, $codes, $user_id);
        }
    }
}
