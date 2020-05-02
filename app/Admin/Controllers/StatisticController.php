<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Plan;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use App\Statistic;
use Illuminate\Http\Response;

class StatisticController extends AdminController
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
        $categories = Category::get()->pluck(Category::NAME, Category::ID);

        $grid = new Grid(new Statistic);
        $grid->model()->whereHas('category');

        $grid->filter(function($filter) use ($categories) {

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add a column filter
            $filter->in(Statistic::CATEGORY_ID, __('Категория'))->multipleSelect($categories);
            $filter->date(Statistic::DATE, __('Дата'));

            $filter->between(Statistic::COUNT, __('Количество'));

        });

        $grid->column(Statistic::COUNT, __('Количество'))->editable()->sortable();
        $grid->column(Statistic::DATE, __('Дата'))->editable('date')->sortable();
        $grid->column('category.name', __('Категория'))->sortable();

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
        $show = new Show(Statistic::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field(Statistic::COUNT, __('Количество'));
        $show->field('date', __('Дата'));

        $show->category('Категория', function ($author) {

            $author->setResource('/admin/categories');

            $author->field('name');
            $author->field('unit');
        });

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

        $form = new Form(new Statistic);

        $form->select(Statistic::CATEGORY_ID, 'Категория')
            ->options($categories)
            ->default(request()->input(Statistic::CATEGORY_ID))
            ->required();
        $form->text(Statistic::COUNT, __('Количество'))->required();
        $form->date('date', __('Дата'))->required();

        $form->footer(function ($footer) {

            // disable `View` checkbox
            $footer->disableViewCheck();

            // disable submit btn
//            $footer->disableSubmit();

            // disable `Continue editing` checkbox
            $footer->disableEditingCheck();

            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();

        });

        return $form;
    }
}
