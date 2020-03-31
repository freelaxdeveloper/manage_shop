<?php

namespace App\Admin\Controllers;

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

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Имя'))->editable()->sortable();
        $grid->column('unit', __('Единица измерения'))->editable()->sortable();
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
        $show = new Show(Category::findOrFail($id));

//        $show->field('id', __('ID'));
        $show->field('name', __('Имя'));
        $show->field('unit', __('Единица измерения'));
//        $show->field('created_at', __('Created at'));
//        $show->field('updated_at', __('Updated at'));

        $show->statistics('Статистика', function (Grid $stripe) {
            $stripe->setResource('/admin/statistics');

            $stripe->disableCreateButton();
            $stripe->disableActions();
            $stripe->disableFilter();
            $stripe->disableRowSelector();
            $stripe->disablePagination();
            $stripe->disableExport();

            $stripe->column('count', 'Количество')->editable();
            $stripe->column('date');
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
        $form = new Form(new Category);

//        $form->display('id', __('ID'));
        $form->text(Category::NAME, __('Имя'));
        $form->text(Category::UNIT, __('Единица измерения'));
//        $form->display('created_at', __('Created At'));
//        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
