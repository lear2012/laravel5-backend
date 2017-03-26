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
        'firstchar',
        'detail',
        'active',
    ];

    public function series()
    {
        return $this->hasMany('App\Models\Sery', 'brand_id', 'id');
    }

    public static function getActiveBrands() {
        return Brand::where('active', '=', 1)
            ->whereNull('deleted_at')
            ->select('name', 'firstchar','code', 'detail')
            ->get();
    }
}
