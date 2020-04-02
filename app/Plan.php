<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
