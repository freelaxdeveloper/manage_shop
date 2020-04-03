<?php


namespace App\Services;

use App\Category;
use App\Ttraits\AttributesToArray;
use Illuminate\Database\Eloquent\Collection;

class ChartPlanScheduleService
{
    private $data = [];

    public function __construct()
    {
        $this->data = $this->getData();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return ChartPlanScheduleService
     */
    public static function getInstanse(): ChartPlanScheduleService
    {
        return new self;
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        $data = [];
        $months = self::getMonthRange();

        for ($i = 1; $i <= count($months); $i++) {
            Category::$forecastMonth = $i;

            $planSchedule = PlanSchedule::container();

            foreach ($planSchedule->categories as $category) {
                $data[$category->id]['label'] = $category->name;
                $data[$category->id]['data'][] = $category->forecastService['currentlyCompleted'] ?? 0;
                $data[$category->id]['borderWidth'] = 1;
                $data[$category->id]['backgroundColor'] = $category->color ?? 'rgba(196,195,209,0.65)';
            }
        }

        return array_values($data);
    }

    /**
     * @return array
     */
    public static function getMonthRange(): array
    {
        return range(1, 12);
    }
}
