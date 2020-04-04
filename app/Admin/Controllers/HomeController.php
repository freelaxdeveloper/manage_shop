<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\Services\ChartPlanScheduleService;
use App\Services\PlanSchedule;
use App\Site;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
//    public function index(Content $content)
//    {
//        return $content
//            ->title('Dashboard')
//            ->description('Description...')
//            ->row(Dashboard::title())
//            ->row(function (Row $row) {
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::environment());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::extensions());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::dependencies());
//                });
//            });
//    }

    public function index(Content $content)
    {
        $data = ChartPlanScheduleService::getInstanse()->toJson();
        $title = 'Выполнение общего плана за ' . date('Y') . ' год';
        $site = Site::find(session()->get('site_id'));

        return $content
            ->header('Выполнение общего плана')
            ->body(new Box("{$site->name}", view('admin.chartjs', [
                'datasets' => $data,
                'title' => $title,
            ])));
    }
}
