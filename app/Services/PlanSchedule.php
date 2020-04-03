<?php


namespace App\Services;

use App\Category;
use App\Ttraits\AttributesToArray;
use Illuminate\Database\Eloquent\Collection;

class PlanSchedule
{
    use AttributesToArray;

    public $categories;

    public $sumPlan;
    public $sumForecast;
    public $sumCurrent;

    public function __construct(Collection $categories)
    {
        $this->categories = $categories;

        $this->sumPlan = $this->getSumPlan();
        $this->sumForecast = $this->getSumForecast();
        $this->sumCurrent = $this->getSumCurrent();
    }

    /**
     * @param int $value
     * @return string
     */
    private static function numberFormat(int $value): string
    {
        return number_format($value, 2, ".", "");
    }

    /**
     * @return string
     */
    public function getPercentCurrent(): string
    {
        try {
            return self::numberFormat($this->sumCurrent / $this->sumPlan * 100);
        } catch (\Exception $e) {
            return '0';
        }
    }

    /**
     * @return string
     */
    public function getPercentForecast(): string
    {
        try {
            return self::numberFormat($this->sumForecast / $this->sumPlan * 100);
        } catch (\Exception $e) {
            return '0';
        }
    }

    /**
     * @return int
     */
    public function getSumPlan(): int
    {
        return $this->categories->where(Category::UNIT, 'грн.')
            ->sum('forecastService.plan');
    }

    /**
     * @return int
     */
    public function getSumForecast(): int
    {
        return $this->categories->where(Category::UNIT, 'грн.')
            ->sum('forecastService.forecastMoney');
    }

    /**
     * @return int
     */
    public function getSumCurrent(): int
    {
        return $this->categories->where(Category::UNIT, 'грн.')
            ->sum('forecastService.performanceCurrent');
    }

    /**
     * @param Collection|null $categories
     * @return PlanSchedule
     */
    public static function container(?Collection $categories = null): PlanSchedule
    {
        if (!$categories) {
            $categories = Category::with('plan')->get();
            $categories->each->setAppends(['forecastService']);
        }

        return new self($categories);
    }
}
