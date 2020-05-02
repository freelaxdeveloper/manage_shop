<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    public const ID = 'id';
    public const CATEGORY_ID = 'category_id';
    public const COUNT = 'count';
    public const DATE = 'date';

    protected $fillable = [
        self::CATEGORY_ID,
        self::COUNT,
        self::DATE,
    ];

    protected $appends = [
        'day'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getDayAttribute()
    {
        return $this->created_at->format('d');
    }

//    public function getDateAttribute()
//    {
//        return $this->created_at->isoFormat('MMMM Do YY');
//    }
}
