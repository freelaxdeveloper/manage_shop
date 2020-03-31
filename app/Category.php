<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Services\PerformanceForecast;

/**
 * @property HasMany statistics
 * @property array forecastService
 * @property string name
 * @property string plan
 * @property string efficiency
 * @method static Category first()
 * @method static Collection get()
 * @method static Category create(array $data)
 */
class Category extends Model
{
    use SoftDeletes;

    public const ID = 'id';
    public const NAME = 'name';
    public const PLAN = 'plan';
    public const UNIT = 'unit';
    public const EFFICIENCY = 'efficiency';

    protected $fillable = [
        self::NAME,
        self::PLAN,
        self::UNIT,
        self::EFFICIENCY,
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    public static $forecastMonth;

    public function scopeMoney($query)
    {
        $query->where(self::UNIT, 'грн.');
    }

    /**
     * @return HasMany
     */
    public function statistics()
    {
        return $this->hasMany(Statistic::class);
    }

    /**
     * @return array
     */
    public function getForecastServiceAttribute(): array
    {
        return PerformanceForecast::container($this, self::$forecastMonth)->toArray();
    }
}
