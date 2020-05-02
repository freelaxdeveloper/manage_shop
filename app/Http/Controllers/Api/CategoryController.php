<?php


namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Services\PlanSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        Category::$forecastMonth = $request->input('month');
        Category::$forecastYear = $request->input('year');

        $categories = Category::with('plan')->get();
        $categories->each->setAppends([
            'forecastService',
            'efficiencyService',
            'statisticData',
        ]);

        $planSchedule = PlanSchedule::container($categories)->toArray();

        $sumEfficiency = $categories->sum('efficiencyService.calculateEfficiency');

        extract($planSchedule);

        return response()->json(compact(
            'categories',
            'sumPlan',
            'sumForecast',
            'sumCurrent',
            'percentCurrent',
            'percentForecast',
            'sumEfficiency'
        ));
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        $category->append('forecastService');

        return response()->json($category);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->only(
            (new Category)->getFillable()
        );

        $category = Category::create($data);

        return response()->json($category);
    }


    /**
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $data = $request->only(
            (new Category)->getFillable()
        );

        $category->fill($data);
        $category->save();

        return response()->json($category);
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $is_deleted = $category->delete();
        } catch (\Exception $e) {
            return response()->json(false);
        }

        return response()->json($is_deleted);
    }
}
