<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use App\Site;
use Illuminate\Http\Request;

class SiteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Сайты';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Site);
        $grid->model()->loadMissing('users');

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Имя'))->editable()->sortable();
        $grid->column('users')->display(function () {
            return implode(', ', $this->users()->pluck('name')->toArray());
        });

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
        $show = new Show(Site::findOrFail($id));

        $show->field('name', __('Название'));

        $show->users('Users', function ($comments) {

            $comments
                ->disableCreateButton()
                ->disableActions()
                ->disableExport();

//            $comments->resource('/admin/users');

//            $comments->id();
            $comments->name();

            $comments->filter(function ($filter) {
                $filter->like('name');
            });
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
        $users = User::get();

        $form = new Form(new Site);

        $form->text(Site::NAME, __('Имя'))->required();
        $form->multipleSelect('users')->options($users->pluck('name', 'id'));

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
