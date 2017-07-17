<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicImage extends Model
{
    //
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $fillable = [
        'title',
        'cover_img',
        'url',
        'active'
    ];

    public static function getActiveImageList() {
        return TopicImage::where('active', '=', 1)
            ->whereNull('deleted_at')
            ->orderBy('id', 'asc')
            ->get();
    }
}
