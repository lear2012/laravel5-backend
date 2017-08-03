<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionEnrollment extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $fillable = [
        'name',
        'mobile',
        'wechat_no',
        'section_id',
        'brand',
        'status'
    ];

    public static function getSectionNameById($id) {
        if(!$id || !is_numeric($id))
            return 1;
        $sections = [
            1 => '新疆',

        ];
        return $sections[$id];
    }

}
