<?php


namespace App\Http\Controllers\Api;

use App\Category;
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
        $user = \Auth::user()->loadMissing('sites');
        $category = Category::with('site')->findOrFail($request->input(Statistic::CATEGORY_ID));

        if (!$user->sites()->where('id', optional($category->site)->id)->count()) {
            abort(403, __('Access denied'));
        }
//        dd($category->site->id);

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
