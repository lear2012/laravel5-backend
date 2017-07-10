<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyeEnrollment extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $fillable = [
        'name',
        'mobile',
        'start',
        'end',
        'wechat_no',
        'brand',
        'series',
        'year',
        'available_seats',
        'seats_taken'
    ];

    public function lifts(){
        return $this->hasMany('App\Models\KeyeLift');
    }

    /*
     * 获取可搭载车辆列表
     * */
    public static function getLiftingCars($params=[]) {
        if(isset($params['keyword']) && $params['keyword'] != '')
            return KeyeEnrollment::where('status', '=', 1)
                ->where('start', 'like', '%'.$params['keyword'].'%')
                ->whereNull('deleted_at')
                ->whereRaw('available_seats > seats_taken')
                ->select('*')
                ->orderBy('id', 'desc')
                ->paginate(2);
        return KeyeEnrollment::where('status', '=', 1)
            ->whereNull('deleted_at')
            ->whereRaw('available_seats > seats_taken')
            ->select('*')
            ->orderBy('id', 'desc')
            ->paginate(2);
    }
}
