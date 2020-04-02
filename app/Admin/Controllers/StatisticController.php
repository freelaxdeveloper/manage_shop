<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use App\Statistic;

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
        $grid = new Grid(new Statistic);

        $grid->column(Statistic::COUNT, __('Количество'))->editable()->sortable();
        $grid->column('date', __('Дата'))->sortable();
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
        $form = new Form(new Statistic);

        $form->text(Statistic::COUNT, __('Количество'));
        $form->text('created_at', __('Дата'));

        return $form;
    }
}
