<?php

use Encore\Admin\Auth\Database\AdminTablesSeeder as AdminTablesSeederParent;

use Encore\Admin\Auth\Database\Menu;

class AdminTablesSeeder extends AdminTablesSeederParent
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=AdminTablesSeeder
     *
     * @return void
     */
    public function run()
    {
        parent::run();


        Menu::updateOrCreate([
            'title' => 'Категории',
            'uri' => 'categories',
            'icon' => 'fa-list-alt',
        ]);

        Menu::updateOrCreate([
            'title' => 'Магазины',
            'uri' => 'sites',
            'icon' => 'fa-list-alt',
        ]);

        Menu::updateOrCreate([
            'title' => 'Планы',
            'uri' => 'plans',
            'icon' => 'fa-list-alt',
        ]);

        Menu::updateOrCreate([
            'title' => 'Статистика',
            'uri' => 'statistics',
            'icon' => 'fa-list-alt',
        ]);

        Menu::updateOrCreate([
            'title' => 'Статистика',
            'uri' => 'statistics',
            'icon' => 'fa-list-alt',
        ]);

        Menu::updateOrCreate([
            'title' => 'Пользователи',
            'uri' => 'users',
            'icon' => 'fa-users',
        ]);

        Menu::where('title', 'Dashboard')->delete();
    }
}
