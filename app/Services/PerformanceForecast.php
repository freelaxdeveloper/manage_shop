<?php


namespace App\Services;

use App\{
    Category, Statistic
};
use App\Ttraits\AttributesToArray;
use Carbon\Carbon;

/**
 * Class PerformanceForecast
 * @package App\Services
 */
class PerformanceForecast
{
    use AttributesToArray;

    public $plan; // план
    public $performance; // производительность
    public $toDayNumber; // текущее число
    public $daysInMonth; // количество дней в этом месяце
    public $forecast; // прогноз
    public $currentlyCompleted; // на текущий момент выполнено

    public function __construct(int $plan, array $performance)
    {
        $catbon = now();

        $this->plan = $plan;
        $this->performance = $performance;

        $this->toDayNumber = $catbon->day;
        $this->daysInMonth = $catbon->daysInMonth;

        $this->forecast = $this->seerHelp('getForecastMoney');
        $this->currentlyCompleted = $this->seerHelp('getPerformanceCurrent');
    }

    /**
     * @param string $methodName
     * @return float
     */
    public function seerHelp(string $methodName): float
    {
        $forecastMoney = $this->{$methodName}();
        if (!$forecastMoney) {
            return 0;
        }
        $forecast = $forecastMoney / $this->plan * 100;

        return number_format($forecast, 2, ".", "");
    }

    /**
     * Прогнозирование заработанных денег
     *
     * @return float
     */
    public function getForecastMoney(): float
    {
        $current = $this->getPerformanceCurrent();
        $forecast = $this->getPerformanceAvarageCurrent() * ($this->daysInMonth - $this->toDayNumber);
        $sum = $current + $forecast;

        return $sum;
    }

    /**
     * Фактическая производитеьность
     *
     * @return float
     */
    public function getPerformanceCurrent(): float
    {
        return array_sum($this->performance);
    }

    /**
     * Средняя фактическая производитеьность
     *
     * @return float
     */
    public function getPerformanceAvarageCurrent(): float
    {
        $count = count($this->performance);
        $count += $this->toDayNumber - $count;

        if (!$count) {
            return 0;
        }

        return array_sum($this->performance) / $count;
    }

    /**
     * Производительность должна быть на данный момент
     *
     * @return float
     */
    public function getPerformanceShouldCurrentMoment(): float
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
        $performanceToDayAvg = $this->plan / $this->daysInMonth;
        $performanceToDay = ($this->plan - $this->getPerformanceCurrent()) / ($this->daysInMonth - $this->toDayNumber);

        if ($performanceToDay < $performanceToDayAvg) {
            $performanceToDay = $performanceToDayAvg;
        }

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
