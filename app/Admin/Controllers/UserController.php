<?php

namespace App\Admin\Controllers;

use App\Site;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use App\User;
use Illuminate\Http\Response;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Пользователи';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->model()->loadMissing('sites');

        $grid->column('name', __('Имя'))->editable()->sortable();
        $grid->column('sites', __('Магазины'))->pluck('name')->label();

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Имя'));
        $show->sites(__('Магазины'), function ($shops) {

            $shops
                ->disableCreateButton()
                ->disableActions()
                ->disableExport();

            $shops->name();

            $shops->filter(function ($filter) {
                $filter->like('name');
            });
        });

        return $show;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        request()->merge(['password' => bcrypt(request()->password)]);

        return $this->form()->update($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store()
    {
        request()->merge(['password' => bcrypt(request()->password)]);

        return $this->form()->store();
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $sites = Site::get();

        $form = new Form(new User);

        $form->text('name', __('Имя'))->required();
        $form->text('email', __('E-mail'))->required();
        $form->multipleSelect('sites', __('Магазины'))->options($sites->pluck(Site::NAME, Site::ID));
        $form->password('password', __('Пароль'));

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
