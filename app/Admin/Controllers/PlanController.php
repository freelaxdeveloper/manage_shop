<?php

namespace App\Admin\Controllers;

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

        $grid->column('id', __('ID'))->sortable();
        $grid->column('count', __('Количество'))->editable()->sortable();
        $grid->column('month', __('Месяц'))->editable()->sortable();
        $grid->column('year', __('Год'))->editable()->sortable();
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
        $show->field('month', __('Месяц'));
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
        $form = new Form(new Plan);
        $form->hidden(Plan::CATEGORY_ID)->value(request()->input(Plan::CATEGORY_ID));

//        $form->display('id', __('ID'));
        $form->text(Plan::COUNT, __('Количество'));
        $form->month('month', __('Месяц'))->default(now()->month);
        $form->year('year', __('Год'))->default(now()->year);
//        $form->display('created_at', __('Created At'));
//        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
