<?php

use Illuminate\Database\Seeder;

use App\{
    Category, Plan
};

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=PlanTableSeeder
     *
     * @return void
     */
    public function run()
    {
        Plan::truncate();

        $categories = Category::get();

        $month = date('m');
        $year = date('Y');

        $arr = collect([
            ['name' => 'Телефония', 'count' => 80000],
            ['name' => 'Аксессуары', 'count' => 45000],
            ['name' => 'Услуги', 'count' => 12000],
            ['name' => 'Сетевое оборудование', 'count' => 5000],
            ['name' => 'Смарт гаджеты', 'count' => 8000],
            ['name' => 'НКП', 'count' => 8],
        ]);

        foreach ($categories as $category) {
            $plan = $arr->where('name', $category->name)->first();

            if (!$plan) {
                continue;
            }

            $category->plans()->create([
                Plan::COUNT => $plan['count'],
                Plan::MONTH => $month,
                Plan::YEAR => $year,
            ]);
        }
    }
}
