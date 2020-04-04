<?php

namespace App\Admin\Controllers;

use App\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use App\Plan;

class PlanController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Статистика';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Plan);
        $grid->model()->whereHas('category');

        $grid->column('category.name', __('Категория'));
        $grid->column('count', __('План'))->editable()->sortable();
        $grid->column('month_name', __('Месяц'));
        $grid->column('year', __('Год'))->editable('year')->sortable();
//        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Plan::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('count', __('Количество'));
        $show->field('month_name', __('Месяц'));
        $show->field('year', __('Год'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $categories = Category::get()->pluck('name', 'id')->toArray();

        $form = new Form(new Plan);

        $form->select(Plan::CATEGORY_ID, 'Категория')
            ->options($categories)
            ->default(request()->input(Plan::CATEGORY_ID))
            ->required();

        $form->text(Plan::COUNT, __('Количество'))->required();
        $form->month('month', __('Месяц'))->default(now()->month)->required();
        $form->year('year', __('Год'))->default(now()->year)->required();

        $form->footer(function ($footer) {

            // disable `View` checkbox
            $footer->disableViewCheck();

            // disable `Continue editing` checkbox
            $footer->disableEditingCheck();

            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();

        });

        return $form;
    }
}
