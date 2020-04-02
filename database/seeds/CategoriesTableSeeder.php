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
            [Category::NAME => 'Телефония', Category::PLAN => 160000, Category::EFFICIENCY => 15],
            [Category::NAME => 'Аксессуары', Category::PLAN => 38000, Category::EFFICIENCY => 20],
            [Category::NAME => 'Смарт гаджеты', Category::PLAN => 6000, Category::EFFICIENCY => 20],
            [Category::NAME => 'Услуги', Category::PLAN => 24000, Category::EFFICIENCY => 15],
            [Category::NAME => 'Припейд (стартовые пакеты)', Category::PLAN => 70, Category::EFFICIENCY => 20],
            [Category::NAME => 'НКП', Category::PLAN => 14, Category::EFFICIENCY => 10],
        ];

        Category::insert($categories);

//        $category = Category::first();
//        $category->statistics()->create([
//            'count' => 500,
//        ]);
//        $category->statistics()->create([
//            'count' => 1500,
//        ]);
    }
}
