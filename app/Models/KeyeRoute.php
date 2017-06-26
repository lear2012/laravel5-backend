<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyeRoute extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $fillable = [
        'title',
        'start',
        'end',
        'cover_img',
        'url',
        'ord',
        'votes',
        'is_front',
        'active'
    ];

    public function getRouteList() {
        return KeyeRoute::where('active', '=', 1)
            ->where('is_front', '=', 1)
            ->whereNull('deleted_at')
            ->orderBy('ord', 'asc')
            ->get();
    }
}
