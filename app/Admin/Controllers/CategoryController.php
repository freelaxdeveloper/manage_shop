<?php

namespace App\Admin\Controllers;

use App\Site;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use App\Category;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Категории';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category);

        $sumEfficiency = Category::sum(Category::EFFICIENCY);

        $grid->column(Category::NAME, __('Название'))->editable()->sortable();
        $grid->column(Category::EFFICIENCY, __("Вес КПД (:value%)", ['value' => $sumEfficiency]))->editable()->sortable();

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
        $show = new Show(Category::findOrFail($id));

//        $show->field('id', __('ID'));
        $show->field('name', __('Имя'));
        $show->field('unit', __('Единица измерения'));
//        $show->field('created_at', __('Created at'));
//        $show->field('updated_at', __('Updated at'));

        $show->plans('План', function (Grid $plan) {
            $plan->model()->orderBy('year')->orderBy('month');

            $plan->setResource('/admin/plans');

//            $statistic->disableCreateButton();
//            $statistic->disableActions();
            $plan->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $actions->disableEdit();
            });
            $plan->disableFilter();
            $plan->disableRowSelector();
//            $statistic->disablePagination();
            $plan->disableExport();

            $plan->column('count', 'Количество')->editable();
            $plan->column('month', 'Месяц')->editable('month');
            $plan->column('year', 'Год')->editable('year');
//            $statistic->column('date');
//            $statistic->column('created_at')->editable('date');
        });

        $show->statistics('Статистика', function (Grid $statistic) {
            $statistic->model()->orderBy('created_at');

            $statistic->setResource('/admin/statistics');

            $statistic->disableCreateButton();
//            $statistic->disableActions();
            $statistic->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $actions->disableEdit();
            });
            $statistic->disableFilter();
            $statistic->disableRowSelector();
//            $statistic->disablePagination();
            $statistic->disableExport();

            $statistic->column('count', 'Количество')->editable();
            $statistic->column('date')->editable('date');
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
        $sites = Site::get()->pluck('name', 'id')->toArray();

        $form = new Form(new Category);

        $form->select(Category::SITE_ID, 'Сайт')
            ->options($sites)
            ->default(request()->input(Category::SITE_ID))
            ->required();

        $form->text(Category::NAME, __('Имя'))->required();
        $form->text(Category::EFFICIENCY, __('Вес КПД %'))->required();
        $form->text(Category::UNIT, __('Единица измерения'))
            ->required()
            ->help('грн., шт. ...');

        $form->color('color', 'Цвет на графике')->rgba();

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
