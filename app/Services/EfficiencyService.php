<?php


namespace App\Services;


use App\Category;
use App\Ttraits\AttributesToArray;

class EfficiencyService
{
    use AttributesToArray;

    public const MIN = 0.7;
    public const MAX = 1.2;

    public $efficiency;
    public $currentlyCompleted;

    public function __construct(int $efficiency, float $currentlyCompleted)
    {
        $this->efficiency = $efficiency;
        $this->currentlyCompleted = $currentlyCompleted;
    }

    public function getCalculateEfficiency(): float
    {
        if (!$this->efficiency || !$this->currentlyCompleted) {
            return 0;
        }

        $coefficient = $this->currentlyCompleted / 100;

        if ($coefficient > self::MAX) {
            $coefficient = self::MAX;
        }

        if ($coefficient < self::MIN) {
            $coefficient = self::MIN;
        }

        return number_format($coefficient * $this->efficiency, 2, ".", "");
    }

    public static function container(Category $category): ?EfficiencyService
    {
        if ($category->forecastService) {
            return new self($category->efficiency, $category->forecastService['currentlyCompleted']);
        }

        return null;
    }
}
