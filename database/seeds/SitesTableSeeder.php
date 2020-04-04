<?php

use Illuminate\Database\Seeder;

use App\Site;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=SitesTableSeeder
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            [Site::NAME => 'Сайт тест'],
            [Site::NAME => 'Сайт тест 2'],
        ];

        Site::insert($sites);
    }
}
