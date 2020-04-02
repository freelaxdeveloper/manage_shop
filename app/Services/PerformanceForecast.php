<?php


namespace App\Services;

use App\{
    Category, Statistic
};
use Carbon\Carbon;

/**
 * Class PerformanceForecast
 * @package App\Services
 */
class PerformanceForecast
{
    public $plan; // план
    public $performance; // производительность
    public $toDayNumber; // текущее число
    public $daysInMonth; // количество дней в этом месяце
    public $forecast; // прогноз

    public function __construct(int $plan, array $performance)
    {
        $catbon = now();

        $this->plan = $plan;
        $this->performance = $performance;

        $this->toDayNumber = $catbon->day;
        $this->daysInMonth = $catbon->daysInMonth;

        $this->forecast = $this->seerHelp();
    }

    /**
     * @return float
     */
    public function seerHelp(): float
    {
        $forecastMoney = $this->getForecastMoney();
        if (!$forecastMoney) {
            return 0;
        }
        $forecast = $forecastMoney / $this->plan * 100;

        return number_format($forecast, 2, ".", "");
    }

    /**
     * Прогнозирование заработанных денег
     *
     * @return int
     */
    public function getForecastMoney(): int
    {
        $current = $this->getPerformanceCurrent();
        $forecast = $this->getPerformanceAvarageCurrent() * ($this->daysInMonth - $this->toDayNumber);
        $sum = $current + $forecast;

        return $sum;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = get_object_vars($this);
        $methods = get_class_methods(self::class);

        foreach ($methods as $method) {
            if (strpos($method, 'get') !== false) {
                $key = lcfirst(str_replace('get', '', $method));

                $data[$key] = $this->{$method}();
            }
        }

        return $data;
    }

    /**
     * Фактическая производитеьность
     *
     * @return int
     */
    public function getPerformanceCurrent(): int
    {
        return array_sum($this->performance);
    }

    /**
     * Средняя фактическая производитеьность
     *
     * @return int
     */
    public function getPerformanceAvarageCurrent(): int
    {
        $count = count($this->performance);

        if (!$count) {
            return 0;
        }

        return array_sum($this->performance) / $count;
    }

    /**
     * Производительность должна быть на данный момент
     *
     * @return int
     */
    public function getPerformanceShouldCurrentMoment(): int
    {
        return $this->toDayNumber * $this->getPerformanceToDay();
    }

    /**
     * Норма в день
     *
     * @return float
     */
    public function getPerformanceToDay(): float
    {
        $performanceToDay = $this->plan / $this->daysInMonth;

        if ($performanceToDay < 1) {
            return 1;
        }
        return $performanceToDay;
    }

    /**
     * @param Category $category
     * @param int|null $forecastMonth
     * @param int|null $forecastYear
     * @return PerformanceForecast|null
     */
    public static function container(Category $category, ?int $forecastMonth, ?int $forecastYear): ?PerformanceForecast
    {
        $forecastMonth = $forecastMonth ?? Carbon::now()->month;
        $forecastYear = $forecastYear ?? Carbon::now()->year;

        $category->loadMissing(['statistics' => function ($query) use ($forecastMonth, $forecastYear) {
            $query->whereMonth('created_at', $forecastMonth)->whereYear('created_at', $forecastYear);
        }]);

        $plan = $category->plan()
            ->where('month', $forecastMonth)
            ->where('year', $forecastYear)
            ->first()->count ?? null;

        if (!$plan) {
            return null;
        }

//        dd($plan);
        $performance = $category->statistics->pluck('count')->toArray();

        return new self($plan, $performance);
    }
}
