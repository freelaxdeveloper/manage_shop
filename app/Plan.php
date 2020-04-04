<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plan extends Model
{
    public const ID = 'id';
    public const CATEGORY_ID = 'category_id';
    public const COUNT = 'count';
    public const MONTH = 'month';
    public const YEAR = 'year';

    protected $fillable = [
        self::CATEGORY_ID,
        self::COUNT,
        self::MONTH,
        self::YEAR,
    ];

    protected $appends = [
        'month_name',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return string
     */
    public function getMonthNameAttribute(): string
    {
        return now()->setMonth($this->attributes[self::MONTH])->monthName;
    }

//    public function setMonthNameAttribute(): string
//    {
//        $this->attributes[self::MONTH] = 12;
//    }
//
//    protected static function boot()
//    {
//        parent::boot();
//
//        static::saving(function (Plan $media) {
//            dd($media->monthName);
//        });
//    }
}
