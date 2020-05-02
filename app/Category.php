<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Services\{
    PerformanceForecast, EfficiencyService
};
use Illuminate\Database\Eloquent\Builder;

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
    public const UNIT = 'unit';
    public const COLOR = 'color';
    public const EFFICIENCY = 'efficiency';
    public const SITE_ID = 'site_id';

    protected $fillable = [
        self::NAME,
        self::UNIT,
        self::COLOR,
        self::SITE_ID,
        self::EFFICIENCY,
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    public static $forecastMonth;
    public static $forecastYear;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('site', function (Builder $builder) {
            $site_id = site()->getId();

            $builder->when($site_id, function (Builder $builder) use ($site_id) {
                $builder->where(self::SITE_ID, $site_id)->orWhere(self::SITE_ID, null);
            });
        });
    }

    public function scopeMoney($query)
    {
        $query->where(self::UNIT, 'грн.');
    }

    public function getStatisticDataAttribute()
    {
        $forecastMonth = self::$forecastMonth ?? Carbon::now()->month;
        $forecastYear = self::$forecastYear ?? Carbon::now()->year;

        $this->loadMissing('statistics');

        return $this->statistics()
          ->whereMonth('date', $forecastMonth)
          ->whereYear('date', $forecastYear)
          ->pluck('count');
    }

    /**
     * @return HasMany
     */
    public function statistics()
    {
        $forecastMonth = self::$forecastMonth ?? Carbon::now()->month;
        $forecastYear = self::$forecastYear ?? Carbon::now()->year;

        return $this->hasMany(Statistic::class)
            ->whereMonth('created_at', $forecastMonth)
            ->whereYear('created_at', $forecastYear)
            ->orderBy('created_at');
    }

    /**
     * @return HasOne
     */
    public function plan()
    {
        return $this->hasOne(Plan::class);
    }

    /**
     * @return HasMany
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    /**
     * @return BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * @return array|null
     */
    public function getForecastServiceAttribute(): ?array
    {
        return optional(PerformanceForecast::container($this, self::$forecastMonth, self::$forecastYear))->toArray();
    }

    /**
     * @return array|null
     */
    public function getEfficiencyServiceAttribute(): ?array
    {
        return optional(EfficiencyService::container($this))->toArray();
    }
}
