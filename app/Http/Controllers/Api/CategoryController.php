<?php


namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
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
        $categories->each->setAppends(['forecastService']);


        $sumPlan = $categories->where(Category::UNIT, 'грн.')->sum('forecastService.plan');
        $sumForecast = $categories->where(Category::UNIT, 'грн.')
                            ->sum('forecastService.forecastMoney');
        $sumCurrent = $categories->where(Category::UNIT, 'грн.')
                            ->sum('forecastService.performanceCurrent');

        try {
            $percentCurrent = number_format($sumCurrent / $sumPlan * 100, 2, ".", "");
            $percentForecast = number_format($sumForecast / $sumPlan * 100, 2, ".", "");
        } catch (\Exception $e) {
            $percentCurrent = $percentForecast = 0;
        }

        return response()->json(compact(
            'categories', 'sumPlan', 'sumForecast', 'sumCurrent', 'percentCurrent', 'percentForecast'
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
