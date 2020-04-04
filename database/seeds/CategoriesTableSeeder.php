<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=CategoriesTableSeeder
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [Category::NAME => 'Телефония', Category::EFFICIENCY => 15],
            [Category::NAME => 'Аксессуары', Category::EFFICIENCY => 20],
            [Category::NAME => 'Смарт гаджеты', Category::EFFICIENCY => 20],
            [Category::NAME => 'Услуги', Category::EFFICIENCY => 15],
            [Category::NAME => 'Сетевое оборудование', Category::EFFICIENCY => 20],
            [Category::NAME => 'НКП', Category::EFFICIENCY => 10],
        ];

        Category::insert($categories);
    }
}
