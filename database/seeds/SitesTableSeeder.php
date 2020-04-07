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
            [Site::NAME => '№1'],
            [Site::NAME => '№2'],
            [Site::NAME => '№3'],
        ];

        Site::insert($sites);
    }
}
