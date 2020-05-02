<?php

use App\Statistic;
use Illuminate\Database\Seeder;

class MigrateStatisticDate extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=MigrateStatisticDate
     *
     * @return void
     */
    public function run()
    {
        $items = Statistic::all();

        foreach ($items as $item) {
          $item->date = $item->created_at;
          $item->save();
        }
    }
}
