<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Statistic;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function makeMoney(Request $request): JsonResponse
    {
        $data = $request->only(
            (new Statistic)->getFillable()
        );

        $statistic = Statistic::where(Statistic::CATEGORY_ID, $data[Statistic::CATEGORY_ID])
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($statistic) {
            $statistic->count = $data[Statistic::COUNT];
            $statistic->save();
        } else {
            $statistic = Statistic::create($data);
        }

        return response()->json($statistic);
    }
}
