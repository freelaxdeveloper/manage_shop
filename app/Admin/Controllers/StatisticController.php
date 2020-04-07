<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Plan;
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
        $grid->model()->whereHas('category');

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

    public function store()
    {
        $data = request()->only(
            (new Statistic())->getFillable()
        );
        $data['created_at'] = request()->input('date');

        $data = [$data];

        Statistic::insert($data);
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
        $form->date('created_at', __('Дата'));

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
